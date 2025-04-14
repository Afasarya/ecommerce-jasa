<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionRelationManager extends RelationManager
{
    protected static string $relationship = 'transaction';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('transaction_id')
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('ID Transaksi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Metode Pembayaran'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        'expired' => 'danger',
                        'refunded' => 'info',
                    }),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Waktu Pembayaran')
                    ->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
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
}