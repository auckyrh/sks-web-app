<x-filament-panels::page>
    <style>
        /* ── Base ──────────────────────────────────────────────────────────── */
        .pp-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding-bottom: 3rem;
        }

        /* ── Cards ──────────────────────────────────────────────────────────── */
        .pp-card {
            background: #fff;
            border: 1px solid #fef3c7;
            border-radius: 1.125rem;
            padding: 1.375rem;
            box-shadow: 0 1px 8px rgba(180,83,9,0.07);
        }
        .dark .pp-card {
            background: rgb(31,41,55);
            border-color: rgba(251,191,36,0.15);
        }

        /* ── Section header ─────────────────────────────────────────────────── */
        .pp-section-header {
            display: flex; align-items: center; gap: 0.75rem;
            margin-bottom: 1.375rem;
        }
        .pp-section-icon {
            width: 2.25rem; height: 2.25rem;
            border-radius: 0.625rem;
            background: linear-gradient(135deg, #f59e0b, #b45309);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .pp-section-title { font-size: 1rem; font-weight: 700; color: #111827; margin: 0; }
        .dark .pp-section-title { color: #f9fafb; }
        .pp-section-sub { font-size: 0.75rem; color: #9ca3af; margin: 0; }

        /* ── Warning banner ─────────────────────────────────────────────────── */
        .pp-warn-banner {
            display: flex; align-items: flex-start; gap: 0.75rem;
            background: #fff7ed; border: 1px solid #fed7aa;
            border-radius: 1rem; padding: 1rem;
        }
        .dark .pp-warn-banner { background: rgba(154,52,18,0.15); border-color: rgba(253,186,116,0.3); }
        .pp-warn-icon {
            flex-shrink: 0; width: 2rem; height: 2rem;
            background: #ffedd5; border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
        }
        .dark .pp-warn-icon { background: rgba(154,52,18,0.3); }
        .pp-warn-title { font-size: 0.875rem; font-weight: 600; color: #9a3412; }
        .dark .pp-warn-title { color: #fb923c; }
        .pp-warn-body  { font-size: 0.75rem; color: #c2410c; margin-top: 0.125rem; }
        .dark .pp-warn-body  { color: #fdba74; }

        /* ── Save button ────────────────────────────────────────────────────── */
        .pp-save-btn {
            display: inline-flex; align-items: center; gap: 0.375rem;
            background: linear-gradient(135deg, #f59e0b, #b45309);
            color: #fff;
            border: none; border-radius: 0.5rem;
            padding: 0.5625rem 1.375rem;
            font-size: 0.875rem; font-weight: 600;
            cursor: pointer; transition: opacity 0.15s;
            box-shadow: 0 2px 8px rgba(180,83,9,0.25);
        }
        .pp-save-btn:hover { opacity: 0.87; }

        /* ── Current size badge ─────────────────────────────────────────────── */
        .pp-size-current {
            display: inline-flex; align-items: center; gap: 0.375rem;
            background: #fef9c3; border: 1px solid #fde68a;
            border-radius: 0.625rem; padding: 0.375rem 0.875rem;
            font-size: 0.8125rem; font-weight: 600; color: #92400e;
            margin-bottom: 1.25rem;
        }
        .dark .pp-size-current {
            background: rgba(251,191,36,0.1); border-color: rgba(251,191,36,0.25); color: #fbbf24;
        }

        /* ── Empty state ────────────────────────────────────────────────────── */
        .pp-empty {
            text-align: center; padding: 2rem 1rem;
            color: #9ca3af; font-size: 0.875rem;
        }
        .dark .pp-empty { color: #6b7280; }

        /* ── Responsive ─────────────────────────────────────────────────────── */
        .pp-two-col   { display: grid; grid-template-columns: 1fr; gap: 1rem; }
        .pp-right-col { display: flex; flex-direction: column; gap: 1rem; }

        @media (min-width: 640px) {
            .pp-card { padding: 1.75rem; }
        }
        @media (min-width: 1024px) {
            .pp-two-col { grid-template-columns: 1fr 1fr; align-items: start; }
        }
    </style>

    <div class="pp-wrap">

        {{-- ── T-shirt warning ─────────────────────────────────────────────── --}}
        @php $assignment = auth()->user()->load(['currentAssignment.tshirtSize'])->currentAssignment; @endphp
        @if($assignment && !$assignment->tshirt_size_id)
            <div class="pp-warn-banner">
                <div class="pp-warn-icon">
                    <x-heroicon-s-exclamation-triangle style="width:1rem;height:1rem;color:#ea580c;" />
                </div>
                <div>
                    <p class="pp-warn-title">T-shirt size not set</p>
                    <p class="pp-warn-body">Pilih ukuran kaos kamu di bagian T-shirt Size di bawah.</p>
                </div>
            </div>
        @endif

        {{-- ── Two-column: Personal Info + T-shirt ─────────────────────────── --}}
        <div class="pp-two-col">

            {{-- Personal Information ─────────────────────────────────────── --}}
            <div class="pp-card">
                <div class="pp-section-header">
                    <div class="pp-section-icon">
                        <x-heroicon-s-user style="width:1.125rem;height:1.125rem;color:#fff;" />
                    </div>
                    <div>
                        <p class="pp-section-title">Personal Information</p>
                        <p class="pp-section-sub">Name, contact & location</p>
                    </div>
                </div>

                <form wire:submit="saveProfile">
                    {{ $this->profileForm }}
                    <div style="margin-top:1.5rem; display:flex; justify-content:flex-end;">
                        <button type="submit" class="pp-save-btn">
                            <x-heroicon-s-check style="width:0.875rem;height:0.875rem;" />
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right column: T-shirt Size + Change Password stacked ──────── --}}
            <div class="pp-right-col">

                {{-- T-shirt Size ──────────────────────────────────────────── --}}
                <div class="pp-card">
                    <div class="pp-section-header">
                        <div class="pp-section-icon">
                            <x-heroicon-s-swatch style="width:1.125rem;height:1.125rem;color:#fff;" />
                        </div>
                        <div>
                            <p class="pp-section-title">T-shirt Size</p>
                            <p class="pp-section-sub">For your SKS committee t-shirt</p>
                        </div>
                    </div>

                    @if($assignment)
                        @if($assignment->tshirtSize)
                            <div class="pp-size-current">
                                <x-heroicon-s-check-badge style="width:0.875rem;height:0.875rem;" />
                                Current: {{ $assignment->tshirtSize->label }}
                                &nbsp;·&nbsp;
                                {{ $assignment->tshirtSize->panjang }}×{{ $assignment->tshirtSize->lebar }} cm
                            </div>
                        @endif

                        <form wire:submit="saveTshirt">
                            {{ $this->tshirtForm }}
                            <div style="margin-top:1.5rem; display:flex; justify-content:flex-end;">
                                <button type="submit" class="pp-save-btn">
                                    <x-heroicon-s-check style="width:0.875rem;height:0.875rem;" />
                                    Save Size
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="pp-empty">
                            <x-heroicon-o-archive-box-x-mark style="width:2.5rem;height:2.5rem;margin:0 auto 0.5rem;opacity:0.3;" />
                            <p>No active committee assignment for the current period.</p>
                        </div>
                    @endif
                </div>

                {{-- Change Password ────────────────────────────────────────── --}}
                <div class="pp-card">
                    <div class="pp-section-header">
                        <div class="pp-section-icon">
                            <x-heroicon-s-lock-closed style="width:1.125rem;height:1.125rem;color:#fff;" />
                        </div>
                        <div>
                            <p class="pp-section-title">Change Password</p>
                            <p class="pp-section-sub">Leave blank to keep your current password</p>
                        </div>
                    </div>

                    <form wire:submit="savePassword">
                        {{ $this->passwordForm }}
                        <div style="margin-top:1.5rem; display:flex; justify-content:flex-end;">
                            <button type="submit" class="pp-save-btn">
                                <x-heroicon-s-key style="width:0.875rem;height:0.875rem;" />
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>{{-- end .pp-right-col --}}

    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
