<?php

namespace App\Livewire;

use App\Models\EventPeriod;
use App\Models\Lingkungan;
use App\Models\PaymentTier;
use App\Models\Registration;
use App\Models\Wilayah;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PublicRegistrationForm extends Component
{
    use WithFileUploads;

    // Event
    public ?EventPeriod $activePeriod = null;

    // Child data
    public string $child_full_name = '';
    public string $nickname = '';
    public string $gender = '';
    public string $birth_date = '';
    public string $address = '';
    public ?int $wilayah_id = null;
    public ?int $lingkungan_id = null;
    public int $grade = 0;
    public string $registration_source = '';
    public bool $has_joined_biak_yck = false;
    public string $tshirt_size = '';
    public string $allergies = '';
    public string $notes = '';

    // Parent data
    public string $parent_name = '';
    public string $parent_wa = '';

    // Payment
    public ?int $payment_tier_id = null;
    public int $donation_amount = 0;
    public $payment_proof;

    // State
    public bool $submitted = false;
    public string $registrationNumber = '';

    public function mount(): void
    {
        $this->activePeriod = EventPeriod::where('is_active', true)->first();

        if ($this->activePeriod) {
            $tiers = PaymentTier::where('event_period_id', $this->activePeriod->id)
                ->whereDate('valid_from', '<=', now())
                ->whereDate('valid_until', '>=', now())
                ->get();

            if ($tiers->count() === 1) {
                $this->payment_tier_id = $tiers->first()->id;
            }
        }
    }

    public function getWilayahListProperty()
    {
        return Wilayah::orderBy('name')->get();
    }

    public function getLingkunganListProperty()
    {
        if (!$this->wilayah_id) return collect();
        return Lingkungan::where('wilayah_id', $this->wilayah_id)->orderBy('name')->get();
    }

    public function getPaymentTiersProperty()
    {
        if (!$this->activePeriod) return collect();
        return PaymentTier::where('event_period_id', $this->activePeriod->id)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->get();
    }

    public function updatedWilayahId(): void
    {
        $this->lingkungan_id = null;
    }

    public function submit(): void
    {
        $this->validate([
            'child_full_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'wilayah_id' => 'required|exists:wilayahs,id',
            'lingkungan_id' => 'nullable|exists:lingkungans,id',
            'grade' => 'required|integer|min:1|max:6',
            'registration_source' => 'required|in:BIAK,YCK,UMUM',
            'tshirt_size' => 'required|in:S,M,L,XL,2XL,3XL,4XL,5XL',
            'parent_name' => 'required|string|max:255',
            'parent_wa' => 'required|string|max:20',
            'payment_tier_id' => 'required|exists:payment_tiers,id',
            'donation_amount' => 'integer|min:0',
            'payment_proof' => 'required|image|max:2048',
        ], [
            'child_full_name.required' => 'Nama lengkap anak wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'wilayah_id.required' => 'Wilayah wajib dipilih.',
            'grade.required' => 'Kelas wajib dipilih.',
            'registration_source.required' => 'Asal pendaftaran wajib dipilih.',
            'tshirt_size.required' => 'Ukuran kaos wajib dipilih.',
            'parent_name.required' => 'Nama orang tua wajib diisi.',
            'parent_wa.required' => 'No. WhatsApp orang tua wajib diisi.',
            'payment_tier_id.required' => 'Tier pembayaran wajib dipilih.',
            'payment_proof.required' => 'Bukti transfer wajib diupload.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $tier = PaymentTier::find($this->payment_tier_id);
        $year  = $this->activePeriod->year;
//        $name  = Str::slug($this->child_full_name); // john-doe
        $name  = str_replace(' ', '-', ucwords(strtolower($this->child_full_name)));
        $ts    = now()->format('Ymd_His');
        $ext   = $this->payment_proof->getClientOriginalExtension();
        $filename = "BUKTI-SKS-{$year}-{$name}-Kelas{$this->grade}-{$ts}.{$ext}";
        $path = $this->payment_proof->storeAs('payment-proofs', $filename, 'public');

        $registration = Registration::create([
            'event_period_id' => $this->activePeriod->id,
            'child_full_name' => $this->child_full_name,
            'nickname' => $this->nickname,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'wilayah_id' => $this->wilayah_id,
            'lingkungan_id' => $this->lingkungan_id,
            'grade' => $this->grade,
            'registration_source' => $this->registration_source,
            'has_joined_biak_yck' => $this->has_joined_biak_yck,
            'tshirt_size' => $this->tshirt_size,
            'allergies' => $this->allergies ?: null,
            'notes' => $this->notes ?: null,
            'parent_name' => $this->parent_name,
            'parent_wa' => $this->parent_wa,
            'payment_tier_id' => $this->payment_tier_id,
            'payment_amount' => $tier->amount,
            'donation_amount' => $this->donation_amount,
            'payment_proof_path' => $path,
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        $this->registrationNumber = $registration->registration_number;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public-registration-form')
            ->layout('layouts.public');
    }
}