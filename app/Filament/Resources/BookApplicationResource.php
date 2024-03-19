<?php

namespace App\Filament\Resources;

use App\Enums\BookApplicationStatusEnum;
use App\Filament\Resources\BookApplicationResource\Pages;
use App\Filament\Resources\BookApplicationResource\RelationManagers;
use App\Models\BookApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookApplicationResource extends Resource
{
    protected static ?string $model = BookApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')->required(),
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'name'),
                Forms\Components\TextInput::make('author_name'),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name'),
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\Select::make('status')->options(BookApplicationStatusEnum::class)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBookApplications::route('/'),
            'create' => Pages\CreateBookApplication::route('/create'),
            'view' => Pages\ViewBookApplication::route('/{record}'),
            'edit' => Pages\EditBookApplication::route('/{record}/edit'),
        ];
    }
}
