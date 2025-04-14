<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_id')
                    ->label('Layanan')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('service_name')
                    ->label('Nama Layanan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1),
                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->maxLength(500),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->columns([
                Tables\Columns\TextColumn::make('service_name')
                    ->label('Layanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->state(function ($record): float {
                        return $record->price * $record->quantity;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {
                        // Recalculate order total
                        $order = $record->order;
                        $order->total_amount = $order->items->sum(function($item) {
                            return $item->price * $item->quantity;
                        });
                        $order->save();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($record, $data) {
                        // Recalculate order total
                        $order = $record->order;
                        $order->total_amount = $order->items->sum(function($item) {
                            return $item->price * $item->quantity;
                        });
                        $order->save();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        // Recalculate order total
                        $order = $record->order;
                        $order->total_amount = $order->items->sum(function($item) {
                            return $item->price * $item->quantity;
                        });
                        $order->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function ($records) {
                            // Get the order from the first record (all records belong to the same order)
                            if ($records->isNotEmpty()) {
                                $order = $records->first()->order;
                                $order->total_amount = $order->items->sum(function($item) {
                                    return $item->price * $item->quantity;
                                });
                                $order->save();
                            }
                        }),
                ]),
            ]);
    }
}