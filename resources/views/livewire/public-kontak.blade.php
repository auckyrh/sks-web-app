<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    {{-- Navigation tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
        @foreach([
            ['label' => 'Rundown', 'url' => "/{$period->year}/rundown"],
            ['label' => 'Tata Tertib', 'url' => "/{$period->year}/tata-tertib"],
            ['label' => 'Informasi', 'url' => "/{$period->year}/informasi"],
            ['label' => 'Kontak', 'url' => "/{$period->year}/kontak"],
            ['label' => 'Kelompok', 'url' => "/{$period->year}/kelompok"],
        ] as $item)
            <a href="{{ $item['url'] }}"
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
               {{ request()->segment(2) === 'kontak'
                   ? 'bg-yellow-500 text-white'
                   : 'bg-white text-gray-600 border hover:border-yellow-400' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>

    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Kontak Panitia</h1>
        <p class="text-gray-500 text-sm mt-1">SKS {{ $period->year }} — {{ $period->theme }}</p>
    </div>

    @if($contacts->isEmpty())
        <div class="bg-white rounded-2xl shadow p-8 text-center">
            <div class="text-4xl mb-3">📞</div>
            <h2 class="font-bold text-gray-700">Kontak belum tersedia</h2>
        </div>
    @else
        <div class="space-y-4">
            @foreach($contacts as $category => $items)
                <div class="bg-white rounded-2xl shadow p-5">
                    <h2 class="font-bold text-gray-700 text-sm uppercase tracking-wide
                               border-b pb-2 mb-3">
                        {{ $category }}
                    </h2>
                    <div class="space-y-3">
                        @foreach($items as $contact)
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-800 text-sm">
                                        {{ $contact->name }}
                                    </div>
                                    @if($contact->role)
                                        <div class="text-xs text-gray-400">{{ $contact->role }}</div>
                                    @endif
                                </div>
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $contact->whatsapp) }}"
                                   target="_blank"
                                   class="flex items-center gap-1 bg-green-500 text-white
                                          px-3 py-1 rounded-full text-xs font-medium hover:bg-green-600 transition">
                                    <span>💬</span> WA
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>