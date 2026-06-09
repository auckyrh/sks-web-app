<?php

namespace App\Livewire;

use App\Support\PhoneNormalizer;
use Livewire\Component;
use App\Models\Registration;

class CheckRegistrationStatus extends Component
{
    public string $search = '';
    public string $searchType = 'registration_number';
    public $results = [];
    public bool $searched = false;

    public function check(): void
    {
        $this->validate([
            'search' => 'required|string|min:3',
        ]);

        $query = Registration::with(['eventPeriod', 'tshirtSize', 'participant.eventClass', 'participant.team.facilitators']);

        if ($this->searchType === 'registration_number') {
            $query->where('registration_number', $this->search);
        } else {
            $query->where('parent_whatsapp', PhoneNormalizer::normalize($this->search));
        }

        $this->results = $query->latest()->get();
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.check-registration-status')
            ->layout('components.layouts.public');
    }
}