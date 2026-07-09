<?php

namespace App\Filament\Resources\LandingPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LandingPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->rows(4)
                            ->required(),
                        FileUpload::make('profile_picture')
                            ->image()
                            ->directory('profile-pictures')
                            ->disk('public')
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Theme')
                    ->schema([
                        TextInput::make('background_color')
                            ->placeholder('#ffffff')
                            ->required()
                            ->maxLength(20),
                        TextInput::make('text_color')
                            ->placeholder('#111827')
                            ->required()
                            ->maxLength(20),
                        TextInput::make('theme_slug')
                            ->required()
                            ->maxLength(100),
                        Textarea::make('custom_css')
                            ->rows(6)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
