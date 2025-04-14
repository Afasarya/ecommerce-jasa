<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceReviewResource\Pages;
use App\Models\ServiceReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ServiceReviewResource extends Resource
{
    protected static ?string $model = ServiceReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationGroup = 'Layanan';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Review')
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->label('Layanan')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->label('Pengguna')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('order_id')
                            ->label('Pesanan')
                            ->relationship('order', 'order_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Radio::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 - Sangat Buruk',
                                2 => '2 - Buruk',
                                3 => '3 - Cukup',
                                4 => '4 - Baik',
                                5 => '5 - Sangat Baik',
                            ])
                            ->required()
                            ->inline(),
                        Forms\Components\Textarea::make('comment')
                            ->label('Komentar')
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Dipublikasikan')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Layanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Nomor Pesanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'danger',
                        2 => 'warning',
                        3 => 'warning',
                        4 => 'success',
                        5 => 'success',
                    }),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Dipublikasikan')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Layanan')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '1 - Sangat Buruk',
                        2 => '2 - Buruk',
                        3 => '3 - Cukup',
                        4 => '4 - Baik',
                        5 => '5 - Sangat Baik',
                    ]),
                Tables\Filters\SelectFilter::make('is_published')
                    ->label('Status')
                    ->options([
                        '1' => 'Dipublikasikan',
                        '0' => 'Disembunyikan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('togglePublish')
                    ->label(fn (ServiceReview $record): string => $record->is_published ? 'Sembunyikan' : 'Publikasikan')
                    ->icon(fn (ServiceReview $record): string => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->action(function (ServiceReview $record): void {
                        $record->update([
                            'is_published' => !$record->is_published,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publikasikan')
                        ->icon('heroicon-o-eye')
                        ->action(fn (Collection $records) => $records->each->update(['is_published' => true])),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Sembunyikan')
                        ->icon('heroicon-o-eye-slash')
                        ->action(fn (Collection $records) => $records->each->update(['is_published' => false])),
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
            'index' => Pages\ListServiceReviews::route('/'),
            'create' => Pages\CreateServiceReview::route('/create'),
            'edit' => Pages\EditServiceReview::route('/{record}/edit'),
        ];
    }
}
