<x-filament-panels::page>
    <style>
        /* ── Base ─────────────────────────────────────────────────────────── */
        .md-wrap {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            padding-bottom: 2.5rem;
        }

        /* ── Division header banner ─────────────────────────────────────────── */
        .md-banner {
            background: linear-gradient(135deg, #92400e 0%, #d97706 55%, #fbbf24 100%);
            border-radius: 1.25rem;
            padding: 1.5rem 1.75rem;
            color: #fff;
            box-shadow: 0 4px 20px rgba(180,83,9,0.22);
            position: relative;
            overflow: hidden;
        }
        .md-banner::before {
            content: '';
            position: absolute; top: -2rem; right: -2rem;
            width: 7rem; height: 7rem; border-radius: 50%;
            background: rgba(255,255,255,0.07); pointer-events: none;
        }
        .md-banner-inner { position: relative; z-index: 1; }
        .md-banner-label { font-size: 0.75rem; color: rgba(255,255,255,0.7); font-weight: 500; margin-bottom: 0.125rem; }
        .md-banner-name  { font-size: 1.5rem; font-weight: 700; line-height: 1.25; color: #fff; }
        .md-banner-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.75rem; }
        .md-chip {
            display: inline-flex; align-items: center; gap: 0.375rem;
            background: rgba(255,255,255,0.18); backdrop-filter: blur(4px);
            border-radius: 99px; padding: 0.25rem 0.75rem;
            font-size: 0.75rem; font-weight: 600; color: #fff;
        }

        /* ── Section heading ────────────────────────────────────────────────── */
        .md-section-title {
            font-size: 0.6875rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.07em; color: #d97706; margin-bottom: 0.75rem;
        }
        .dark .md-section-title { color: #fbbf24; }

        /* ── Coordinator card ───────────────────────────────────────────────── */
        .md-coord-card {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1.5px solid #fde68a;
            border-radius: 1.125rem;
            padding: 1.125rem 1.25rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: 0 2px 10px rgba(180,83,9,0.09);
        }
        .dark .md-coord-card {
            background: linear-gradient(135deg, rgba(251,191,36,0.07), rgba(251,191,36,0.12));
            border-color: rgba(251,191,36,0.25);
        }

        /* ── Member grid ────────────────────────────────────────────────────── */
        .md-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        @media (min-width: 480px) { .md-grid { grid-template-columns: 1fr 1fr; } }
        @media (min-width: 900px) { .md-grid { grid-template-columns: 1fr 1fr 1fr; } }

        /* ── Member card ────────────────────────────────────────────────────── */
        .md-member-card {
            background: #fff;
            border: 1px solid #fef3c7;
            border-radius: 1rem;
            padding: 1rem;
            display: flex; align-items: center; gap: 0.875rem;
            box-shadow: 0 1px 6px rgba(180,83,9,0.05);
            transition: box-shadow 0.15s;
        }
        .md-member-card:hover { box-shadow: 0 3px 12px rgba(180,83,9,0.12); }
        .dark .md-member-card {
            background: rgb(31,41,55);
            border-color: rgba(251,191,36,0.12);
        }
        /* Highlight own card */
        .md-member-card.is-me {
            border-color: #fde68a;
            background: #fffbeb;
            box-shadow: 0 0 0 2px #fbbf24, 0 2px 10px rgba(180,83,9,0.1);
        }
        .dark .md-member-card.is-me {
            background: rgba(251,191,36,0.07);
            border-color: rgba(251,191,36,0.3);
            box-shadow: 0 0 0 2px rgba(251,191,36,0.4);
        }

        /* ── Avatar ─────────────────────────────────────────────────────────── */
        .md-avatar {
            width: 2.75rem; height: 2.75rem; border-radius: 50%;
            object-fit: cover; flex-shrink: 0;
            border: 2px solid #fde68a;
        }
        .md-avatar-initials {
            width: 2.75rem; height: 2.75rem; border-radius: 50%;
            background: #fef3c7; color: #b45309;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; flex-shrink: 0;
            border: 2px solid #fde68a;
        }
        .dark .md-avatar-initials {
            background: rgba(251,191,36,0.12); color: #fbbf24;
            border-color: rgba(251,191,36,0.3);
        }
        /* Larger avatar for coordinator card */
        .md-avatar-lg { width: 3.5rem; height: 3.5rem; font-size: 1.25rem; }

        /* ── Name / sub text ────────────────────────────────────────────────── */
        .md-name { font-size: 0.875rem; font-weight: 600; color: #111827; line-height: 1.3; }
        .dark .md-name { color: #f9fafb; }
        .md-sub  { font-size: 0.75rem; color: #9ca3af; margin-top: 0.0625rem; }
        .md-you-badge {
            display: inline-block;
            background: #fbbf24; color: #78350f;
            border-radius: 99px; padding: 0.05rem 0.5rem;
            font-size: 0.65rem; font-weight: 700;
            margin-left: 0.3rem; vertical-align: middle;
        }

        /* ── WA button ──────────────────────────────────────────────────────── */
        .md-wa-btn {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: #dcfce7; color: #15803d;
            border-radius: 99px; padding: 0.2rem 0.625rem;
            font-size: 0.7rem; font-weight: 600;
            text-decoration: none; transition: background 0.15s;
            white-space: nowrap;
        }
        .md-wa-btn:hover { background: #bbf7d0; }
        .dark .md-wa-btn { background: rgba(21,128,61,0.2); color: #86efac; }
        .dark .md-wa-btn:hover { background: rgba(21,128,61,0.3); }

        /* ── Coord badge ────────────────────────────────────────────────────── */
        .md-coord-badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(255,255,255,0.9); color: #78350f;
            border-radius: 99px; padding: 0.2rem 0.625rem;
            font-size: 0.7rem; font-weight: 700;
        }

        /* ── Empty state ────────────────────────────────────────────────────── */
        .md-empty {
            text-align: center; padding: 3rem 1rem; color: #9ca3af;
        }
        .dark .md-empty { color: #6b7280; }

        @media (min-width: 640px) {
            .md-banner { padding: 1.75rem 2rem; }
            .md-banner-name { font-size: 1.75rem; }
        }
    </style>

    <div class="md-wrap">

        @if(! $assignment)
            {{-- No assignment ──────────────────────────────────────────────── --}}
            <div class="md-empty">
                <x-heroicon-o-user-group style="width:3rem;height:3rem;margin:0 auto 0.75rem;opacity:0.3;" />
                <p style="font-weight:600; margin-bottom:0.25rem;">No active assignment</p>
                <p style="font-size:0.8125rem;">You don't have a committee assignment for the current period.</p>
            </div>

        @else

            {{-- ── Division Banner ──────────────────────────────────────────── --}}
            <div class="md-banner">
                <div class="md-banner-inner">
                    <p class="md-banner-label">Your Division</p>
                    <p class="md-banner-name">{{ $assignment->division->name }}</p>
                    <div class="md-banner-chips">
                        <span class="md-chip">
                            <x-heroicon-s-calendar-days style="width:0.8rem;height:0.8rem;" />
                            SKS {{ $assignment->eventPeriod->year }}
                        </span>
                        <span class="md-chip">
                            <x-heroicon-s-users style="width:0.8rem;height:0.8rem;" />
                            {{ $members->count() + ($coordinator ? 1 : 0) }} members
                        </span>
                        @if($assignment->position === 'coordinator')
                            <span style="background:rgba(255,255,255,0.92);color:#78350f;" class="md-chip">
                                <x-heroicon-s-star style="width:0.8rem;height:0.8rem;" />
                                You are the Koordinator
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Coordinator ───────────────────────────────────────────────── --}}
            @if($coordinator)
                <div>
                    <p class="md-section-title">Koordinator</p>
                    <div class="md-coord-card">
                        @if($coordinator->user->photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coordinator->user->photo) }}"
                                 alt="{{ $coordinator->user->full_name }}"
                                 class="md-avatar md-avatar-lg">
                        @else
                            <div class="md-avatar-initials md-avatar-lg">
                                {{ strtoupper(substr($coordinator->user->full_name, 0, 1)) }}
                            </div>
                        @endif

                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
                                <p class="md-name" style="font-size:1rem;">
                                    {{ $coordinator->user->nick_name ?: $coordinator->user->full_name }}
                                    @if($coordinator->user_id === $myId)
                                        <span class="md-you-badge">You</span>
                                    @endif
                                </p>
                                <span class="md-coord-badge">
                                    <x-heroicon-s-star style="width:0.7rem;height:0.7rem;" />
                                    Koordinator
                                </span>
                            </div>
                            @if($coordinator->user->nick_name && $coordinator->user->nick_name !== $coordinator->user->full_name)
                                <p class="md-sub">{{ $coordinator->user->full_name }}</p>
                            @endif
                            @if($coordinator->user->wilayah)
                                <p class="md-sub">{{ $coordinator->user->wilayah->name }}</p>
                            @endif
                        </div>

                        @if($coordinator->user->phone && $coordinator->user_id !== $myId)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $coordinator->user->phone) }}"
                               target="_blank" rel="noopener"
                               class="md-wa-btn" style="flex-shrink:0;">
                                <x-heroicon-s-chat-bubble-left-ellipsis style="width:0.75rem;height:0.75rem;" />
                                WA
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ── Members ────────────────────────────────────────────────────── --}}
            @if($members->isNotEmpty())
                <div>
                    <p class="md-section-title">Members ({{ $members->count() }})</p>
                    <div class="md-grid">
                        @foreach($members as $member)
                            @php $isMe = $member->user_id === $myId; @endphp
                            <div class="md-member-card {{ $isMe ? 'is-me' : '' }}">
                                @if($member->user->photo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->user->photo) }}"
                                         alt="{{ $member->user->full_name }}"
                                         class="md-avatar">
                                @else
                                    <div class="md-avatar-initials">
                                        {{ strtoupper(substr($member->user->full_name, 0, 1)) }}
                                    </div>
                                @endif

                                <div style="flex:1; min-width:0;">
                                    <p class="md-name">
                                        {{ $member->user->nick_name ?: $member->user->full_name }}
                                        @if($isMe)
                                            <span class="md-you-badge">You</span>
                                        @endif
                                    </p>
                                    @if($member->user->wilayah)
                                        <p class="md-sub">{{ $member->user->wilayah->name }}</p>
                                    @elseif($member->user->nick_name && $member->user->nick_name !== $member->user->full_name)
                                        <p class="md-sub">{{ $member->user->full_name }}</p>
                                    @endif
                                </div>

                                @if($member->user->phone && ! $isMe)
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $member->user->phone) }}"
                                       target="_blank" rel="noopener"
                                       class="md-wa-btn" style="flex-shrink:0;">
                                        <x-heroicon-s-chat-bubble-left-ellipsis style="width:0.7rem;height:0.7rem;" />
                                        WA
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @endif

    </div>
</x-filament-panels::page>
