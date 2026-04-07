<?php

namespace App\Filament\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Picture')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label(false)
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
                    ])
                    ->columns(1)
                    ->extraAttributes(['class' => 'flex flex-col items-center']),

                Forms\Components\Section::make('Personal Information')
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
                        Forms\Components\TextInput::make('phone')
                            ->label('No. WhatsApp')
                            ->tel()
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Account Settings')
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->columns(2),
            ]);
    }
}
