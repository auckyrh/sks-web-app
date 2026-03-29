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
                padding: 2rem;
                margin-bottom: 1.25rem;
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
                padding: 3rem 2rem;
                text-align: center;
            }

            @keyframes sks-fade-up {
                from { opacity: 0; transform: translateY(16px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .sks-card { animation: sks-fade-up 0.4s ease both; }
            .sks-card:nth-child(1) { animation-delay: 0s; }
            .sks-card:nth-child(2) { animation-delay: 0.05s; }
            .sks-card:nth-child(3) { animation-delay: 0.1s; }
            .sks-card:nth-child(4) { animation-delay: 0.15s; }
        </style>
    @endonce

    <div class="sks-form">

        {{-- ── SUCCESS STATE ───────────────────────────────────────────── --}}
        @if($submitted)
            <div class="sks-success-card" style="animation: sks-fade-up 0.5s ease both;">
                <div style="font-size:3.5rem; margin-bottom:1rem;">🎉</div>
                <h1 class="sks-heading" style="font-size:1.5rem; font-weight:700; color:#1c1410; margin-bottom:0.5rem;">
                    Pendaftaran Berhasil!
                </h1>
                <p style="color:#7a6248; font-size:0.9rem; line-height:1.6; max-width:340px; margin: 0 auto 1.75rem;">
                    Terima kasih! Pendaftaran anak Anda telah diterima dan sedang menunggu verifikasi pembayaran oleh panitia.
                </p>
                <div style="background: linear-gradient(135deg,#fffbf0,#fff3cc); border:1.5px solid #f0d080; border-radius:16px; padding:1.25rem 1.5rem; margin-bottom:1.75rem; display:inline-block; min-width:240px;">
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
                    <div style="font-size:3rem; margin-bottom:1rem;">🔒</div>
                    <h2 class="sks-heading" style="font-size:1.25rem; font-weight:700; color:#1c1410; margin-bottom:0.5rem;">Pendaftaran Belum Dibuka</h2>
                    <p style="color:#9c8060; font-size:0.875rem;">Silakan pantau informasi dari panitia SKS.</p>
                </div>
            @else

                {{-- Header --}}
                <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.75rem;">
                    <img src="{{ $activePeriod->event_logo ? Storage::disk('public')->url($activePeriod->event_logo) : 'https://ui-avatars.com/api/?name=S&background=random' }}"
                         alt="Logo SKS"
                         style="width:56px; height:56px; border-radius:50%; object-fit:cover; flex-shrink:0; box-shadow:0 2px 12px rgba(180,140,60,0.2); border:2px solid #f0d080;">
                    <div>
                        <h1 class="sks-heading" style="font-size:1.5rem; font-weight:700; color:#1c1410; line-height:1.2;">
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

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
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
                                <input wire:model="birth_date" type="date" class="sks-input" style="max-width:100%; box-sizing:border-box;">
                                @error('birth_date') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="sks-label">Alamat Lengkap <span style="color:#dc2626;">*</span></label>
                                <textarea wire:model="address" rows="2" class="sks-input" style="resize:vertical;" placeholder="Jl. ..."></textarea>
                                @error('address') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="sks-label">Apakah anda umat Paroki Santo Yakobus? <span style="color:#dc2626;">*</span></label>
                                <div style="display:flex; gap:1rem; margin-top:0.375rem;">
                                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; color:#5c4a32; cursor:pointer;">
                                        <input wire:model.live="is_paroki_member" type="radio" :value="true" value="1" style="accent-color:#f59e0b; width:15px; height:15px;">
                                        Ya, saya umat Paroki Santo Yakobus
                                    </label>
                                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; color:#5c4a32; cursor:pointer;">
                                        <input wire:model.live="is_paroki_member" type="radio" :value="false" value="0" style="accent-color:#f59e0b; width:15px; height:15px;">
                                        Tidak
                                    </label>
                                </div>
                                @error('is_paroki_member') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            @if($is_paroki_member)
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
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
                            </div>
                            @endif

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
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

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                            <div>
                                <label class="sks-label">Nama Orang Tua <span style="color:#dc2626;">*</span></label>
                                <input wire:model="parent_name" type="text" class="sks-input" placeholder="Nama lengkap">
                                @error('parent_name') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="sks-label">No. WhatsApp <span style="color:#dc2626;">*</span></label>
                                <input wire:model="parent_wa" type="tel" class="sks-input" placeholder="08xxxxxxxxxx">
                                @error('parent_wa') <p class="sks-error">{{ $message }}</p> @enderror
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
                                <p style="color:#b45309; font-size:0.875rem; background:#fffbf0; border:1px solid #f0d080; border-radius:10px; padding:0.875rem;">
                                    ⚠️ Informasi biaya belum tersedia. Hubungi panitia.
                                </p>
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
                                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                                    <span style="font-size:1rem;">🤝</span>
                                    <p style="font-size:0.875rem; font-weight:600; color:#1e4d8c;">Donasi Silang <span style="font-weight:400; color:#4a7ab5; font-size:0.75rem;">(Sukarela)</span></p>
                                </div>
                                <p style="font-size:0.75rem; color:#4a6fa5; line-height:1.6; margin-bottom:0.875rem;">
                                    Bagi orang tua yang bersedia, Anda dapat menambahkan donasi sukarela yang akan digunakan untuk mensubsidi biaya pendaftaran peserta lain yang membutuhkan bantuan.
                                </p>
                                <label class="sks-label" style="color:#2d5fa0;">Nominal Donasi</label>
                                <div style="display:flex; align-items:center; gap:0.5rem; background:#fff; border:1.5px solid #bdd7f5; border-radius:10px; padding:0 0.75rem; transition: border-color 0.2s;">
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
                                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                                    <span style="font-size:1rem;">💳</span>
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
                                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                                    <span style="font-size:1rem;">🏦</span>
                                    <p style="font-size:0.8125rem; font-weight:600; color:#1e4d8c;">No. Rekening Pendaftaran SKS</p>
                                </div>
                                <p style="font-size:0.9rem; font-weight:700; color:#1c3a6e; font-family:'Lora',serif; letter-spacing:0.02em;">BCA 862-2056002</p>
                                <p style="font-size:0.75rem; color:#4a6fa5; margin-top:0.125rem;">a.n. BGKP Santo Yakobus</p>
                            </div>

                            {{-- Upload Bukti --}}
                            <div>
                                <label class="sks-label">Bukti Transfer <span style="color:#dc2626;">*</span></label>

                                <div class="sks-upload-area" style="{{ $payment_proof ? 'border-color:#f59e0b; background:#fffbf0;' : '' }}">
                                    <input wire:model="payment_proof" type="file" accept="image/*">
                                    @if($payment_proof)
                                        <div wire:loading.remove wire:target="payment_proof">
                                            <img src="{{ $payment_proof->temporaryUrl() }}" style="max-height:180px; border-radius:8px; object-fit:contain; margin:0 auto; display:block;">
                                            <p style="font-size:0.7rem; color:#a07830; margin-top:0.5rem;">Tap untuk ganti gambar</p>
                                        </div>
                                    @else
                                        <div wire:loading.remove wire:target="payment_proof">
                                            <div style="font-size:2rem; margin-bottom:0.5rem;">📎</div>
                                            <p style="font-size:0.8125rem; font-weight:500; color:#7a6248;">Tap untuk upload bukti transfer</p>
                                            <p style="font-size:0.7rem; color:#b8a070; margin-top:0.25rem;">JPG, PNG · Maks. 2MB</p>
                                        </div>
                                    @endif
                                    <div wire:loading wire:target="payment_proof" style="padding:1rem 0;">
                                        <div style="display:inline-block; width:24px; height:24px; border:3px solid #f0d080; border-top-color:#f59e0b; border-radius:50%; animation:spin 0.7s linear infinite;"></div>
                                        <p style="font-size:0.8125rem; color:#a07830; margin-top:0.5rem;">Mengupload gambar...</p>
                                    </div>
                                </div>

                                @error('payment_proof') <p class="sks-error" style="margin-top:0.375rem;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Payer Name --}}
                            <div>
                                <label class="sks-label">Nama Rekening Pengirim <span style="color:#dc2626;">*</span></label>
                                <input wire:model="payer_name" type="text" class="sks-input" placeholder="Nama sesuai rekening yang digunakan untuk transfer">
                                @error('payer_name') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>

                    {{-- ── Submit ───────────────────────────────────────── --}}
                    <button type="submit"
                            class="sks-submit-btn"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75"
                            wire:target="payment_proof,submit">
                        <span wire:loading.remove wire:target="submit">Daftar Sekarang →</span>
                        <span wire:loading wire:target="submit">Mengirim data...</span>
                        <span wire:loading wire:target="payment_proof" style="display:none;">Menunggu upload selesai...</span>
                    </button>

                    <p style="text-align:center; font-size:0.7rem; color:#b8a070; margin-top:-0.5rem;">
                        Dengan mendaftar, Anda menyetujui ketentuan yang berlaku dari panitia SKS Santo Yakobus.
                    </p>

                </form>
            @endif
        @endif

    </div>

    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</div>
