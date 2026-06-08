<?php

namespace App\Livewire;

use App\Models\EventClass;
use App\Models\EventPeriod;
use Livewire\Component;

class PublicKelompok extends Component
{
    public ?EventPeriod $period = null;

    public string $search      = '';
    public string $activeClass = 'kecil';

    public function mount(string $year): void
    {
        $this->period = EventPeriod::where('year', $year)->firstOrFail();
    }

    public function render()
    {
        $allClasses = EventClass::where('event_period_id', $this->period->id)
            ->orderBy('grade_min')
            ->with([
                'teams' => fn ($q) => $q->orderBy('number')->with([
                    'participants' => fn ($q) => $q->orderBy('nickname')->orderBy('child_full_name'),
                    'facilitators',
                ]),
            ])
            ->get();

        $search = trim($this->search);

        if ($search !== '') {
            // Search mode: collect teams that have at least one matching participant
            $searchResults = [];
            foreach ($allClasses as $class) {
                foreach ($class->teams as $team) {
                    $hasMatch = $team->participants->contains(
                        fn ($p) => str_contains(
                            strtolower($p->nickname ?: $p->child_full_name),
                            strtolower($search)
                        )
                    );
                    if ($hasMatch) {
                        $searchResults[] = ['team' => $team, 'class' => $class];
                    }
                }
            }

            return view('livewire.public-kelompok', [
                'allClasses'    => $allClasses,
                'searchResults' => $searchResults,
                'isSearching'   => true,
            ])->layout('components.layouts.public');
        }

        return view('livewire.public-kelompok', [
            'allClasses'    => $allClasses,
            'searchResults' => [],
            'isSearching'   => false,
        ])->layout('components.layouts.public');
    }
}
