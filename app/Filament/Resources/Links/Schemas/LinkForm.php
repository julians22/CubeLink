<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Link Details')
                    ->schema([
                        Select::make('landing_page_id')
                            ->relationship('landingPage', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('label')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('url')
                            ->url()
                            ->required()
                            ->maxLength(2048),
                        TextInput::make('icon')
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
