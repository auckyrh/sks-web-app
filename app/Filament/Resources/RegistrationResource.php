<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Pendaftaran';
    protected static ?string $navigationLabel = 'Registrasi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Anak')
                ->schema([
                    Forms\Components\Select::make('event_period_id')
                        ->label('Event Period')
                        ->relationship('eventPeriod', 'year')
                        ->required()
                        ->native(false)
                        ->preload()
                        ->default(fn () => \App\Models\EventPeriod::where('is_active', true)->first()?->id),
                    Forms\Components\TextInput::make('registration_number')
                        ->label('No. Pendaftaran')
                        ->disabled()
                        ->dehydrated(false)
                        ->helperText('Auto-generated saat disimpan'),
                    Forms\Components\TextInput::make('child_full_name')
                        ->label('Nama Lengkap Anak')
                        ->required(),
                    Forms\Components\TextInput::make('nickname')
                        ->label('Nama Panggilan')
                        ->required(),
                    Forms\Components\Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options(['M' => 'Laki-laki', 'F' => 'Perempuan'])
                        ->required()
                        ->native(false),
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->required(),
                    Forms\Components\Select::make('grade')
                        ->label('Kelas Saat Ini')
                        ->options([
                            1 => 'Kelas 1', 2 => 'Kelas 2',
                            3 => 'Kelas 3', 4 => 'Kelas 4',
                            5 => 'Kelas 5', 6 => 'Kelas 6',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\Textarea::make('address')
                        ->label('Alamat')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Select::make('wilayah_id')
                        ->label('Wilayah')
                        ->options(\App\Models\Wilayah::pluck('name', 'id'))
                        ->nullable()
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(fn (Forms\Set $set) => $set('lingkungan_id', null)),
                    Forms\Components\Select::make('lingkungan_id')
                        ->label('Lingkungan')
                        ->options(fn (Forms\Get $get) =>
                        \App\Models\Lingkungan::where('wilayah_id', $get('wilayah_id'))
                            ->pluck('name', 'id')
                        )
                        ->nullable()
                        ->native(false)
                        ->helperText('Pilih "Tidak Tahu" jika tidak tahu lingkungan'),
                    Forms\Components\Select::make('registration_source')
                        ->label('Daftar Lewat')
                        ->options(['BIAK' => 'BIAK', 'YCK' => 'YCK', 'UMUM' => 'Umum'])
                        ->required()
                        ->native(false),
                    Forms\Components\Toggle::make('has_joined_biak_yck')
                        ->label('Sudah ikut BIAK/YCK?'),
                    Forms\Components\Select::make('tshirt_size')
                        ->label('Ukuran Kaos')
                        ->options([
                            'XS' => 'XS', 'S' => 'S', 'M' => 'M', 'L' => 'L',
                            'XL' => 'XL', '2XL' => '2XL', '3XL' => '3XL', '4XL' => '4XL',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\TextInput::make('allergies')
                        ->label('Alergi')
                        ->nullable(),
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan untuk Panitia')
                        ->nullable()
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Data Orang Tua')
                ->schema([
                    Forms\Components\TextInput::make('parent_name')
                        ->label('Nama Orang Tua')
                        ->required(),
                    Forms\Components\TextInput::make('parent_wa')
                        ->label('No. WhatsApp Orang Tua')
                        ->tel()
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Pembayaran')
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\Select::make('payment_tier_id')
                                        ->label('Tier Pembayaran')
                                        ->options(fn () =>
                                        \App\Models\PaymentTier::whereHas('eventPeriod', fn($q) =>
                                        $q->where('is_active', true))
                                            ->get()
                                            ->mapWithKeys(fn ($tier) =>
                                            [$tier->id => $tier->name . ' — Rp ' . number_format($tier->amount, 0, ',', '.')]
                                            )
                                        )
                                        ->required()
                                        ->native(false)
                                        ->live()
                                        ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                                        $set('payment_amount', \App\Models\PaymentTier::find($state)?->amount)
                                        ),
                                    Forms\Components\TextInput::make('payment_amount')
                                        ->label('Nominal Pembayaran')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->required(),
                                    Forms\Components\TextInput::make('donation_amount')
                                        ->label('Donasi Silang')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->helperText('Donasi sukarela untuk subsidi peserta lain'),
                                    Forms\Components\Select::make('payment_status')
                                        ->label('Status Pembayaran')
                                        ->options([
                                            'pending'  => 'Pending',
                                            'verified' => 'Verified',
                                            'rejected' => 'Rejected',
                                        ])
                                        ->default('pending')
                                        ->native(false),
                                    Forms\Components\Select::make('status')
                                        ->label('Status Pendaftaran')
                                        ->options([
                                            'pending'   => 'Pending',
                                            'confirmed' => 'Confirmed',
                                            'cancelled' => 'Cancelled',
                                        ])
                                        ->default('pending')
                                        ->native(false),
                                    Forms\Components\Placeholder::make('verified_info')
                                        ->label('Diverifikasi oleh')
                                        ->content(fn ($record) => $record?->verified_at
                                            ? ($record->verifiedBy?->name ?? '—') . ' · ' . $record->verified_at->format('d M Y, H:i')
                                            : '—'
                                        )
                                        ->visibleOn('edit'),
                                ]),
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\TextInput::make('payer_name')
                                        ->label('Nama Rekening Pengirim')
                                        ->nullable(),
                                    Forms\Components\FileUpload::make('payment_proof_path')
                                        ->label('Bukti Transfer')
                                        ->image()
                                        ->disk('public')
                                        ->visibility('public')
                                        ->directory('payment-proofs')
                                        ->nullable()
                                        ->getUploadedFileNameForStorageUsing(function ($file, Forms\Get $get) {
                                            $year  = \App\Models\EventPeriod::where('is_active', true)->first()?->year ?? now()->year;
                                            $name = str_replace(' ', '-', ucwords(strtolower($get('child_full_name') ?? 'unknown'))); // John-Doe
//                                            $name  = \Illuminate\Support\Str::slug($get('child_full_name') ?? 'unknown'); // john-doe
                                            $grade = $get('grade') ?? '0';
                                            $ts    = now()->format('Ymd_His');
                                            $ext   = $file->getClientOriginalExtension();
                                            return "BUKTI-SKS-{$year}-{$name}-Kelas{$grade}-{$ts}.{$ext}";
                                        }),
                                ]),
                        ])->columns(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('No. Daftar')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('child_full_name')
                    ->label('Nama Anak')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wilayah.name')
                    ->label('Wilayah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Kelas')
                    ->badge()
                    ->formatStateUsing(fn ($state) => 'Kelas ' . $state),
                Tables\Columns\TextColumn::make('parent_wa')
                    ->label('WA Ortu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payer_name')
                    ->label('Nama Rekening')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'verified',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger'  => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('verified_info')
                    ->label('Diverifikasi')
                    ->getStateUsing(fn ($record) => $record->verified_at
                        ? $record->verifiedBy?->name . "\n" . $record->verified_at->format('d M Y, H:i')
                        : '-'
                    )
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Daftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Tahun')
                    ->relationship('eventPeriod', 'year'),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending'  => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Pendaftaran')
                    ->options([
                        'pending'   => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('wilayah_id')
                    ->label('Wilayah')
                    ->relationship('wilayah', 'name'),
                Tables\Filters\SelectFilter::make('grade')
                    ->label('Kelas')
                    ->options([
                        1 => 'Kelas 1', 2 => 'Kelas 2', 3 => 'Kelas 3',
                        4 => 'Kelas 4', 5 => 'Kelas 5', 6 => 'Kelas 6',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->payment_status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Pembayaran')
                    ->modalDescription('Pastikan bukti transfer sudah sesuai. Setelah diverifikasi, data peserta akan otomatis dibuat.')
                    ->action(function ($record) {
                        \Illuminate\Support\Facades\DB::table('registrations')
                            ->where('id', $record->id)
                            ->update([
                                'payment_status' => 'verified',
                                'status'         => 'confirmed',
                                'verified_by'    => auth()->id(),
                                'verified_at'    => now(),
                                'updated_at'     => now(),
                            ]);
                        $record->refresh();

                        // Auto-create participant
                        if (!$record->participant) {
                            \App\Models\Participant::create([
                                'registration_id'  => $record->id,
                                'event_period_id'  => $record->event_period_id,
                                'event_class_id'   => null, // assigned later
                                'child_full_name'  => $record->child_full_name,
                                'nickname'         => $record->nickname,
                                'gender'           => $record->gender,
                                'birth_date'       => $record->birth_date,
                                'grade'            => $record->grade,
                                'parent_name'      => $record->parent_name,
                                'parent_wa'        => $record->parent_wa,
                                'tshirt_size'      => $record->tshirt_size,
                                'allergies'        => $record->allergies,
                                'notes'            => $record->notes,
                                'created_by'       => auth()->id(),
                            ]);
                        }

                        Notification::make()
                            ->title('✅ Pembayaran terverifikasi, data peserta berhasil dibuat!')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->payment_status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pembayaran')
                    ->modalDescription('Pendaftaran akan ditandai sebagai ditolak.')
                    ->action(function ($record) {
                        $record->update([
                            'payment_status' => 'rejected',
                            'status'         => 'cancelled',
                        ]);

                        Notification::make()
                            ->title('Pembayaran ditolak.')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\Action::make('generate_participant')
                    ->label('Buat Peserta')
                    ->icon('heroicon-o-user-plus')
                    ->color('info')
                    ->visible(fn ($record) => $record->payment_status === 'verified' && !$record->participant)
                    ->requiresConfirmation()
                    ->modalHeading('Buat Data Peserta')
                    ->modalDescription('Buat data peserta dari registrasi ini secara manual.')
                    ->action(function ($record) {
                        \App\Models\Participant::create([
                            'registration_id'  => $record->id,
                            'event_period_id'  => $record->event_period_id,
                            'event_class_id'   => null,
                            'child_full_name'  => $record->child_full_name,
                            'nickname'         => $record->nickname,
                            'gender'           => $record->gender,
                            'birth_date'       => $record->birth_date,
                            'grade'            => $record->grade,
                            'parent_name'      => $record->parent_name,
                            'parent_wa'        => $record->parent_wa,
                            'tshirt_size'      => $record->tshirt_size,
                            'allergies'        => $record->allergies,
                            'notes'            => $record->notes,
                            'created_by'       => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('✅ Data peserta berhasil dibuat!')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('already_participant')
                    ->label('Sudah Peserta')
                    ->icon('heroicon-o-check-badge')
                    ->color('gray')
                    ->disabled()
                    ->visible(fn ($record) => $record->payment_status === 'verified' && (bool) $record->participant),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
