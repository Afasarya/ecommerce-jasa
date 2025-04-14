<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use App\Models\ServiceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use FilamentSpatieLaravelMediaLibraryPlugin\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Collection;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    
    protected static ?string $navigationGroup = 'Layanan';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->options(ServiceCategory::pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Layanan')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Service::class, 'slug', ignoreRecord: true),
                        Forms\Components\Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->required()
                            ->maxLength(500),
                    ])->columns(2),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->collection('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('gallery')
                            ->label('Galeri')
                            ->multiple()
                            ->image()
                            ->maxFiles(5),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Deskripsi')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('services')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('what_you_get')
                            ->label('Apa yang Anda Dapatkan')
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->label('Item')
                                    ->required(),
                            ])
                            ->defaultItems(3)
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Harga & Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('discounted_price')
                            ->label('Harga Diskon')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('delivery_time')
                            ->label('Waktu Pengerjaan (hari)')
                            ->required()
                            ->numeric()
                            ->default(1),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discounted_price')
                    ->label('Harga Diskon')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_time')
                    ->label('Waktu (Hari)')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(ServiceCategory::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ]),
                Tables\Filters\SelectFilter::make('is_featured')
                    ->label('Featured')
                    ->options([
                        '1' => 'Ya',
                        '0' => 'Tidak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggleActive')
                        ->label('Toggle Status')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->update(['is_active' => !$record->is_active]);
                            }
                        }),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}