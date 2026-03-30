<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicPageResource\Pages;
use App\Filament\Resources\PublicPageResource\RelationManagers;
use App\Models\PublicPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublicPageResource extends Resource
{
    protected static ?string $model = PublicPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Public Page Information';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('event_period_id')
                    ->label('Event Period')
                    ->relationship('eventPeriod', 'year')
                    ->required()
                    ->native(false)
                    ->preload()
                    ->default(fn () => \App\Models\EventPeriod::where('is_active', true)->first()?->id),
                Forms\Components\Select::make('type')
                    ->label('Tipe Halaman')
                    ->options([
                        'rundown'    => 'Rundown Acara',
                        'tata_tertib' => 'Tata Tertib',
                        'informasi'  => 'Informasi Umum',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('title')
                    ->label('Judul Halaman')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->helperText('Halaman hanya tampil di publik jika dipublikasikan')
                    ->onColor('success'),
            ])->columns(2),

            Forms\Components\Section::make('Konten')->schema([
                \FilamentTiptapEditor\TiptapEditor::make('content')
                    ->label('')
                    ->profile('default')
                    ->required()
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Tahun')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'rundown'     => 'Rundown',
                        'tata_tertib' => 'Tata Tertib',
                        'informasi'   => 'Informasi',
                        default       => $state,
                    })
                    ->colors([
                        'primary' => 'rundown',
                        'warning' => 'tata_tertib',
                        'info'    => 'informasi',
                        'success' => 'kontak',
                    ]),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Dipublikasikan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Tahun')
                    ->relationship('eventPeriod', 'year'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'rundown'     => 'Rundown',
                        'tata_tertib' => 'Tata Tertib',
                        'informasi'   => 'Informasi',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
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
            'index' => Pages\ListPublicPages::route('/'),
            'create' => Pages\CreatePublicPage::route('/create'),
            'edit' => Pages\EditPublicPage::route('/{record}/edit'),
        ];
    }
}
