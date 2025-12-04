<?php

namespace App\Filament\Resources;

// Essential use statements for the core Filament classes
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Essential use statements for the Page classes
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;

class ProductResource extends Resource
{
    // --- Model and Navigation Properties ---

    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    // Optional: Group the resource in the sidebar
    // Type removed to match parent class (UnitEnum|string|null) requirement
    protected static $navigationGroup = 'Shop'; 

    // --- Form Schema (Create/Edit) ---

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Forms\Components\TextInput::make('sku')
                ->maxLength(100)
                ->label('SKU'),

            Forms\Components\TextInput::make('price')
                ->numeric()
                ->required()
                ->prefix('$'),

            Forms\Components\Textarea::make('description')
                ->columnSpanFull(), // Make description take full width

            Forms\Components\TextInput::make('stock')
                ->numeric()
                ->default(0)
                ->minValue(0),
                
            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),
        ])
        ->columns(2); // Set the form layout to 2 columns
    }

    // --- Table Schema (List View) ---

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('sku')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('price')
                ->money('USD')
                ->sortable(),

            Tables\Columns\TextColumn::make('stock')
                ->numeric()
                ->sortable()
                ->color(fn (string $state): string => match (true) {
                    $state < 10 => 'danger',
                    $state < 50 => 'warning',
                    default => 'success',
                }),

            Tables\Columns\ToggleColumn::make('is_active')
                ->label('Active'),
        ])
        ->filters([
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Active Products')
                ->indicator('Active'),
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

    // --- Relationships ---

    public static function getRelations(): array
    {
        return [
            // Define any relationship tables here, e.g., 'RelatedProductsRelationManager::class'
        ];
    }

    // --- Pages and Routes ---

    public static function getPages(): array
    {
        return [
            'index'  => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit'   => EditProduct::route('/{record}/edit'),
        ];
    }
    
    // --- Global Search ---

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku'];
    }

    // Optional: Modify the default eloquent query for all lists/tables
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}