<?php

namespace App\Filament\Internal\Pages;

use App\Models\CommitteeAssignment;
use App\Models\TshirtSize;
use App\Models\Wilayah;
use App\Models\Lingkungan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.internal.pages.profile';

    protected static ?string $navigationIcon   = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel  = 'My Profile';
    protected static ?string $title            = 'My Profile';
    protected static ?int    $navigationSort   = 2;

    public function getHeading(): string
    {
        return '';
    }

    // ── Form state ───────────────────────────────────────────────────────────
    public ?array $profileData    = [];
    public ?array $passwordData   = [];
    public ?array $tshirtData     = [];

    public function mount(): void
    {
        $user = auth()->user()->load(['wilayah', 'lingkungan', 'currentAssignment.tshirtSize']);

        $this->profileForm->fill([
            'photo'         => $user->photo,
            'full_name'     => $user->full_name,
            'nick_name'     => $user->nick_name,
            'birth_date'    => $user->birth_date,
            'phone'         => $user->phone,
            'address'       => $user->address,
            'wilayah_id'    => $user->wilayah_id,
            'lingkungan_id' => $user->lingkungan_id,
        ]);

        $this->passwordForm->fill();

        $this->tshirtForm->fill([
            'tshirt_size_id' => $user->currentAssignment?->tshirt_size_id,
        ]);
    }

    // ── Profile form ─────────────────────────────────────────────────────────
    public function profileForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
                    ->label('Profile Photo')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('user-photos')
                    ->nullable()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->getUploadedFileNameForStorageUsing(function ($file, Forms\Get $get) {
                        $name = str_replace(' ', '-', ucwords(strtolower($get('full_name') ?? 'unknown')));
                        $ts   = now()->format('Ymd_His');
                        $ext  = $file->getClientOriginalExtension();
                        return "PHOTO-{$name}-{$ts}.{$ext}";
                    }),

                Forms\Components\TextInput::make('full_name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('nick_name')
                    ->label('Nickname')
                    ->nullable()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('birth_date')
                    ->label('Date of Birth')
                    ->native(false)
                    ->displayFormat('d M Y')
                    ->nullable(),

                Forms\Components\TextInput::make('phone')
                    ->label('WhatsApp Number')
                    ->tel()
                    ->nullable()
                    ->placeholder('e.g. 628123456789'),

                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->nullable()
                    ->rows(2),

                Forms\Components\Select::make('wilayah_id')
                    ->label('Wilayah')
                    ->options(Wilayah::orderBy('name')->pluck('name', 'id'))
                    ->nullable()
                    ->live()
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('lingkungan_id', null)),

                Forms\Components\Select::make('lingkungan_id')
                    ->label('Lingkungan')
                    ->options(fn (Forms\Get $get) =>
                        $get('wilayah_id')
                            ? Lingkungan::where('wilayah_id', $get('wilayah_id'))->orderBy('name')->pluck('name', 'id')
                            : []
                    )
                    ->nullable()
                    ->placeholder('Select wilayah first'),
            ])
            ->statePath('profileData');
    }

    public function saveProfile(): void
    {
        $data = $this->profileForm->getState();
        $user = auth()->user();

        $user->fill($data)->save();

        Notification::make()
            ->title('Profile updated')
            ->success()
            ->send();
    }

    // ── T-shirt size form ────────────────────────────────────────────────────
    public function tshirtForm(Form $form): Form
    {
        $activePeriodId = \App\Models\EventPeriod::where('is_active', true)->value('id');

        $sizes = $activePeriodId
            ? TshirtSize::where('event_period_id', $activePeriodId)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->mapWithKeys(fn ($s) => [
                    $s->id => "{$s->label}  —  P {$s->panjang} × L {$s->lebar} cm",
                ])
                ->toArray()
            : [];

        return $form
            ->schema([
                Forms\Components\Select::make('tshirt_size_id')
                    ->label('T-shirt Size')
                    ->options($sizes)
                    ->nullable()
                    ->placeholder('— Select a size —')
                    ->searchable(false),
            ])
            ->statePath('tshirtData');
    }

    public function saveTshirt(): void
    {
        $data       = $this->tshirtForm->getState();
        $assignment = auth()->user()->currentAssignment;

        if (! $assignment) {
            Notification::make()
                ->title('No active assignment found')
                ->warning()
                ->send();
            return;
        }

        $assignment->update(['tshirt_size_id' => $data['tshirt_size_id']]);

        Notification::make()
            ->title('T-shirt size saved')
            ->success()
            ->send();
    }

    // ── Password form ────────────────────────────────────────────────────────
    public function passwordForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->currentPassword(),

                Forms\Components\TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(Password::default())
                    ->same('password_confirmation'),

                Forms\Components\TextInput::make('password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->dehydrated(false),
            ])
            ->statePath('passwordData');
    }

    public function savePassword(): void
    {
        $data = $this->passwordForm->getState();

        auth()->user()->update(['password' => Hash::make($data['password'])]);

        $this->passwordForm->fill();

        Notification::make()
            ->title('Password changed successfully')
            ->success()
            ->send();
    }

    protected function getForms(): array
    {
        return [
            'profileForm',
            'passwordForm',
            'tshirtForm',
        ];
    }
}
