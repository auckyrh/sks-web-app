<div>
    {{-- Navigation tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
        @foreach([
            'rundown'     => ['label' => 'Rundown',    'url' => "/{$period->year}/rundown"],
            'tata_tertib' => ['label' => 'Tata Tertib', 'url' => "/{$period->year}/tata-tertib"],
            'informasi'   => ['label' => 'Informasi',  'url' => "/{$period->year}/informasi"],
            'kontak'      => ['label' => 'Kontak',     'url' => "/{$period->year}/kontak"],
            'kelompok'    => ['label' => 'Kelompok',   'url' => "/{$period->year}/kelompok"],
        ] as $key => $item)
            <a href="{{ $item['url'] }}"
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
               {{ request()->segment(2) === 'kelompok'
                   ? ($key === 'kelompok' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 border hover:border-yellow-400')
                   : 'bg-white text-gray-600 border hover:border-yellow-400' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>

    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Kelompok</h1>
        <p class="text-gray-500 text-sm mt-1">SKS {{ $period->year }} — {{ $period->theme }}</p>
    </div>

    @if($classes->isEmpty())
        <div class="bg-white rounded-2xl shadow p-8 text-center">
            <div class="text-4xl mb-3">👥</div>
            <h2 class="font-bold text-gray-700">Data kelompok belum tersedia</h2>
            <p class="text-gray-400 text-sm mt-2">Pembagian kelompok sedang disiapkan oleh panitia SKS {{ $period->year }}.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($classes as $class)
                <div>
                    <h2 class="text-lg font-bold text-gray-700 mb-3">
                        Kelas {{ $class->level }} — {{ $class->saint_name }}
                    </h2>

                    @if($class->teams->isEmpty())
                        <p class="text-gray-400 text-sm italic">Belum ada tim di kelas ini.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($class->teams as $team)
                                <div class="bg-white rounded-2xl shadow p-5">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-bold text-gray-800">{{ $team->name }}</h3>
                                        <span class="text-xs bg-yellow-100 text-yellow-700 font-semibold px-2 py-0.5 rounded-full">
                                            Tim {{ $team->number }}
                                        </span>
                                    </div>

                                    @if($team->facilitators->isNotEmpty())
                                        <div class="mb-3 flex flex-wrap gap-1">
                                            @foreach($team->facilitators as $facilitator)
                                                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                                                    {{ $facilitator->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($team->participants->isEmpty())
                                        <p class="text-gray-400 text-xs italic">Belum ada peserta.</p>
                                    @else
                                        <ol class="space-y-1">
                                            @foreach($team->participants as $i => $participant)
                                                <li class="flex items-center gap-2 text-sm text-gray-700">
                                                    <span class="text-gray-400 w-5 text-right shrink-0">{{ $i + 1 }}.</span>
                                                    <span>{{ $participant->nickname ?: $participant->child_full_name }}</span>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>