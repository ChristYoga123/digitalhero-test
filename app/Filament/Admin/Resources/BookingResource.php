<?php

namespace App\Filament\Admin\Resources;

use Exception;
use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Enums\Booking\StatusEnum;
use Illuminate\Support\Facades\DB;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Filament\Admin\Resources\BookingResource\RelationManagers;

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
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
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
                Tables\Actions\Action::make('selesaikanSesi')
                    ->button()
                    ->color('success')
                    ->label('Selesaikan Sesi')
                    ->visible(fn(Booking $booking) => $booking->status === StatusEnum::SUKSES && $booking->is_aktif)
                    ->requiresConfirmation()
                    ->action(function(Booking $booking)
                    {
                        DB::beginTransaction();
                        try
                        {
                            $booking->update([
                                'is_aktif' => false,
                            ]);
    
                            $booking->service->update([
                                'slot' => $booking->service->slot + $booking->jumlah_sesi,
                            ]);

                            DB::commit();
    
                            Notification::make()
                                ->title('Sukses')
                                ->body('Sesi telah diselesaikan')
                                ->success()
                                ->send();
                        }catch(Exception $e)
                        {
                            DB::rollBack();
                            Notification::make()
                                ->title('Gagal')
                                ->body('Sesi gagal diselesaikan')
                                ->danger()
                                ->send();
                        }
                        

                    }),
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
