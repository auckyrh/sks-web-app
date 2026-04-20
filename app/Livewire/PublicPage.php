<?php

namespace App\Livewire;

use App\Models\EventPeriod;
use App\Models\PublicPage as PublicPageModel;
use Livewire\Component;

class PublicPage extends Component
{
    public ?EventPeriod $period = null;
    public ?PublicPageModel $page = null;
    public string $year;
    public string $type;

    public function mount(string $year): void
    {
        $this->year = $year;

        // Map URL segment to type enum
        $this->type = match(request()->segment(2)) {
            'rundown'     => 'rundown',
            'tata-tertib' => 'tata_tertib',
            'informasi'   => 'informasi',
            default       => 'informasi',
        };

        $this->period = EventPeriod::where('year', $year)->firstOrFail();

        $this->page = PublicPageModel::where('event_period_id', $this->period->id)
            ->where('type', $this->type)
            ->where('is_published', true)
            ->first();
    }

    public function render()
    {
        return view('livewire.public-page')
            ->layout('components.layouts.public');
    }
}