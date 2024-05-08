<?php

namespace App\Filament\Resources\FactResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CollectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'collections';

    protected static ?string $label = 'Колекції';

    protected static ?string $title = 'Колекції';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->maxLength(128),
                Forms\Components\TextInput::make('slug')
                    ->unique(ignorable: fn() => $form->getRecord())
                    ->required()
                    ->maxLength(128),
                Forms\Components\Select::make('user_id')
                    ->label('Користувач')
                    ->options(User::limit(15)->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('title')
                    ->label('Мета заголовок')
                    ->required()
                    ->maxLength(128)
                    ->columnSpan('full'),
                Forms\Components\MarkdownEditor::make('description')
                    ->label('Мета опис')
                    ->maxLength(256)
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
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
}
