<?php

namespace App\Livewire;

use App\Models\Division;
use App\Models\Evaluation;
use App\Models\EventClass;
use App\Models\EventPeriod;
use App\Support\PhoneNormalizer;
use Livewire\Component;

class PublicEvaluationForm extends Component
{
    public ?EventPeriod $activePeriod = null;

    // Header
    public string $respondent_type = '';
    public ?int $event_class_id = null;
    public string $respondent_name = '';
    public string $respondent_phone = '';

    // Kesan dan Pesan
    public string $impressions = '';

    // Detail rows
    public array $details = [];

    // State
    public bool $submitted = false;

    public function mount(): void
    {
        $this->activePeriod = EventPeriod::where('is_active', true)->first();

        // Start with 1 empty detail row
        $this->details = [
            ['division_id' => '', 'feedback' => '', 'suggestions' => ''],
        ];
    }

    public function addDetail(): void
    {
        $this->details[] = ['division_id' => '', 'feedback' => '', 'suggestions' => ''];
    }

    public function removeDetail(int $index): void
    {
        if (count($this->details) > 1) {
            unset($this->details[$index]);
            $this->details = array_values($this->details);
        }
    }

    public function submit(): void
    {
        $rules = [
            'respondent_type' => 'required|in:orang_tua,panitia',
            'respondent_name' => 'nullable|string|max:255',
            'respondent_phone' => 'nullable|string|max:30',
            'impressions' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.division_id' => 'required|exists:divisions,id',
            'details.*.feedback' => 'required|string|min:3',
            'details.*.suggestions' => 'required|string|min:3',
        ];

        $messages = [
            'respondent_type.required' => 'Pilih jenis responden.',
            'details.*.division_id.required' => 'Pilih divisi tujuan.',
            'details.*.feedback.required' => 'Evaluasi wajib diisi.',
            'details.*.feedback.min' => 'Evaluasi minimal 3 karakter.',
            'details.*.suggestions.required' => 'Saran wajib diisi.',
            'details.*.suggestions.min' => 'Saran minimal 3 karakter.',
        ];

        if ($this->respondent_type === 'orang_tua') {
            $rules['event_class_id'] = 'required|exists:event_classes,id';
            $messages['event_class_id.required'] = 'Pilih kelas anak Anda.';
        }

        $validator = \Illuminate\Support\Facades\Validator::make(
            $this->all(),
            $rules,
            $messages,
        );

        if ($validator->fails()) {
            // Deduplicate messages (e.g. multiple detail rows with same error)
            $unique = collect($validator->errors()->all())->unique()->values()->all();
            $this->dispatch('showValidationErrors', errors: $unique);
            return;
        }

        // Check for duplicate divisions
        $divisionIds = array_column($this->details, 'division_id');
        if (count($divisionIds) !== count(array_unique($divisionIds))) {
            $this->dispatch('showValidationErrors', errors: ['Tidak boleh ada divisi yang sama dalam satu evaluasi.']);
            return;
        }

        $evaluation = Evaluation::create([
            'event_period_id' => $this->activePeriod->id,
            'respondent_type' => $this->respondent_type,
            'event_class_id' => $this->respondent_type === 'orang_tua' ? $this->event_class_id : null,
            'respondent_name' => $this->respondent_name ?: null,
            'respondent_phone' => $this->respondent_phone
                ? PhoneNormalizer::normalize($this->respondent_phone)
                : null,
            'impressions' => $this->impressions ?: null,
            'submitted_at' => now(),
        ]);

        foreach ($this->details as $detail) {
            $evaluation->details()->create([
                'division_id' => $detail['division_id'],
                'feedback' => $detail['feedback'],
                'suggestions' => $detail['suggestions'],
            ]);
        }

        $this->submitted = true;
    }

    public function render()
    {
        $eventClasses = $this->activePeriod
            ? EventClass::where('event_period_id', $this->activePeriod->id)
                ->orderBy('grade_min')
                ->get()
            : collect();

        $divisions = Division::orderBy('name')->get();

        return view('livewire.public-evaluation-form', [
            'eventClasses' => $eventClasses,
            'divisions' => $divisions,
        ])->layout('components.layouts.public', [
            'title' => 'Form Evaluasi SKS ' . ($this->activePeriod?->year ?? date('Y')),
        ]);
    }
}
