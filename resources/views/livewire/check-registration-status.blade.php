<div>
    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
        <style>
            .sks-breadcrumb {
                display: flex;
                align-items: center;
                gap: 0.375rem;
                font-size: 0.75rem;
                color: #b49a6e;
                margin-bottom: 1.5rem;
            }
            .sks-breadcrumb a {
                color: #b49a6e;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.25rem;
                transition: color 0.15s;
            }
            .sks-breadcrumb a:hover { color: #d97706; }
            .sks-breadcrumb svg { width: 13px; height: 13px; flex-shrink: 0; }
            .sks-breadcrumb-sep { opacity: 0.5; }
            .sks-breadcrumb-current { color: #7a6248; font-weight: 500; }

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

            /* WA row: stacked on mobile, side-by-side on wider screens */
            .crs-wa-row {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                padding: 0.75rem 1.25rem;
                font-size: 0.8125rem;
                border-bottom: 1px solid #faf4eb;
            }
            @media (min-width: 640px) {
                .crs-wa-row {
                    flex-direction: row;
                    align-items: center;
                    justify-content: space-between;
                    gap: 1rem;
                }
                .crs-wa-row-right {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end;
                    gap: 0.3rem;
                    text-align: right;
                }
            }
        </style>
    @endonce

    <div class="crs-wrap">

        {{-- Breadcrumb --}}
        <nav class="sks-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Beranda
            </a>
            <span class="sks-breadcrumb-sep">/</span>
            <span class="sks-breadcrumb-current">Cek Status Pendaftaran</span>
        </nav>

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
                    No. Pendaftaran
                </button>
                <button wire:click="$set('searchType', 'parent_whatsapp')"
                        class="crs-tab {{ $searchType === 'parent_whatsapp' ? 'active' : '' }}">
                    <svg style="width:13px;height:13px;display:inline;vertical-align:-2px;margin-right:4px;" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3"/></svg>
                    No. WhatsApp
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
                                        @if($reg->participant?->team?->name)
                                            {{ $reg->participant->team->name }}
                                        @else
                                            <span style="color:#d4b896; font-style:italic;">Belum ditentukan</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="crs-wa-row">
                                    <span class="crs-row-label">Grup WhatsApp Orang Tua</span>
                                    @if($reg->participant?->team?->whatsapp_group_link)
                                        <div class="crs-wa-row-right">
                                            <a href="{{ $reg->participant->team->whatsapp_group_link }}"
                                               target="_blank" rel="noopener noreferrer"
                                               style="display:inline-flex; align-items:center; gap:0.4rem; background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; font-size:0.8125rem; font-weight:600; padding:0.5rem 1rem; border-radius:10px; text-decoration:none; box-shadow:0 3px 10px rgba(22,163,74,0.25); transition:opacity 0.2s;"
                                               onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                                                <svg style="width:15px;height:15px;flex-shrink:0;" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.549 4.107 1.51 5.84L.057 23.179a.75.75 0 0 0 .916.932l5.455-1.43A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.694 9.694 0 0 1-4.95-1.355l-.355-.21-3.676.964.982-3.585-.231-.369A9.718 9.718 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
                                                </svg>
                                                Gabung Grup WA
                                            </a>
                                            <span style="font-size:0.7rem; color:#b8a070; font-style:italic;">Khusus orang tua &mdash; klik untuk bergabung ke grup WA kelompok anak Anda</span>
                                        </div>
                                    @else
                                        <span style="color:#d4b896; font-style:italic; font-size:0.8125rem;">Belum tersedia</span>
                                    @endif
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Pendamping Kelompok</span>
                                    <span class="crs-row-val">
                                        @php $facilitators = $reg->participant?->team?->facilitators; @endphp
                                        @if($facilitators && $facilitators->isNotEmpty())
                                            {{ $facilitators->pluck('full_name')->join(', ') }}
                                        @else
                                            <span style="color:#d4b896; font-style:italic;">Pendamping kelompok belum ditentukan</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Ukuran Kaos</span>
                                    <span class="crs-row-val" style="display:flex; align-items:center; gap:0.5rem;">
                                        <span style="font-weight:700; font-size:0.9375rem;">{{ $reg->tshirt_size }}</span>
                                        @if($reg->tshirtSize)
                                            <span style="font-size:0.7rem; color:#b8a070; font-weight:400;">
                                                panjang {{ $reg->tshirtSize->panjang }} cm &bull; lebar {{ $reg->tshirtSize->lebar }} cm
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Pembayaran</span>
                                    <span class="{{ $payClass }}" style="font-size:0.8125rem;">{{ $payLabel }}</span>
                                </div>
                                <div class="crs-row">
                                    <span class="crs-row-label">Tanggal Daftar</span>
                                    <span class="crs-row-val">{{ $reg->created_at->format('d M Y - h:i:s') }}</span>
                                </div>
                                @if($reg->payment_status === 'rejected' && $reg->rejection_reason)
                                    <div style="padding:0.75rem 1.25rem; background:#fff5f5; border-top:1px solid #fecaca;">
                                        <div style="font-size:0.7rem; color:#dc2626; font-weight:600; margin-bottom:0.25rem; text-transform:uppercase; letter-spacing:0.04em;">Alasan Penolakan</div>
                                        <div style="font-size:0.8125rem; color:#7f1d1d; line-height:1.5;">{{ $reg->rejection_reason }}</div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Footer link --}}
        <div style="text-align:center; margin-top:1.75rem; display:flex; flex-direction:column; align-items:center; gap:0.625rem;">
            <a href="{{ route('home') }}"
               style="font-size:0.8125rem; color:#c4a06a; text-decoration:none; font-style:italic; transition:color 0.2s;"
               onmouseover="this.style.color='#d97706'" onmouseout="this.style.color='#c4a06a'">
                ⌂ Kembali ke Halaman Utama
            </a>
            <a href="{{ route('registration.form') }}"
               style="font-size:0.8125rem; color:#c4a06a; text-decoration:none; font-style:italic; transition:color 0.2s;"
               onmouseover="this.style.color='#d97706'" onmouseout="this.style.color='#c4a06a'">
                ← Ke Formulir Pendaftaran
            </a>
        </div>

    </div>
</div>
