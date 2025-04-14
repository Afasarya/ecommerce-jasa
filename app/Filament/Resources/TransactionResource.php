<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    
    protected static ?string $navigationGroup = 'Penjualan';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->label('Pesanan')
                            ->relationship('order', 'order_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('ID Transaksi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('payment_type')
                            ->label('Metode Pembayaran')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Menunggu',
                                'success' => 'Berhasil',
                                'failed' => 'Gagal',
                                'expired' => 'Kadaluarsa',
                                'refunded' => 'Dikembalikan',
                            ])
                            ->required(),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Waktu Pembayaran'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\Textarea::make('payment_details')
                            ->label('Detail')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('ID Transaksi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Nomor Pesanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Metode Pembayaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        'expired' => 'danger',
                        'refunded' => 'info',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Waktu Pembayaran')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'success' => 'Berhasil',
                        'failed' => 'Gagal',
                        'expired' => 'Kadaluarsa',
                        'refunded' => 'Dikembalikan',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('viewOrder')
                    ->label('Lihat Pesanan')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Transaction $record): string => route('orders.show', $record->order->order_number))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}