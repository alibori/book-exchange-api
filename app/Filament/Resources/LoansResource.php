<?php

namespace App\Filament\Resources;

use App\Enums\LoanStatusEnum;
use App\Filament\Resources\LoansResource\Pages;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoansResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lender_id')
                    ->relationship('lender', 'name')->required(),
                Forms\Components\Select::make('borrower_id')
                    ->relationship('borrower', 'name')->required(),
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'title')->required(),
                Forms\Components\Datepicker::make('from')->required(),
                Forms\Components\Datepicker::make('to')->required(),
                Forms\Components\Select::make('status')->options(LoanStatusEnum::class)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lender.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('borrower.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('book.title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('from')->date()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('to')->date()->searchable()->sortable(),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoans::route('/create'),
            'view' => Pages\ViewLoans::route('/{record}'),
            'edit' => Pages\EditLoans::route('/{record}/edit'),
        ];
    }
}
