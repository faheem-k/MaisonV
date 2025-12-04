<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('original_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('category')
                    ->required()
                    ->default('fashion'),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('sku')
                    ->label('SKU'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_new')
                    ->required(),
                Toggle::make('is_sale')
                    ->required(),
                Toggle::make('featured')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reviews_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('sizes')
                    ->columnSpanFull(),
                Textarea::make('colors')
                    ->columnSpanFull(),
            ]);
    }
}
