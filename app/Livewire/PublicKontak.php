<?php

namespace App\Livewire;

use App\Models\EventContact;
use App\Models\EventPeriod;
use Livewire\Component;

class PublicKontak extends Component
{
    public ?EventPeriod $period = null;
    public $contacts;

    public function mount(string $year): void
    {
        $this->period = EventPeriod::where('year', $year)->firstOrFail();
        $this->contacts = EventContact::where('event_period_id', $this->period->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
    }

    public function render()
    {
        return view('livewire.public-kontak')
            ->layout('components.layouts.public');
    }
}