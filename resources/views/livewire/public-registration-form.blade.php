<div>
    {{-- Do your work, then step back. --}}
    @if($submitted)
        {{-- SUCCESS STATE --}}
        <div class="bg-white rounded-2xl shadow p-8 text-center">
            <div class="text-5xl mb-4">🎉</div>
            <h1 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Berhasil!</h1>
            <p class="text-gray-500 text-sm mb-6">
                Terima kasih! Pendaftaran anak Anda telah diterima dan sedang menunggu verifikasi pembayaran oleh panitia.
            </p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                <div class="text-xs text-yellow-600 mb-1">Nomor Pendaftaran Anda</div>
                <div class="text-2xl font-bold text-yellow-700 tracking-wider">{{ $registrationNumber }}</div>
                <div class="text-xs text-gray-400 mt-1">Simpan nomor ini untuk cek status pendaftaran</div>
            </div>
            <a href="{{ route('registration.status') }}"
               class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600 transition">
                Cek Status Pendaftaran
            </a>
        </div>

    @else
        {{-- FORM STATE --}}
        @if(!$activePeriod)
            <div class="bg-white rounded-2xl shadow p-8 text-center">
                <div class="text-4xl mb-3">🔒</div>
                <h2 class="font-bold text-gray-700">Pendaftaran Belum Dibuka</h2>
                <p class="text-gray-400 text-sm mt-2">Silakan pantau informasi dari panitia SKS.</p>
            </div>
        @else
            <div class="mb-6 flex items-center gap-4">
                <img src="{{ $activePeriod->event_logo ? Storage::disk('public')->url($activePeriod->event_logo) : 'https://ui-avatars.com/api/?name=S&background=random' }}"
                     alt="Logo SKS"
                     class="w-14 h-14 rounded-full object-cover flex-shrink-0 shadow">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Formulir Pendaftaran</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Sanggar Kitab Suci {{ $activePeriod->year }} — {{ $activePeriod->theme }}
                    </p>
                </div>
            </div>

            <form wire:submit="submit" class="space-y-6">

                {{-- Data Anak --}}
                <div class="bg-white rounded-2xl shadow p-6 space-y-4">
                    <h2 class="font-bold text-gray-700 text-sm uppercase tracking-wide border-b pb-2">Data Anak</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Anak <span class="text-red-500">*</span></label>
                        <input wire:model="child_full_name" type="text" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @error('child_full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan <span class="text-red-500">*</span></label>
                        <input wire:model="nickname" type="text" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @error('nickname') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select wire:model="gender" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">Pilih...</option>
                                <option value="M">Laki-laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                            @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Saat Ini <span class="text-red-500">*</span></label>
                            <select wire:model="grade" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">Pilih...</option>
                                @foreach(range(1,6) as $g)
                                    <option value="{{ $g }}">Kelas {{ $g }}</option>
                                @endforeach
                            </select>
                            @error('grade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="w-full min-w-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <div class="overflow-hidden w-full rounded-lg">
                            <input wire:model="birth_date" type="date" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 appearance-none" style="max-width:100%;box-sizing:border-box;">
                        </div>
                        @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <textarea wire:model="address" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Wilayah <span class="text-red-500">*</span></label>
                            <select wire:model.live="wilayah_id" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">Pilih Wilayah...</option>
                                @foreach($this->wilayahList as $w)
                                    <option value="{{ $w->id }}">{{ $w->name }}</option>
                                @endforeach
                            </select>
                            @error('wilayah_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lingkungan</label>
                            <select wire:model="lingkungan_id" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" @if(!$wilayah_id) disabled @endif>
                                <option value="">Tidak Tahu / Pilih...</option>
                                @foreach($this->lingkunganList as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Lewat <span class="text-red-500">*</span></label>
                            <select wire:model="registration_source" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">Pilih...</option>
                                <option value="BIAK">BIAK</option>
                                <option value="YCK">YCK</option>
                                <option value="UMUM">Umum</option>
                            </select>
                            @error('registration_source') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Kaos <span class="text-red-500">*</span></label>
                            <select wire:model="tshirt_size" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">Pilih...</option>
                                @foreach(['XS','S','M','L','XL','2XL','3XL','4XL'] as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                            @error('tshirt_size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sudah pernah ikut BIAK / YCK? <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input wire:model="has_joined_biak_yck" type="radio" value="1" class="accent-yellow-500">
                                Sudah
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input wire:model="has_joined_biak_yck" type="radio" value="0" class="accent-yellow-500">
                                Belum
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alergi (jika ada)</label>
                        <input wire:model="allergies" type="text" placeholder="contoh: alergi kacang, debu, dll" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan untuk Panitia</label>
                        <textarea wire:model="notes" rows="2" placeholder="Informasi tambahan yang perlu diketahui panitia..." class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                    </div>
                </div>

                {{-- Data Orang Tua --}}
                <div class="bg-white rounded-2xl shadow p-6 space-y-4">
                    <h2 class="font-bold text-gray-700 text-sm uppercase tracking-wide border-b pb-2">Data Orang Tua</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua <span class="text-red-500">*</span></label>
                        <input wire:model="parent_name" type="text" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @error('parent_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Orang Tua <span class="text-red-500">*</span></label>
                        <input wire:model="parent_wa" type="tel" placeholder="08xxxxxxxxxx" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @error('parent_wa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Pembayaran --}}
                <div class="bg-white rounded-2xl shadow p-6 space-y-4">
                    <h2 class="font-bold text-gray-700 text-sm uppercase tracking-wide border-b pb-2">Pembayaran</h2>

                    @if($this->paymentTiers->isEmpty())
                        <p class="text-yellow-600 text-sm">Informasi biaya belum tersedia. Hubungi panitia.</p>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tier Pembayaran <span class="text-red-500">*</span></label>
                            <div class="space-y-2">
                                @foreach($this->paymentTiers as $tier)
                                    <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer hover:border-yellow-400 transition {{ $payment_tier_id == $tier->id ? 'border-yellow-400 bg-yellow-50' : '' }}">
                                        <input wire:model="payment_tier_id" type="radio" value="{{ $tier->id }}" class="text-yellow-500">
                                        <div>
                                            <div class="font-medium text-sm">{{ $tier->name }}</div>
                                            <div class="text-yellow-600 font-bold">Rp {{ number_format($tier->amount, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-400">Berlaku: {{ $tier->valid_from->format('d M') }} – {{ $tier->valid_until->format('d M Y') }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('payment_tier_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    {{-- Donasi Silang --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <p class="text-sm font-semibold text-blue-800 mb-1">Donasi Silang (Sukarela)</p>
                        <p class="text-xs text-blue-700 mb-3">Bagi orang tua yang bersedia, Anda dapat menambahkan donasi sukarela. Dana donasi ini akan digunakan sebagai subsidi silang untuk membantu peserta lain yang membutuhkan keringanan biaya pendaftaran.</p>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Donasi</label>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500 font-medium">Rp</span>
                            <input wire:model.live.debounce.1000ms="donation_amount" type="number" min="0" step="1000"
                                   class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                   placeholder="0">
                        </div>
                        @error('donation_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Info transfer --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-xs text-yellow-800">
                        <p class="font-semibold mb-1">Informasi Transfer</p>
                        <p>Biaya pendaftaran dan donasi (jika ada) <strong>digabung dalam 1 kali transfer</strong>. Upload satu bukti transfer yang mencakup total keduanya.</p>
                        @if($payment_tier_id && $this->paymentTiers->isNotEmpty())
                            @php $selectedTier = $this->paymentTiers->firstWhere('id', $payment_tier_id); @endphp
                            @if($selectedTier)
                                <p class="mt-2">Total transfer: <strong>Rp {{ number_format($selectedTier->amount + $donation_amount, 0, ',', '.') }}</strong>
                                    (Pendaftaran Rp {{ number_format($selectedTier->amount, 0, ',', '.') }}, Donasi Rp {{ number_format($donation_amount, 0, ',', '.') }})
                                </p>
                            @endif
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                        <input wire:model="payment_proof" type="file" accept="image/*" class="w-full border rounded-lg px-3 py-2 text-sm">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks. 2MB</p>
                        @error('payment_proof') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @if($payment_proof)
                            <img src="{{ $payment_proof->temporaryUrl() }}" class="mt-2 rounded-lg max-h-40 object-contain border">
                        @endif
                        <div wire:loading wire:target="payment_proof" class="text-xs text-yellow-500 mt-1">Mengupload...</div>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-xl transition text-sm"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-75">
                    <span wire:loading.remove>Daftar Sekarang →</span>
                    <span wire:loading>Mengirim data...</span>
                </button>

            </form>
        @endif
    @endif

</div>
Total transfer: Rp 350.000 (Pendaftaran Rp 350.000)