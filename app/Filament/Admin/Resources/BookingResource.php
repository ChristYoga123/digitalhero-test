<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Filament\Admin\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

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
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
                    ->label('Selesaikan Sesi')
                    ->requiresConfirmation()
                    ->action(function(Booking $booking)
                    {
                        DB::beginTransaction();
                        try
                        {
                            $booking->update([
                                'is_akif' => false,
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
                                ->error()
                                ->send();
                        }
                        

                    })
                    ->visible(fn(Booking $booking) => $booking->is_akif),
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
