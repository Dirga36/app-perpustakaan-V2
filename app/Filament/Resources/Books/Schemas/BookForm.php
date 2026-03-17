<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('authorName')
                    ->required(),
                TextInput::make('ISBN')
                    ->required(),
                TextInput::make('publishedYear')
                    ->required(),
                TextInput::make('coverImage')
                    ->required(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
