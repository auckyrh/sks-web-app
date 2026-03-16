<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('id')
                ->label('Peserta')
                ->options(function ($livewire) {
                    $team = $livewire->getOwnerRecord();
                    return \App\Models\Participant::where('event_period_id', $team->event_period_id)
                        ->where('event_class_id', $team->event_class_id)
                        ->where(fn($q) => $q->whereNull('team_id')->orWhere('team_id', $team->id))
                        ->get()
                        ->mapWithKeys(fn ($p) => [
                            $p->id => $p->child_full_name . ' (Kelas ' . $p->grade . ')'
                        ]);
                })
                ->searchable()
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('child_full_name')
            ->columns([
                Tables\Columns\TextColumn::make('child_full_name')
                    ->label('Nama Peserta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Kelas')
                    ->formatStateUsing(fn ($state) => 'Kelas ' . $state)
                    ->badge(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('L/P')
                    ->formatStateUsing(fn ($state) => $state === 'M' ? '👦 L' : '👧 P'),
                Tables\Columns\TextColumn::make('parent_wa')
                    ->label('WA Ortu'),
                Tables\Columns\TextColumn::make('allergies')
                    ->label('Alergi')
                    ->default('—')
                    ->color('danger'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('assign_participant')
                    ->label('Assign Peserta')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\Select::make('participant_id')
                            ->label('Pilih Peserta')
                            ->options(function ($livewire) {
                                $team = $livewire->getOwnerRecord();
                                return \App\Models\Participant::where('event_period_id', $team->event_period_id)
                                    ->where('event_class_id', $team->event_class_id)
                                    ->whereNull('team_id')
                                    ->get()
                                    ->mapWithKeys(fn ($p) => [
                                        $p->id => $p->child_full_name . ' (Kelas ' . $p->grade . ')'
                                    ]);
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data, $livewire) {
                        \App\Models\Participant::find($data['participant_id'])
                            ?->update(['team_id' => $livewire->getOwnerRecord()->id]);

                        Notification::make()
                            ->title('✅ Peserta berhasil di-assign!')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('unassign')
                    ->label('Lepas')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['team_id' => null])),
            ]);
    }
}
