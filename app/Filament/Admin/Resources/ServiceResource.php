<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ServiceResource\Pages;
use App\Filament\Admin\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Layanan Rental';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                            ->label('Gambar (Max. 1 MB)')
                            ->image()
                            ->required()
                            ->maxFiles(1)
                            ->maxSize(1024)
                            ->collection('service-image'),
                        Forms\Components\TextInput::make('harga_per_sesi')
                            ->required()
                            ->prefix('Rp')
                            ->suffix('/Sesi')
                            ->numeric(),
                        Forms\Components\TextInput::make('slot')
                            ->label('Slot Tersedia')
                            ->required()
                            ->numeric(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                            ->label('Galeri (Opsional dan Bisa Diisi Lebih Dari Satu)')
                            ->image()
                            ->multiple()
                            ->collection('service-gallery'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('gambar')
                    ->collection('service-image'),
                Tables\Columns\TextColumn::make('slot')
                    ->sortable()
                    ->getStateUsing(fn(Service $service) => $service->slot . ' Slot'),
                Tables\Columns\TextColumn::make('harga_per_sesi')
                    ->numeric()
                    ->money('IDR')
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                Tables\Columns\TextColumn::make('ketersediaan')
                    ->badge()
                    ->getStateUsing(fn(Service $service) => $service->slot > 0 ? 'Tersedia' : 'Tidak Tersedia')
                    ->color(fn (Service $service) => $service->slot > 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('ketersediaan')
                    ->form([
                        Select::make('ketersediaan')
                            ->label('')
                            ->placeholder('Pilih Ketersediaan')
                            ->options([
                                'tersedia' => 'Tersedia',
                                'tidak-tersedia' => 'Tidak Tersedia',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['ketersediaan'],
                                fn (Builder $query, $data): Builder => $data === 'tersedia' ? $query->where('slot', '>', 0) : $query->where('slot', 0)
                            );
                    }),
                    
                ], FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
        ];
    }
}
