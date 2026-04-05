<div>
    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
        <style>
            .sks-form { font-family: 'DM Sans', sans-serif; }
            .sks-form h1, .sks-form h2, .sks-heading { font-family: 'Lora', serif; }

            .sks-card {
                background: #fff;
                border-radius: 20px;
                border: 1px solid #f0e8d8;
                box-shadow: 0 2px 16px 0 rgba(180,140,60,0.06), 0 1px 3px 0 rgba(0,0,0,0.04);
                padding: 1.5rem;
                margin-bottom: 1.25rem;
            }
            @media (min-width: 480px) {
                .sks-card { padding: 2rem; }
            }

            .sks-section-label {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #f5ede0;
            }
            .sks-section-number {
                width: 28px; height: 28px;
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: #fff;
                border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.75rem; font-weight: 700;
                flex-shrink: 0;
                font-family: 'DM Sans', sans-serif;
            }
            .sks-section-title {
                font-family: 'Lora', serif;
                font-size: 1rem; font-weight: 600;
                color: #1c1410;
                letter-spacing: 0.01em;
            }

            .sks-label {
                display: block;
                font-size: 0.8125rem;
                font-weight: 500;
                color: #5c4a32;
                margin-bottom: 0.375rem;
            }
            .sks-input {
                width: 100%;
                border: 1.5px solid #e8dcc8;
                border-radius: 10px;
                padding: 0.625rem 0.875rem;
                font-size: 0.875rem;
                font-family: 'DM Sans', sans-serif;
                color: #1c1410;
                background: #fffdf9;
                transition: border-color 0.2s, box-shadow 0.2s;
                outline: none;
                box-sizing: border-box;
            }
            .sks-input:focus {
                border-color: #f59e0b;
                box-shadow: 0 0 0 3px rgba(245,158,11,0.12);
                background: #fff;
            }
            .sks-input::placeholder { color: #b8a88a; }
            .sks-input:disabled { background: #f9f5ef; color: #a08060; cursor: not-allowed; }

            /* ── Responsive 2-col grid ── */
            .sks-grid-2 {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            @media (min-width: 480px) {
                .sks-grid-2 { grid-template-columns: 1fr 1fr; }
            }

            .sks-radio-card {
                display: flex; align-items: center; gap: 0.875rem;
                border: 1.5px solid #e8dcc8;
                border-radius: 12px;
                padding: 0.875rem 1rem;
                cursor: pointer;
                transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
                background: #fffdf9;
            }
            .sks-radio-card:hover { border-color: #f59e0b; background: #fffbf0; }
            .sks-radio-card.selected {
                border-color: #f59e0b;
                background: linear-gradient(135deg, #fffbf0, #fff8e6);
                box-shadow: 0 2px 8px rgba(245,158,11,0.15);
            }
            .sks-radio-card input[type="radio"] { accent-color: #f59e0b; width: 16px; height: 16px; flex-shrink: 0; }

            .sks-donate-box {
                background: linear-gradient(135deg, #f0f7ff, #e8f2ff);
                border: 1.5px solid #bdd7f5;
                border-radius: 14px;
                padding: 1.25rem;
            }
            .sks-transfer-box {
                background: linear-gradient(135deg, #fffbf0, #fff8e6);
                border: 1.5px solid #f0d080;
                border-radius: 14px;
                padding: 1.25rem;
            }

            .sks-upload-area {
                border: 2px dashed #e8dcc8;
                border-radius: 12px;
                padding: 1.5rem;
                text-align: center;
                background: #fffdf9;
                transition: border-color 0.2s, background 0.2s;
                cursor: pointer;
                position: relative;
            }
            .sks-upload-area:hover { border-color: #f59e0b; background: #fffbf0; }
            .sks-upload-area input[type="file"] {
                position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
            }

            .sks-submit-btn {
                width: 100%;
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: #fff;
                font-family: 'Lora', serif;
                font-size: 1rem;
                font-weight: 700;
                font-style: italic;
                padding: 1rem;
                border-radius: 14px;
                border: none;
                cursor: pointer;
                transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
                box-shadow: 0 4px 16px rgba(217,119,6,0.3);
                letter-spacing: 0.02em;
            }
            .sks-submit-btn:hover:not(:disabled) {
                opacity: 0.92;
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(217,119,6,0.35);
            }
            .sks-submit-btn:active:not(:disabled) { transform: translateY(0); }
            .sks-submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

            .sks-error { color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; }

            .sks-success-card {
                background: #fff;
                border-radius: 24px;
                border: 1px solid #f0e8d8;
                box-shadow: 0 8px 40px rgba(180,140,60,0.1);
                padding: 2.5rem 1.5rem;
                text-align: center;
            }
            @media (min-width: 480px) {
                .sks-success-card { padding: 3rem 2rem; }
            }

            .sks-icon-box {
                width: 56px; height: 56px;
                border-radius: 16px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .sks-icon-box svg { width: 28px; height: 28px; }

            @keyframes sks-fade-up {
                from { opacity: 0; transform: translateY(16px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .sks-card { animation: sks-fade-up 0.4s ease both; }
            .sks-card:nth-child(1) { animation-delay: 0s; }
            .sks-card:nth-child(2) { animation-delay: 0.05s; }
            .sks-card:nth-child(3) { animation-delay: 0.1s; }
            .sks-card:nth-child(4) { animation-delay: 0.15s; }

            @keyframes spin { to { transform: rotate(360deg); } }
        </style>
    @endonce

    <div class="sks-form">

        {{-- ── SUCCESS STATE ───────────────────────────────────────────── --}}
        @if($submitted)
            <div class="sks-success-card" style="animation: sks-fade-up 0.5s ease both;">
                {{-- Heroicon: check-circle --}}
                <div style="width:72px; height:72px; background:linear-gradient(135deg,#ecfdf5,#d1fae5); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem; border:2px solid #6ee7b7;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#059669" style="width:36px;height:36px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h1 class="sks-heading" style="font-size:1.5rem; font-weight:700; color:#1c1410; margin-bottom:0.5rem;">
                    Pendaftaran Berhasil!
                </h1>
                <p style="color:#7a6248; font-size:0.9rem; line-height:1.6; max-width:340px; margin: 0 auto 1.75rem;">
                    Terima kasih! Pendaftaran anak Anda telah diterima dan sedang menunggu verifikasi pembayaran oleh panitia.
                </p>
                <div style="background:linear-gradient(135deg,#fffbf0,#fff3cc); border:1.5px solid #f0d080; border-radius:16px; padding:1.25rem 1.5rem; margin-bottom:1.75rem; display:inline-block; min-width:240px;">
                    <div style="font-size:0.7rem; color:#a07830; letter-spacing:0.08em; text-transform:uppercase; font-weight:600; margin-bottom:0.375rem;">Nomor Pendaftaran Anda</div>
                    <div style="font-family:'Lora',serif; font-size:1.75rem; font-weight:700; color:#92600a; letter-spacing:0.06em;">{{ $registrationNumber }}</div>
                    <div style="font-size:0.7rem; color:#b8a070; margin-top:0.25rem;">Simpan nomor ini untuk cek status pendaftaran</div>
                </div>
                <br>
                <a href="{{ route('registration.status') }}"
                   style="display:inline-block; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; padding:0.75rem 2rem; border-radius:10px; font-size:0.875rem; font-weight:600; text-decoration:none; box-shadow:0 4px 14px rgba(217,119,6,0.3);">
                    Cek Status Pendaftaran →
                </a>
            </div>

        {{-- ── FORM STATE ───────────────────────────────────────────────── --}}
        @else
            @if(!$activePeriod)
                <div class="sks-success-card">
                    {{-- Heroicon: lock-closed --}}
                    <div style="width:64px; height:64px; background:#f5f5f5; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#9ca3af" style="width:32px;height:32px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                    <h2 class="sks-heading" style="font-size:1.25rem; font-weight:700; color:#1c1410; margin-bottom:0.5rem;">Pendaftaran Belum Dibuka</h2>
                    <p style="color:#9c8060; font-size:0.875rem;">Silakan pantau informasi dari panitia SKS.</p>
                </div>
            @else

                {{-- Header --}}
                <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.75rem;">
                    <img src="{{ $activePeriod->event_logo ? Storage::disk('public')->url($activePeriod->event_logo) : asset('images/LOGO-SKS.png') }}"
                         alt="Logo SKS"
                         style="width:56px; height:56px; border-radius:50%; object-fit:cover; flex-shrink:0; box-shadow:0 2px 12px rgba(180,140,60,0.2); border:2px solid #f0d080;">
                    <div>
                        <h1 class="sks-heading" style="font-size:1.4rem; font-weight:700; color:#1c1410; line-height:1.2;">
                            Formulir Pendaftaran
                        </h1>
                        <p style="color:#9c7a48; font-size:0.8125rem; margin-top:0.25rem; font-style:italic;">
                            Sanggar Kitab Suci {{ $activePeriod->year }} — {{ $activePeriod->theme }}
                        </p>
                    </div>
                </div>

                <form wire:submit="submit" style="display:flex; flex-direction:column; gap:1.25rem;">

                    {{-- ── CARD 1: Data Anak ────────────────────────────── --}}
                    <div class="sks-card">
                        <div class="sks-section-label">
                            <div class="sks-section-number">1</div>
                            <span class="sks-section-title">Data Anak</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:1rem;">

                            <div>
                                <label class="sks-label">Nama Lengkap Anak <span style="color:#dc2626;">*</span></label>
                                <input wire:model="child_full_name" type="text" class="sks-input" placeholder="Nama sesuai akta lahir">
                                @error('child_full_name') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="sks-label">Nama Panggilan <span style="color:#dc2626;">*</span></label>
                                <input wire:model="nickname" type="text" class="sks-input" placeholder="Nama sehari-hari">
                                @error('nickname') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="sks-grid-2">
                                <div>
                                    <label class="sks-label">Jenis Kelamin <span style="color:#dc2626;">*</span></label>
                                    <select wire:model="gender" class="sks-input">
                                        <option value="">Pilih...</option>
                                        <option value="M">Laki-laki</option>
                                        <option value="F">Perempuan</option>
                                    </select>
                                    @error('gender') <p class="sks-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="sks-label">Kelas Saat Ini <span style="color:#dc2626;">*</span></label>
                                    <select wire:model="grade" class="sks-input">
                                        <option value="">Pilih...</option>
                                        @foreach(range(1,6) as $g)
                                            <option value="{{ $g }}">Kelas {{ $g }}</option>
                                        @endforeach
                                    </select>
                                    @error('grade') <p class="sks-error">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="sks-label">Tanggal Lahir <span style="color:#dc2626;">*</span></label>
                                <input wire:model="birth_date" type="date" class="sks-input">
                                @error('birth_date') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="sks-label">Alamat Lengkap <span style="color:#dc2626;">*</span></label>
                                <textarea wire:model="address" rows="2" class="sks-input" style="resize:vertical;" placeholder="Jl. ..."></textarea>
                                @error('address') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            <div style="border: 2px solid #dc2626; border-radius: 12px; padding: 1rem 1.125rem; background: #fff8f8;">
                                <label class="sks-label" style="font-weight: 700; font-size: 0.9rem; color: #b91c1c;">Apakah anda umat Paroki Santo Yakobus? <span style="color:#dc2626;">*</span></label>
                                <div style="display:flex; gap:1rem; margin-top:0.5rem; flex-wrap:wrap;">
                                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; font-weight:600; color:#5c4a32; cursor:pointer;">
                                        <input wire:model.live="is_paroki_member" type="radio" value="1" style="accent-color:#f59e0b; width:15px; height:15px;">
                                        Ya, saya umat Paroki Santo Yakobus
                                    </label>
                                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; font-weight:600; color:#5c4a32; cursor:pointer;">
                                        <input wire:model.live="is_paroki_member" type="radio" value="0" style="accent-color:#f59e0b; width:15px; height:15px;">
                                        Tidak
                                    </label>
                                </div>
                                @error('is_paroki_member') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            @if($is_paroki_member)
                                <div>
                                    <label class="sks-label">Wilayah <span style="color:#dc2626;">*</span></label>
                                    <select wire:model.live="wilayah_id" class="sks-input">
                                        <option value="">— Pilih Wilayah —</option>
                                        @foreach($this->wilayahList as $w)
                                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('wilayah_id') <p class="sks-error">{{ $message }}</p> @enderror
                                    <p style="font-size:0.75rem; color:#92835c; margin-top:0.25rem;">Pilih wilayah untuk menyaring pilihan lingkungan, atau biarkan kosong.</p>
                                </div>
                                <div>
                                    <label class="sks-label">Lingkungan</label>
                                    <select wire:model.live="lingkungan_id" class="sks-input">
                                        <option value="">— Pilih Lingkungan —</option>
                                        @foreach($this->lingkunganList as $l)
                                            <option value="{{ $l->id }}">
                                                {{ $l->name }}{{ !$wilayah_id ? ' (' . $l->wilayah->name . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p style="font-size:0.75rem; color:#92835c; margin-top:0.25rem;">Memilih lingkungan akan otomatis mengisi wilayah.</p>
                                </div>
                            @endif

                            <div class="sks-grid-2">
                                <div>
                                    <label class="sks-label">Daftar Lewat <span style="color:#dc2626;">*</span></label>
                                    <select wire:model="registration_source" class="sks-input">
                                        <option value="">Pilih...</option>
                                        <option value="BIAK">BIAK</option>
                                        <option value="YCK">YCK</option>
                                        <option value="UMUM">Umum</option>
                                    </select>
                                    @error('registration_source') <p class="sks-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="sks-label">Ukuran Kaos <span style="color:#dc2626;">*</span></label>
                                    @php
                                        $shirtSizes = [
                                            'S'   => ['panjang' => 39, 'lebar' => 30],
                                            'M'   => ['panjang' => 43, 'lebar' => 32],
                                            'L'   => ['panjang' => 46, 'lebar' => 35],
                                            'XL'  => ['panjang' => 50, 'lebar' => 37],
                                            '2XL' => ['panjang' => 53, 'lebar' => 39],
                                            '3XL' => ['panjang' => 57, 'lebar' => 42],
                                            '4XL' => ['panjang' => 61, 'lebar' => 44],
                                            '5XL' => ['panjang' => 65, 'lebar' => 45],
                                        ];
                                    @endphp
                                    <select wire:model="tshirt_size" class="sks-input">
                                        <option value="">Pilih...</option>
                                        @foreach($shirtSizes as $size => $dim)
                                            <option value="{{ $size }}">{{ $size }} — Panjang {{ $dim['panjang'] }} cm, Lebar {{ $dim['lebar'] }} cm</option>
                                        @endforeach
                                    </select>
                                    @error('tshirt_size') <p class="sks-error">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="sks-label">Sudah pernah ikut BIAK / YCK? <span style="color:#dc2626;">*</span></label>
                                <div style="display:flex; gap:1rem; margin-top:0.375rem;">
                                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; color:#5c4a32; cursor:pointer;">
                                        <input wire:model="has_joined_biak_yck" type="radio" value="1" style="accent-color:#f59e0b; width:15px; height:15px;">
                                        Sudah
                                    </label>
                                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; color:#5c4a32; cursor:pointer;">
                                        <input wire:model="has_joined_biak_yck" type="radio" value="0" style="accent-color:#f59e0b; width:15px; height:15px;">
                                        Belum
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="sks-label">Alergi (jika ada)</label>
                                <input wire:model="allergies" type="text" class="sks-input" placeholder="contoh: alergi kacang, debu, dll">
                            </div>

                            <div>
                                <label class="sks-label">Catatan untuk Panitia</label>
                                <textarea wire:model="notes" rows="2" class="sks-input" style="resize:vertical;" placeholder="Informasi tambahan yang perlu diketahui panitia..."></textarea>
                            </div>

                        </div>
                    </div>

                    {{-- ── CARD 2: Data Orang Tua ───────────────────────── --}}
                    <div class="sks-card">
                        <div class="sks-section-label">
                            <div class="sks-section-number">2</div>
                            <span class="sks-section-title">Data Orang Tua</span>
                        </div>

                        <div class="sks-grid-2">
                            <div>
                                <label class="sks-label">Nama Orang Tua <span style="color:#dc2626;">*</span></label>
                                <input wire:model="parent_name" type="text" class="sks-input" placeholder="Nama lengkap">
                                @error('parent_name') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="sks-label">No. WhatsApp <span style="color:#dc2626;">*</span></label>
                                <input wire:model="parent_whatsapp" type="tel" class="sks-input" placeholder="08xxxxxxxxxx">
                                @error('parent_whatsapp') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── CARD 3: Pembayaran ───────────────────────────── --}}
                    <div class="sks-card">
                        <div class="sks-section-label">
                            <div class="sks-section-number">3</div>
                            <span class="sks-section-title">Pembayaran</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:1.25rem;">

                            {{-- Tier pilihan --}}
                            @if($this->paymentTiers->isEmpty())
                                <div style="display:flex; align-items:flex-start; gap:0.75rem; color:#b45309; font-size:0.875rem; background:#fffbf0; border:1px solid #f0d080; border-radius:10px; padding:0.875rem;">
                                    {{-- Heroicon: exclamation-triangle --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" style="width:20px;height:20px;flex-shrink:0;margin-top:1px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    Informasi biaya belum tersedia. Hubungi panitia.
                                </div>
                            @else
                                <div>
                                    <label class="sks-label" style="margin-bottom:0.625rem;">Pilih Biaya Pendaftaran <span style="color:#dc2626;">*</span></label>
                                    <div style="display:flex; flex-direction:column; gap:0.625rem;">
                                        @foreach($this->paymentTiers as $tier)
                                            <label class="sks-radio-card {{ $payment_tier_id == $tier->id ? 'selected' : '' }}">
                                                <input wire:model="payment_tier_id" type="radio" value="{{ $tier->id }}">
                                                <div style="flex:1;">
                                                    <div style="font-weight:600; font-size:0.875rem; color:#1c1410;">{{ $tier->name }}</div>
                                                    <div style="font-family:'Lora',serif; font-size:1.1rem; font-weight:700; color:#d97706; margin-top:0.125rem;">
                                                        Rp {{ number_format($tier->amount, 0, ',', '.') }}
                                                    </div>
                                                    <div style="font-size:0.7rem; color:#a08060; margin-top:0.125rem;">
                                                        Berlaku: {{ $tier->valid_from->format('d M') }} – {{ $tier->valid_until->format('d M Y') }}
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('payment_tier_id') <p class="sks-error">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            {{-- Donasi Silang --}}
                            <div class="sks-donate-box">
                                <div style="display:flex; align-items:center; gap:0.625rem; margin-bottom:0.5rem;">
                                    {{-- Heroicon: heart --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#1e4d8c" style="width:18px;height:18px;flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                    <p style="font-size:0.875rem; font-weight:600; color:#1e4d8c;">Donasi Silang <span style="font-weight:400; color:#4a7ab5; font-size:0.75rem;">(Sukarela)</span></p>
                                </div>
                                <p style="font-size:0.75rem; color:#4a6fa5; line-height:1.6; margin-bottom:0.875rem;">
                                    Bagi orang tua yang bersedia, Anda dapat menambahkan donasi sukarela yang akan digunakan untuk mensubsidi biaya pendaftaran peserta lain yang membutuhkan bantuan.
                                </p>
                                <label class="sks-label" style="color:#2d5fa0;">Nominal Donasi</label>
                                <div style="display:flex; align-items:center; gap:0.5rem; background:#fff; border:1.5px solid #bdd7f5; border-radius:10px; padding:0 0.75rem;">
                                    <span style="font-size:0.8125rem; color:#4a7ab5; font-weight:500; white-space:nowrap;">Rp</span>
                                    <input wire:model.live.debounce.1000ms="donation_amount" type="number" min="0" step="1000"
                                           style="flex:1; border:none; outline:none; padding:0.625rem 0; font-size:0.875rem; background:transparent; color:#1c1410; font-family:'DM Sans',sans-serif;"
                                           placeholder="0"
                                           onfocus="if(this.value==='0')this.value=''"
                                           onblur="if(this.value==='')this.value='0'">
                                </div>
                                @error('donation_amount') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Info Transfer --}}
                            <div class="sks-transfer-box">
                                <div style="display:flex; align-items:center; gap:0.625rem; margin-bottom:0.5rem;">
                                    {{-- Heroicon: credit-card --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#92600a" style="width:18px;height:18px;flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                    </svg>
                                    <p style="font-size:0.8125rem; font-weight:600; color:#92600a;">Informasi Transfer</p>
                                </div>
                                <p style="font-size:0.75rem; color:#a07830; line-height:1.6;">
                                    Biaya pendaftaran dan donasi (jika ada) <strong>digabung dalam 1 kali transfer</strong>. Upload satu bukti transfer yang mencakup total keduanya.
                                </p>
                                @if($payment_tier_id && $this->paymentTiers->isNotEmpty())
                                    @php $selectedTier = $this->paymentTiers->firstWhere('id', $payment_tier_id); @endphp
                                    @if($selectedTier)
                                        <div style="margin-top:0.75rem; padding-top:0.75rem; border-top:1px dashed #e8c060;">
                                            <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#a07830; margin-bottom:0.25rem;">
                                                <span>Biaya Pendaftaran</span>
                                                <span>Rp {{ number_format($selectedTier->amount, 0, ',', '.') }}</span>
                                            </div>
                                            <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#a07830; margin-bottom:0.5rem;">
                                                <span>Donasi</span>
                                                <span>Rp {{ number_format($donation_amount, 0, ',', '.') }}</span>
                                            </div>
                                            <div style="display:flex; justify-content:space-between; font-size:0.875rem; font-weight:700; color:#7a4f08; border-top:1.5px solid #e8c060; padding-top:0.5rem;">
                                                <span style="font-family:'Lora',serif;">Total Transfer</span>
                                                <span style="font-family:'Lora',serif;">Rp {{ number_format($selectedTier->amount + $donation_amount, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Info Rekening --}}
                            <div style="background:#f0f7ff; border:1.5px solid #bdd7f5; border-radius:12px; padding:0.875rem 1rem;">
                                <div style="display:flex; align-items:center; gap:0.625rem; margin-bottom:0.5rem;">
                                    {{-- Heroicon: building-library --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#1e4d8c" style="width:18px;height:18px;flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                    </svg>
                                    <p style="font-size:0.8125rem; font-weight:600; color:#1e4d8c;">No. Rekening Pendaftaran SKS</p>
                                </div>
                                <div style="display:flex; align-items:center; gap:0.625rem;">
                                    <p id="norek-text" style="font-size:0.9rem; font-weight:700; color:#1c3a6e; font-family:'Lora',serif; letter-spacing:0.02em;">BCA 8622056002</p>
                                    <button type="button" onclick="copyNorek()" id="copy-btn"
                                        style="display:inline-flex; align-items:center; gap:0.3rem; padding:0.25rem 0.625rem; border-radius:6px; border:1.5px solid #bdd7f5; background:#fff; color:#1e4d8c; font-size:0.7rem; font-weight:600; cursor:pointer; transition:all 0.15s; font-family:'DM Sans',sans-serif;">
                                        <svg id="copy-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                        </svg>
                                        <span id="copy-label">Copy</span>
                                    </button>
                                </div>
                                <p style="font-size:0.75rem; color:#4a6fa5; margin-top:0.125rem;">a.n. BGKP Santo Yakobus</p>
                            </div>

                            {{-- Upload Bukti --}}
                            <div>
                                <label class="sks-label">Bukti Transfer <span style="color:#dc2626;">*</span></label>

                                <div x-data="{ preview: null }"
                                     class="sks-upload-area"
                                     :style="preview ? 'border-color:#f59e0b; background:#fffbf0;' : ''">
                                    <input wire:model="payment_proof" type="file" accept="image/*"
                                           x-on:change="
                                               const f = $event.target.files[0];
                                               if (f) { const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f); }
                                           ">

                                    {{-- Spinner during upload --}}
                                    <div wire:loading wire:target="payment_proof" style="padding:1rem 0;">
                                        <div style="display:inline-block; width:24px; height:24px; border:3px solid #f0d080; border-top-color:#f59e0b; border-radius:50%; animation:spin 0.7s linear infinite;"></div>
                                        <p style="font-size:0.8125rem; color:#a07830; margin-top:0.5rem;">Mengupload gambar...</p>
                                    </div>

                                    {{-- Content when not uploading --}}
                                    <div wire:loading.remove wire:target="payment_proof">
                                        {{-- Preview --}}
                                        <div x-show="preview !== null">
                                            <img :src="preview" style="max-height:180px; border-radius:8px; object-fit:contain; margin:0 auto; display:block;">
                                            <p style="font-size:0.7rem; color:#a07830; margin-top:0.5rem;">Tap untuk ganti gambar</p>
                                        </div>
                                        {{-- Placeholder --}}
                                        <div x-show="preview === null">
                                            {{-- Heroicon: arrow-up-tray --}}
                                            <div style="display:flex; justify-content:center; margin-bottom:0.5rem;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#c8a870" style="width:36px;height:36px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                                </svg>
                                            </div>
                                            <p style="font-size:0.8125rem; font-weight:500; color:#7a6248;">Tap untuk upload bukti transfer</p>
                                            <p style="font-size:0.7rem; color:#b8a070; margin-top:0.25rem;">JPG, PNG · Maks. 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                @error('payment_proof') <p class="sks-error" style="margin-top:0.375rem;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Payer Name --}}
                            <div>
                                <label class="sks-label">Nama Rekening Pengirim <span style="color:#dc2626;">*</span></label>
                                <p style="font-size:0.75rem; font-weight:700; color:#b91c1c; margin-bottom:0.375rem;">⚠ WAJIB sesuai dengan NAMA PEMILIK REKENING yang melakukan transfer. Data yang tidak sesuai akan ditolak oleh panitia.</p>
                                <input wire:model="payer_name" type="text" class="sks-input">
                                @error('payer_name') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Payment Date --}}
                            <div>
                                <label class="sks-label">Tanggal Transfer <span style="color:#dc2626;">*</span></label>
                                <p style="font-size:0.75rem; color:#92835c; margin-bottom:0.375rem;">Tanggal saat Anda melakukan transfer pembayaran</p>
                                <input wire:model="payment_date" type="date" class="sks-input" max="{{ date('Y-m-d') }}">
                                @error('payment_date') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>

                    {{-- ── Submit ───────────────────────────────────────── --}}
                    <button type="button"
                            id="sks-submit-btn"
                            class="sks-submit-btn"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75"
                            wire:target="payment_proof,submit">
                        <span wire:loading.remove wire:target="submit">Daftar Sekarang →</span>
                        <span wire:loading wire:target="submit">Mengirim data...</span>
                    </button>

                    <p style="text-align:center; font-size:0.7rem; color:#b8a070; margin-top:-0.5rem;">
                        Dengan mendaftar, Anda menyetujui ketentuan yang berlaku dari panitia SKS Santo Yakobus.
                    </p>

                </form>
            @endif
        @endif

    </div>

    @if(!$submitted)
    <script>
        // ── Submit confirmation dialog ─────────────────────────────────────
        document.getElementById('sks-submit-btn').addEventListener('click', function () {
            Swal.fire({
                title: 'Konfirmasi Pendaftaran',
                html: `
                    <p style="font-size:0.9rem;color:#374151;line-height:1.6;">
                        Pastikan semua data yang Anda isi sudah <strong>benar dan lengkap</strong>, terutama:
                    </p>
                    <ul style="text-align:left;font-size:0.85rem;color:#374151;margin-top:0.75rem;line-height:1.8;padding-left:1.25rem;">
                        <li>✅ Data anak &amp; orang tua sudah sesuai</li>
                        <li>✅ Bukti pembayaran sudah diunggah</li>
                        <li>⚠️ <strong>Nama rekening pengirim wajib sesuai</strong> dengan nama yang melakukan transfer</li>
                    </ul>
                    <p style="font-size:0.8rem;color:#dc2626;margin-top:0.875rem;font-weight:600;">
                        Data pembayaran yang tidak sesuai dapat menyebabkan registrasi Anda ditolak oleh panitia.
                    </p>
                `,
                icon: 'question',
                confirmButtonText: 'Ya, data sudah benar — Daftar!',
                confirmButtonColor: '#d97706',
                showCancelButton: false,
                footer: '<button type="button" id="swal-back-check-btn" style="background:none;border:none;padding:0;font-size:0.75rem;color:#9ca3af;text-decoration:underline;cursor:pointer;font-family:inherit;">Kembali, saya ingin periksa ulang</button>',
                didOpen: function () {
                    document.getElementById('swal-back-check-btn').addEventListener('click', function () {
                        Swal.close();
                    });
                },
            }).then(function (result) {
                if (result.isConfirmed) {
                    const form = document.querySelector('form[wire\\:submit]');
                    if (form) form.requestSubmit();
                }
            });
        });

        // ── Shared leave-confirmation dialog ──────────────────────────────
        function confirmLeave(onLeave) {
            Swal.fire({
                title: 'Tinggalkan halaman ini?',
                text: 'Progres pendaftaran Anda belum tersimpan dan akan hilang.',
                icon: 'warning',
                confirmButtonText: 'Batal, lanjut daftar',
                confirmButtonColor: '#d97706',
                showCancelButton: false,
                footer: '<button type="button" id="swal-leave-btn" style="background:none;border:none;padding:0;font-size:0.75rem;color:#9ca3af;text-decoration:underline;cursor:pointer;font-family:inherit;">Ya, tinggalkan halaman</button>',
                didOpen: function () {
                    document.getElementById('swal-leave-btn').addEventListener('click', function () {
                        Swal.close();
                        onLeave();
                    });
                },
            });
        }

        // ── Header link guard ──────────────────────────────────────────────
        document.querySelectorAll('.site-header a:not([target="_blank"])').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const dest = this.href;
                confirmLeave(function () { window.location.href = dest; });
            });
        });

        // ── Back button guard ──────────────────────────────────────────────
        history.pushState(null, '', window.location.href);

        function onPopState() {
            history.pushState(null, '', window.location.href);
            confirmLeave(function () {
                window.removeEventListener('popstate', onPopState);
                history.go(-2);
            });
        }

        window.addEventListener('popstate', onPopState);
    </script>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showValidationErrors', ({ errors }) => {
                const list = errors.map(e => `<li style="text-align:left; margin:0.2rem 0;">• ${e}</li>`).join('');
                Swal.fire({
                    title: 'Ada yang belum lengkap',
                    html: `<ul style="list-style:none; padding:0; margin:0; font-size:0.875rem; color:#4b3a2a;">${list}</ul>`,
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya perbaiki',
                    confirmButtonColor: '#d97706',
                    customClass: { popup: 'swal-compact' },
                });
            });
        });

        function copyNorek() {
            navigator.clipboard.writeText('8622056002').then(function () {
                const btn   = document.getElementById('copy-btn');
                const label = document.getElementById('copy-label');
                const icon  = document.getElementById('copy-icon');

                label.textContent      = 'No. Rekening Tercopy!';
                btn.style.background   = '#ecfdf5';
                btn.style.borderColor  = '#6ee7b7';
                btn.style.color        = '#065f46';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>';

                setTimeout(function () {
                    label.textContent      = 'Salin';
                    btn.style.background   = '#fff';
                    btn.style.borderColor  = '#bdd7f5';
                    btn.style.color        = '#1e4d8c';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>';
                }, 2000);
            });
        }
    </script>
</div>
