<?php

namespace App\Livewire;

use App\Models\EventClass;
use App\Models\EventPeriod;
use Livewire\Component;

class PublicKelompok extends Component
{
    public ?EventPeriod $period = null;
    public $classes;

    public function mount(string $year): void
    {
        $this->period = EventPeriod::where('year', $year)->firstOrFail();

        $this->classes = EventClass::where('event_period_id', $this->period->id)
            ->orderBy('level')
            ->with([
                'teams' => fn ($q) => $q->orderBy('number')->with([
                    'participants' => fn ($q) => $q->orderBy('child_full_name'),
                    'facilitators',
                ]),
            ])
            ->get();
    }

    public function render()
    {
        return view('livewire.public-kelompok')
            ->layout('components.layouts.public');
    }
}