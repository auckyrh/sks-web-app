<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Division;
use App\Models\EventPeriod;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Users';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Pribadi')
                ->schema([
                    Forms\Components\TextInput::make('full_name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nick_name')
                        ->label('Nama Panggilan')
                        ->nullable()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->nullable(),
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')
                        ->nullable(),
                    Forms\Components\Select::make('wilayah_id')
                        ->label('Wilayah')
                        ->relationship('wilayah', 'name')
                        ->nullable()
                        ->searchable()
                        ->preload()
                        ->native(false),
                ])->columns(2),

            Forms\Components\Section::make('Akun & Akses')
                ->schema([
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('phone')
                        ->label('No. WhatsApp')
                        ->tel()
                        ->nullable(),
                    Forms\Components\Select::make('role')
                        ->label('Role')
                        ->options([
                            'superadmin' => 'Super Admin',
                            'admin'      => 'Admin',
                            'member'     => 'Member',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('user-photos')
                        ->nullable()
                        ->getUploadedFileNameForStorageUsing(function ($file, Forms\Get $get) {
                            $name = str_replace(' ', '-', ucwords(strtolower($get('full_name') ?? 'unknown')));
                            $ts   = now()->format('Ymd_His');
                            $ext  = $file->getClientOriginalExtension();
                            return "PHOTO-{$name}-{$ts}.{$ext}";
                        }),
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $operation) => $operation === 'create')
                        ->helperText('Kosongkan jika tidak ingin mengubah password'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nick_name')
                    ->label('Panggilan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('WhatsApp'),
                Tables\Columns\TextColumn::make('currentAssignment.division.name')
                    ->label('Divisi (Aktif)')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Role')
                    ->colors([
                        'danger'  => 'superadmin',
                        'warning' => 'admin',
                        'gray'    => 'member',
                    ]),
                Tables\Columns\TextColumn::make('wilayah.name')
                    ->label('Wilayah')
                    ->badge()
                    ->color('indigo')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Update')
                    ->dateTime("d M Y h:i:s")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted At')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'superadmin' => 'Super Admin',
                        'admin'      => 'Admin',
                        'member'     => 'Member',
                    ]),
                Tables\Filters\SelectFilter::make('division_id')
                    ->label('Divisi (Aktif)')
                    ->options(fn () => Division::orderBy('name')->pluck('name', 'id'))
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['value'])) {
                            return $query;
                        }
                        $activePeriodId = EventPeriod::where('is_active', true)->value('id');
                        return $query->whereHas('committeeAssignments', function (Builder $q) use ($data, $activePeriodId): void {
                            $q->where('division_id', $data['value'])
                              ->where('event_period_id', $activePeriodId);
                        });
                    }),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
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
            ->defaultPaginationPageOption(50);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CommitteeAssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
