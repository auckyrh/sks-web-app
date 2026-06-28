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

            /* Detail card styling */
            .sks-detail-card {
                background: #fdfaf5;
                border: 1.5px solid #f0e8d8;
                border-radius: 14px;
                padding: 1.25rem;
                position: relative;
                transition: border-color 0.2s;
            }
            .sks-detail-card:hover { border-color: #e8dcc8; }

            .sks-detail-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid #f0e8d8;
            }
            .sks-detail-title {
                font-family: 'Lora', serif;
                font-size: 0.875rem;
                font-weight: 600;
                color: #5c4a32;
            }
            .sks-remove-btn {
                background: none;
                border: 1.5px solid #fca5a5;
                border-radius: 8px;
                padding: 0.25rem 0.625rem;
                font-size: 0.75rem;
                color: #dc2626;
                cursor: pointer;
                transition: background 0.15s, border-color 0.15s;
                font-family: 'DM Sans', sans-serif;
                font-weight: 500;
            }
            .sks-remove-btn:hover { background: #fef2f2; border-color: #f87171; }

            .sks-add-btn {
                width: 100%;
                border: 2px dashed #e8dcc8;
                border-radius: 14px;
                padding: 1rem;
                background: transparent;
                cursor: pointer;
                transition: border-color 0.2s, background 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                font-weight: 500;
                color: #b49a6e;
            }
            .sks-add-btn:hover {
                border-color: #f59e0b;
                background: #fffbf0;
                color: #d97706;
            }
            .sks-add-btn svg { width: 20px; height: 20px; }

            .sks-hint {
                font-size: 0.75rem;
                color: #92835c;
                margin-bottom: 1rem;
                line-height: 1.5;
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

            @keyframes spin { to { transform: rotate(360deg); } }
        </style>
    @endonce

    <div class="sks-form">

        {{-- Breadcrumb --}}
        <nav class="sks-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Beranda
            </a>
            <span class="sks-breadcrumb-sep">/</span>
            <span class="sks-breadcrumb-current">Form Evaluasi</span>
        </nav>

        {{-- ── SUCCESS STATE ───────────────────────────────────────────── --}}
        @if($submitted)
            <div class="sks-success-card" style="animation: sks-fade-up 0.5s ease both;">
                <div style="width:72px; height:72px; background:linear-gradient(135deg,#ecfdf5,#d1fae5); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem; border:2px solid #6ee7b7;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#059669" style="width:36px;height:36px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h1 class="sks-heading" style="font-size:1.5rem; font-weight:700; color:#1c1410; margin-bottom:0.5rem;">
                    Evaluasi Berhasil Disubmit!
                </h1>
                <p style="color:#7a6248; font-size:0.9rem; line-height:1.6; max-width:380px; margin: 0 auto 1.75rem;">
                    Terima kasih atas evaluasi dan saran Anda. Masukan Anda sangat berharga untuk SKS yang lebih baik di masa mendatang.
                </p>
                <a href="{{ route('home') }}"
                   style="display:inline-block; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; padding:0.75rem 2rem; border-radius:10px; font-size:0.875rem; font-weight:600; text-decoration:none; box-shadow:0 4px 14px rgba(217,119,6,0.3);">
                    Kembali ke Beranda →
                </a>
            </div>

        {{-- ── FORM STATE ───────────────────────────────────────────────── --}}
        @else
            @if(!$activePeriod)
                <div class="sks-success-card">
                    <div style="width:64px; height:64px; background:#f5f5f5; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#9ca3af" style="width:32px;height:32px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                    <h2 class="sks-heading" style="font-size:1.25rem; font-weight:700; color:#1c1410; margin-bottom:0.5rem;">Form Evaluasi Belum Tersedia</h2>
                    <p style="color:#9c8060; font-size:0.875rem;">Silakan pantau informasi dari panitia SKS.</p>
                </div>
            @else

                {{-- Header --}}
                <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
                    <img src="{{ $activePeriod->event_logo ? Storage::disk('public')->url($activePeriod->event_logo) : asset('images/LOGO-SKS.png') }}"
                         alt="Logo SKS"
                         style="width:56px; height:56px; border-radius:50%; object-fit:cover; flex-shrink:0; box-shadow:0 2px 12px rgba(180,140,60,0.2); border:2px solid #f0d080;">
                    <div>
                        <h1 class="sks-heading" style="font-size:1.4rem; font-weight:700; color:#1c1410; line-height:1.2;">
                            Form Evaluasi
                        </h1>
                        <p style="color:#9c7a48; font-size:0.8125rem; margin-top:0.25rem; font-style:italic;">
                            Sanggar Kitab Suci {{ $activePeriod->year }} — {{ $activePeriod->theme }}
                        </p>
                    </div>
                </div>

                {{-- Intro text --}}
                <div style="background:linear-gradient(135deg,#fffbf0,#fff8e6); border:1.5px solid #f0d080; border-radius:14px; padding:1.25rem; margin-bottom:1.5rem; font-size:0.8125rem; color:#5c4a32; line-height:1.7;">
                    Shalom! Acara <strong>Sanggar Kitab Suci {{ $activePeriod->year }}</strong> telah berakhir, kami segenap panitia mengucapkan terima kasih atas dukungan, kepercayaan dan partisipasi Anda.<br>
                    Kami mohon kesediaan Anda untuk mengisi form evaluasi di bawah ini agar dapat kami perhatikan dan dapat memberikan yang lebih baik lagi di acara SKS selanjutnya. <strong>Seluruh evaluasi yang kami terima akan bersifat anonim.</strong> Silakan memberikan saran dan kritik Anda.
                    Tuhan memberkati dan sampai jumpa di SKS berikutnya.
                </div>

                <form wire:submit="submit" style="display:flex; flex-direction:column; gap:1.25rem;">

                    {{-- ── CARD 1: Data Responden ────────────────────────── --}}
                    <div class="sks-card">
                        <div class="sks-section-label">
                            <div class="sks-section-number">1</div>
                            <span class="sks-section-title">Data Responden</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:1rem;">

                            {{-- Respondent Type --}}
                            <div>
                                <label class="sks-label">Saya mengisi sebagai... <span style="color:#dc2626;">*</span></label>
                                <div class="sks-grid-2">
                                    <label class="sks-radio-card {{ $respondent_type === 'orang_tua' ? 'selected' : '' }}">
                                        <input wire:model.live="respondent_type" type="radio" value="orang_tua">
                                        <div>
                                            <div style="font-size:0.875rem; font-weight:600; color:#1c1410;">Orang Tua Peserta</div>
                                            <div style="font-size:0.75rem; color:#9c8060; margin-top:0.125rem;">Orang tua / wali anak yang mengikuti SKS</div>
                                        </div>
                                    </label>
                                    <label class="sks-radio-card {{ $respondent_type === 'panitia' ? 'selected' : '' }}">
                                        <input wire:model.live="respondent_type" type="radio" value="panitia">
                                        <div>
                                            <div style="font-size:0.875rem; font-weight:600; color:#1c1410;">Panitia</div>
                                            <div style="font-size:0.75rem; color:#9c8060; margin-top:0.125rem;">Anggota panitia SKS {{ $activePeriod->year }}</div>
                                        </div>
                                    </label>
                                </div>
                                @error('respondent_type') <p class="sks-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Event Class (only for orang tua) --}}
                            @if($respondent_type === 'orang_tua')
                                <div>
                                    <label class="sks-label">Nama Kelas Anak <span style="color:#dc2626;">*</span></label>
                                    <select wire:model="event_class_id" class="sks-input">
                                        <option value="">— Pilih Kelas —</option>
                                        @foreach($eventClasses as $ec)
                                            <option value="{{ $ec->id }}">{{ $ec->saint_name }} (Kelas {{ $ec->grade_min }}–{{ $ec->grade_max }})</option>
                                        @endforeach
                                    </select>
                                    @error('event_class_id') <p class="sks-error">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            {{-- Optional: Name & Phone --}}
                            <div class="sks-grid-2">
                                <div>
                                    <label class="sks-label">Nama <span style="font-size:0.7rem; color:#b8a88a;">(opsional)</span></label>
                                    <input wire:model="respondent_name" type="text" class="sks-input" placeholder="Nama Anda">
                                </div>
                                <div>
                                    <label class="sks-label">No. HP / WhatsApp <span style="font-size:0.7rem; color:#b8a88a;">(opsional)</span></label>
                                    <input wire:model="respondent_phone" type="tel" class="sks-input" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            <p style="font-size:0.7rem; color:#b8a88a; margin-top:-0.5rem;">Data diri bersifat opsional. Evaluasi Anda tetap anonim jika tidak diisi.</p>

                        </div>
                    </div>

                    {{-- ── CARD 2: Evaluasi Detail ────────────────────────── --}}
                    <div class="sks-card">
                        <div class="sks-section-label">
                            <div class="sks-section-number">2</div>
                            <span class="sks-section-title">Evaluasi & Saran</span>
                        </div>

                        <p class="sks-hint">
                            Anda dapat memberikan evaluasi untuk lebih dari satu divisi sekaligus.
                            Klik tombol <strong>"Tambah Evaluasi"</strong> di bawah untuk menambahkan divisi lain.
                        </p>

                        <div style="display:flex; flex-direction:column; gap:1rem;">

                            @foreach($details as $index => $detail)
                                <div class="sks-detail-card" wire:key="detail-{{ $index }}">
                                    <div class="sks-detail-header">
                                        <span class="sks-detail-title">Evaluasi #{{ $index + 1 }}</span>
                                        @if(count($details) > 1)
                                            <button type="button"
                                                    wire:click="removeDetail({{ $index }})"
                                                    class="sks-remove-btn">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>

                                    <div style="display:flex; flex-direction:column; gap:0.875rem;">
                                        {{-- Division --}}
                                        <div>
                                            <label class="sks-label">Evaluasi ditujukan untuk... <span style="color:#dc2626;">*</span></label>
                                            <select wire:model="details.{{ $index }}.division_id" class="sks-input">
                                                <option value="">— Pilih Divisi —</option>
                                                @foreach($divisions as $div)
                                                    <option value="{{ $div->id }}">{{ $div->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('details.' . $index . '.division_id') <p class="sks-error">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Evaluasi --}}
                                        <div>
                                            <label class="sks-label">Evaluasi yang diberikan <span style="color:#dc2626;">*</span></label>
                                            <textarea wire:model="details.{{ $index }}.feedback"
                                                      rows="3"
                                                      class="sks-input"
                                                      style="resize:vertical;"
                                                      placeholder="Tuliskan evaluasi / kritik Anda untuk divisi ini..."></textarea>
                                            @error('details.' . $index . '.feedback') <p class="sks-error">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Saran --}}
                                        <div>
                                            <label class="sks-label">Saran untuk SKS berikutnya <span style="color:#dc2626;">*</span></label>
                                            <textarea wire:model="details.{{ $index }}.suggestions"
                                                      rows="3"
                                                      class="sks-input"
                                                      style="resize:vertical;"
                                                      placeholder="Tuliskan saran / masukan Anda..."></textarea>
                                            @error('details.' . $index . '.suggestions') <p class="sks-error">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Add more button --}}
                            <button type="button" wire:click="addDetail" class="sks-add-btn">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Tambah Evaluasi untuk Divisi Lain
                            </button>

                        </div>
                    </div>

                    {{-- ── CARD 3: Kesan dan Pesan ──────────────────────── --}}
                    <div class="sks-card">
                        <div class="sks-section-label">
                            <div class="sks-section-number">3</div>
                            <span class="sks-section-title">Kesan & Pesan</span>
                        </div>

                        <div>
                            <label class="sks-label">Kesan dan pesan Anda untuk SKS {{ $activePeriod->year }} <span style="font-size:0.7rem; color:#b8a88a;">(opsional)</span></label>
                            <textarea wire:model="impressions"
                                      rows="4"
                                      class="sks-input"
                                      style="resize:vertical;"
                                      placeholder="Tuliskan kesan dan pesan Anda selama mengikuti / mendukung kegiatan SKS..."></textarea>
                        </div>
                    </div>

                    {{-- ── Submit ───────────────────────────────────────── --}}
                    <button type="button"
                            id="sks-submit-btn"
                            class="sks-submit-btn"
                            wire:loading.attr="disabled"
                            wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Submit Evaluasi →</span>
                        <span wire:loading wire:target="submit" style="display:none; align-items:center; justify-content:center; gap:0.5rem;">
                            <svg style="width:18px;height:18px;animation:spin 1s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-dasharray="60" stroke-dashoffset="15"/></svg>
                            Mensubmit evaluasi...
                        </span>
                    </button>

                    <p style="text-align:center; font-size:0.7rem; color:#b8a070; margin-top:-0.5rem;">
                        Evaluasi Anda bersifat anonim dan akan digunakan untuk meningkatkan kualitas SKS selanjutnya.
                    </p>

                </form>
            @endif
        @endif

    </div>

    @if(!$submitted && $activePeriod)
    <script>
        // ── Submit confirmation dialog with summary ─────────────────────
        document.getElementById('sks-submit-btn').addEventListener('click', function () {
            // Gather division names from the selected options
            var detailCards = document.querySelectorAll('.sks-detail-card');
            var divisionNames = [];
            detailCards.forEach(function (card) {
                var select = card.querySelector('select');
                if (select && select.value) {
                    var selectedOption = select.options[select.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        divisionNames.push(selectedOption.text);
                    }
                }
            });

            var count = divisionNames.length || detailCards.length;
            var divisiList = divisionNames.length > 0
                ? '<strong>' + divisionNames.join(', ') + '</strong>'
                : '';

            var summaryHtml = '<p style="font-size:0.9rem;color:#374151;line-height:1.6;">'
                + 'Anda akan mensubmit <strong>' + count + ' evaluasi</strong>'
                + (divisiList ? ' untuk: ' + divisiList : '')
                + '</p>'
                + '<p style="font-size:0.8rem;color:#92835c;margin-top:0.875rem;">'
                + 'Pastikan semua data sudah benar sebelum mensubmit.'
                + '</p>';

            Swal.fire({
                title: 'Konfirmasi Submit Evaluasi',
                html: summaryHtml,
                icon: 'question',
                confirmButtonText: 'Ya, Submit Evaluasi!',
                confirmButtonColor: '#d97706',
                showCancelButton: false,
                footer: '<button type="button" id="swal-back-check-btn" style="background:none;border:none;padding:0;font-size:0.75rem;color:darkred;text-decoration:underline;cursor:pointer;font-family:inherit;">Kembali, saya ingin periksa ulang</button>',
                didOpen: function () {
                    document.getElementById('swal-back-check-btn').addEventListener('click', function () {
                        Swal.close();
                    });
                },
            }).then(function (result) {
                if (result.isConfirmed) {
                    var form = document.querySelector('form[wire\\:submit]');
                    if (form) form.requestSubmit();
                }
            });
        });

        // ── Validation error SWAL ──────────────────────────────────────
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('showValidationErrors', function (data) {
                var errors = data.errors || data[0].errors;
                var list = errors.map(function(e) { return '<li style="text-align:left; margin:0.2rem 0;">\u2022 ' + e + '</li>'; }).join('');
                Swal.fire({
                    title: 'Ada yang belum lengkap',
                    html: '<ul style="list-style:none; padding:0; margin:0; font-size:0.875rem; color:#4b3a2a;">' + list + '</ul>',
                    icon: 'warning',
                    confirmButtonText: 'Oke, saya perbaiki',
                    confirmButtonColor: '#d97706',
                });
            });
        });
    </script>
    @endif
</div>
