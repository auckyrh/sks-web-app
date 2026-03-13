<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Cek Status Pendaftaran</h1>
        <p class="text-gray-500 text-sm mt-1">Masukkan nomor pendaftaran atau nomor WhatsApp orang tua</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <div class="flex gap-2 mb-4">
            <button wire:click="$set('searchType', 'registration_number')"
                    class="flex-1 py-2 text-sm rounded-lg border transition {{ $searchType === 'registration_number' ? 'bg-yellow-500 text-white border-yellow-500' : 'text-gray-600' }}">
                No. Pendaftaran
            </button>
            <button wire:click="$set('searchType', 'parent_wa')"
                    class="flex-1 py-2 text-sm rounded-lg border transition {{ $searchType === 'parent_wa' ? 'bg-yellow-500 text-white border-yellow-500' : 'text-gray-600' }}">
                No. WhatsApp
            </button>
        </div>

        <div class="flex gap-2">
            <input wire:model="search" type="text"
                   placeholder="{{ $searchType === 'registration_number' ? 'SKS-2026-0001' : '08xxxxxxxxxx' }}"
                   class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <button wire:click="check"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600 transition">
                Cek
            </button>
        </div>
        @error('search') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    @if($searched)
        @if(count($results) === 0)
            <div class="bg-white rounded-2xl shadow p-6 text-center text-gray-500 text-sm">
                Data tidak ditemukan. Pastikan nomor yang dimasukkan benar.
            </div>
        @else
            <div class="space-y-4">
                @foreach($results as $reg)
                    <div class="bg-white rounded-2xl shadow p-5">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <div class="font-bold text-gray-800">{{ $reg->child_full_name }}</div>
                                <div class="text-xs text-gray-400">{{ $reg->registration_number }}</div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full font-medium
                                {{ $reg->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                   ($reg->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($reg->status) }}
                            </span>
                        </div>
                        <div class="text-sm space-y-1 text-gray-600">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Kelas</span>
                                <span>Kelas {{ $reg->grade }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Kelompok</span>
                                <span>{{ $reg->participant?->eventClass?->saint_name ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Pembayaran</span>
                                <span class="font-medium
                                    {{ $reg->payment_status === 'verified' ? 'text-green-600' :
                                       ($reg->payment_status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ ucfirst($reg->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Tgl Daftar</span>
                                <span>{{ $reg->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <div class="text-center mt-6">
        <a href="{{ route('registration.form') }}" class="text-yellow-600 text-sm hover:underline">
            ← Kembali ke Formulir Pendaftaran
        </a>
    </div>
</div>
