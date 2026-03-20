<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
                    ->label('Author Name')
                    ->required(),
                TextInput::make('ISBN')
                    ->label('ISBN')
                    ->required(),
                TextInput::make('publishedYear')
                    ->label('Published Year')
                    ->required()
                    ->numeric(),
                FileUpload::make('coverImage')
                    ->label('Cover Image')
                    ->image()
                    ->directory('books/covers')
                    ->disk('public')
                    ->visibility('public')
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
