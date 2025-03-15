<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Enums\Booking\StatusEnum;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\BookingResource\Pages;
use App\Filament\User\Resources\BookingResource\RelationManagers;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Booking';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Booking::query()->whereUserId(auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_booking')
                    ->date()
                    ->getStateUsing(fn(Booking $booking) => // format indonesia Hari, Tanggal Bulan Tahun
                        $booking->tanggal_booking->format('l, d F Y')
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_sesi')
                    ->getStateUsing(fn(Booking $booking) => $booking->jumlah_sesi . ' Sesi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->numeric()
                    ->money('IDR')
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn(Booking $booking) => match ($booking->status) {
                        StatusEnum::SUKSES => 'success',
                        StatusEnum::MENUNGGU => 'warning',
                        StatusEnum::BATAL => 'danger',
                    }),
                Tables\Columns\TextColumn::make('is_aktif')
                    ->label('Status Booking')
                    ->badge()
                    ->color(fn(Booking $booking) => $booking->is_aktif ? 'success' : 'danger')
                    ->getStateUsing(fn(Booking $booking) => $booking->is_aktif ? 'Aktif' : 'Tidak Aktif'),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBookings::route('/'),
        ];
    }
}
