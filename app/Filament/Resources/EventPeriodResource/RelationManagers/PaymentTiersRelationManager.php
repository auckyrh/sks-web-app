<?php

namespace App\Filament\Resources\EventPeriodResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentTiersRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentTiers';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Tier')
                ->placeholder('e.g. Early Bird, Normal')
                ->required(),
            Forms\Components\TextInput::make('amount')
                ->label('Nominal (Rp)')
                ->numeric()
                ->prefix('Rp')
                ->required(),
            Forms\Components\DatePicker::make('valid_from')
                ->label('Berlaku Dari')
                ->native(false)
                ->displayFormat('d M Y')
                ->required(),
            Forms\Components\DatePicker::make('valid_until')
                ->label('Berlaku Sampai')
                ->native(false)
                ->displayFormat('d M Y')
                ->afterOrEqual('valid_from')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tier'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Dari')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Sampai')
                    ->date('d M Y'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
