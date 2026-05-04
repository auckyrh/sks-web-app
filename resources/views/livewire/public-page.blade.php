<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- Navigation tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
        @foreach([
            'rundown'     => ['label' => 'Rundown', 'url' => "/{$year}/rundown"],
            'tata_tertib' => ['label' => 'Tata Tertib', 'url' => "/{$year}/tata-tertib"],
            'informasi'   => ['label' => 'Informasi', 'url' => "/{$year}/informasi"],
            'kontak'      => ['label' => 'Kontak', 'url' => "/{$year}/kontak"],
            'kelompok'    => ['label' => 'Kelompok', 'url' => "/{$year}/kelompok"],
        ] as $key => $item)
            <a href="{{ $item['url'] }}"
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
               {{ $type === $key
                   ? 'bg-yellow-500 text-white'
                   : 'bg-white text-gray-600 border hover:border-yellow-400' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>

    @if(!$page)
        <div class="bg-white rounded-2xl shadow p-8 text-center">
            <div class="text-4xl mb-3">📄</div>
            <h2 class="font-bold text-gray-700">Halaman belum tersedia</h2>
            <p class="text-gray-400 text-sm mt-2">
                Konten sedang disiapkan oleh panitia SKS {{ $year }}.
            </p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $page->title }}</h1>
            <div class="prose prose-sm max-w-none text-gray-700">
                {!! $page->content !!}
            </div>
        </div>
    @endif
</div>
