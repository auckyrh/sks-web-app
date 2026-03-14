<div>
    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
        <style>
            .crs-wrap { font-family: 'DM Sans', sans-serif; }
            .crs-heading { font-family: 'Lora', serif; }

            .crs-card {
                background: #fff;
                border-radius: 20px;
                border: 1px solid #f0e8d8;
                box-shadow: 0 2px 16px rgba(180,140,60,0.07), 0 1px 3px rgba(0,0,0,0.04);
                padding: 1.75rem;
            }

            .crs-tab {
                flex: 1;
                padding: 0.6rem 0.75rem;
                font-size: 0.8125rem;
                font-weight: 500;
                border-radius: 10px;
                border: 1.5px solid #e8dcc8;
                background: #fffdf9;
                color: #9c7a48;
                cursor: pointer;
                transition: all 0.2s;
                font-family: 'DM Sans', sans-serif;
            }
            .crs-tab:hover { border-color: #f59e0b; color: #b45309; }
            .crs-tab.active {
                background: linear-gradient(135deg, #f59e0b, #d97706);
                border-color: transparent;
                color: #fff;
                box-shadow: 0 3px 10px rgba(217,119,6,0.25);
            }

            .crs-input {
                flex: 1;
                border: 1.5px solid #e8dcc8;
                border-radius: 10px;
                padding: 0.65rem 0.875rem;
                font-size: 0.875rem;
                font-family: 'DM Sans', sans-serif;
                color: #1c1410;
                background: #fffdf9;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .crs-input:focus {
                border-color: #f59e0b;
                box-shadow: 0 0 0 3px rgba(245,158,11,0.12);
                background: #fff;
            }
            .crs-input::placeholder { color: #c4a87a; }

            .crs-btn {
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: #fff;
                padding: 0.65rem 1.25rem;
                border-radius: 10px;
                border: none;
                font-size: 0.875rem;
                font-weight: 600;
                font-family: 'DM Sans', sans-serif;
                cursor: pointer;
                transition: opacity 0.2s, transform 0.15s;
                white-space: nowrap;
                box-shadow: 0 3px 10px rgba(217,119,6,0.25);
            }
            .crs-btn:hover { opacity: 0.9; transform: translateY(-1px); }
            .crs-btn:active { transform: translateY(0); }

            .crs-result-card {
                background: #fff;
                border-radius: 18px;
                border: 1px solid #f0e8d8;
                box-shadow: 0 2px 14px rgba(180,140,60,0.07);
                overflow: hidden;
                animation: crs-fade-up 0.35s ease both;
            }

            .crs-result-header {
                padding: 1.125rem 1.25rem;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 0.75rem;
                border-bottom: 1px solid #f5ede0;
            }

            .crs-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.6rem 1.25rem;
                font-size: 0.8125rem;
                border-bottom: 1px solid #faf4eb;
            }
            .crs-row:last-child { border-bottom: none; }
            .crs-row-label { color: #b8a070; font-size: 0.75rem; }
            .crs-row-val { color: #3c2a10; font-weight: 500; }

            .crs-badge {
                font-size: 0.7rem;
                font-weight: 600;
                padding: 0.25rem 0.65rem;
                border-radius: 99px;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }
            .badge-confirmed { background: #dcfce7; color: #166534; }
            .badge-pending   { background: #fef9c3; color: #854d0e; }
            .badge-cancelled { background: #fee2e2; color: #991b1b; }

            .pay-verified { color: #16a34a; font-weight: 600; }
            .pay-pending  { color: #d97706; font-weight: 600; }
            .pay-rejected { color: #dc2626; font-weight: 600; }

            @keyframes crs-fade-up {
                from { opacity:0; transform:translateY(14px); }
                to   { opacity:1; transform:translateY(0); }
            }
            .crs-result-card:nth-child(1) { animation-delay: 0s; }
            .crs-result-card:nth-child(2) { animation-delay: 0.06s; }
            .crs-result-card:nth-child(3) { animation-delay: 0.12s; }
        </style>
    @endonce

    <div class="crs-wrap">

        {{-- Header --}}
        <div style="margin-bottom:1.5rem;">
            <h1 class="crs-heading" style="font-size:1.5rem; font-weight:700; color:#1c1410; line-height:1.2;">
                Cek Status Pendaftaran
            </h1>
            <p style="color:#9c7a48; font-size:0.8125rem; margin-top:0.3rem; font-style:italic;">
                Masukkan nomor pendaftaran atau nomor WhatsApp orang tua
            </p>
        </div>

        {{-- Search Card --}}
        <div class="crs-card" style="margin-bottom:1.25rem;">

            {{-- Tabs --}}
            <div style="display:flex; gap:0.5rem; margin-bottom:1rem;">
                <button wire:click="$set('searchType', 'registration_number')"
                        class="crs-tab {{ $searchType === 'registration_number' ? 'active' : '' }}">
                    🔖 No. Pendaftaran
                </button>
                <button wire:click="$set('searchType', 'parent_wa')"
                        class="crs-tab {{ $searchType === 'parent_wa' ? 'active' : '' }}">
                    📱 No. WhatsApp
                </button>
            </div>

            {{-- Search Input --}}
            <div style="display:flex; gap:0.625rem;">
                <input wire:model="search"
                       wire:keydown.enter="check"
                       type="text"
                       placeholder="{{ $searchType === 'registration_number' ? 'SKS-2026-0001' : '08xxxxxxxxxx' }}"
                       class="crs-input">
                <button wire:click="check" class="crs-btn">
                    <span wire:loading.remove wire:target="check">Cek</span>
                    <span wire:loading wire:target="check">...</span>
                </button>
            </div>
            @error('search')
                <p style="color:#dc2626; font-size:0.75rem; margin-top:0.375rem;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Results --}}
        @if($searched)
            @if(count($results) === 0)
                <div class="crs-card" style="text-align:center; padding:2.5rem 1.5rem;">
                    <div style="font-size:2.5rem; margin-bottom:0.75rem;">🔍</div>
                    <p style="font-family:'Lora',serif; font-weight:600; color:#5c4032; font-size:1rem; margin-bottom:0.375rem;">
                        Data Tidak Ditemukan
                    </p>
                    <p style="font-size:0.8125rem; color:#b8a070; line-height:1.6;">
                        Pastikan nomor yang dimasukkan sudah benar.<br>Hubungi panitia jika masalah berlanjut.
                    </p>
                </div>
            @else
                <div style="display:flex; flex-direction:column; gap:0.875rem;">
                    @foreach($results as $i => $reg)
                        @php
                            $statusClass = match($reg->status) {
                                'confirmed' => 'badge-confirmed',
                                'cancelled' => 'badge-cancelled',
                                default     => 'badge-pending',
                            };
                            $statusLabel = match($reg->status) {
                                'confirmed' => '✓ Terdaftar',
                                'cancelled' => '✕ Dibatalkan',
                                default     => '⏳ Menunggu',
                            };
                            $payClass = match($reg->payment_status) {
                                'verified' => 'pay-verified',
                                'rejected' => 'pay-rejected',
                                default    => 'pay-pending',
                            };
                            $payLabel = match($reg->payment_status) {
                                'verified' => '✓ Terverifikasi',
                                'rejected' => '✕ Ditolak',
                                default    => '⏳ Menunggu Verifikasi',
                            };
                        @endphp
                        <div class="crs-result-card" style="animation-delay:{{ $i * 0.07 }}s;">

                            {{-- Card Header --}}
                            <div class="crs-result-header">
                                <div>
                                    <div style="font-family:'Lora',serif; font-weight:700; color:#1c1410; font-size:1rem; line-height:1.2;">
                                        {{ $reg->child_full_name }}
                                    </div>
                                    <div style="font-size:0.7rem; color:#c4a06a; margin-top:0.25rem; letter-spacing:0.05em; font-weight:500;">
                                        {{ $reg->registration_number }}
                                    </div>
                                </div>
                                <span class="crs-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>

                            {{-- Card Rows --}}
                            <div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Kelas</span>
                                    <span class="crs-row-val">Kelas {{ $reg->grade }}</span>
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Kelompok</span>
                                    <span class="crs-row-val">
                                        @if($reg->participant?->eventClass?->saint_name)
                                            {{ $reg->participant->eventClass->saint_name }}
                                        @else
                                            <span style="color:#d4b896; font-style:italic;">Belum ditentukan</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Pembayaran</span>
                                    <span class="{{ $payClass }}" style="font-size:0.8125rem;">{{ $payLabel }}</span>
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Tanggal Daftar</span>
                                    <span class="crs-row-val">{{ $reg->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Footer link --}}
        <div style="text-align:center; margin-top:1.75rem;">
            <a href="{{ route('registration.form') }}"
               style="font-size:0.8125rem; color:#c4a06a; text-decoration:none; font-style:italic; transition:color 0.2s;"
               onmouseover="this.style.color='#d97706'" onmouseout="this.style.color='#c4a06a'">
                ← Kembali ke Formulir Pendaftaran
            </a>
        </div>

    </div>
</div>
