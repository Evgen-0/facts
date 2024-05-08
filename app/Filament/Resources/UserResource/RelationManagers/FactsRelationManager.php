<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Category;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FactsRelationManager extends RelationManager
{
    protected static string $relationship = 'facts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('heading')
                    ->label('Заголовок')
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('slug')
                    ->unique(ignorable: fn() => $form->getRecord())
                    ->required()
                    ->maxLength(128),
                Forms\Components\FileUpload::make('body')
                    ->label('Картинка')
                    ->image()
                    ->columnSpan('full'),
                Forms\Components\Select::make('user_id')
                    ->label('Користувач що додав')
                    ->options(User::orderByRaw("CASE WHEN name = 'Humor' THEN 1 WHEN name = 'Memes' THEN 2 WHEN name = 'Wtf' THEN 3 ELSE 4 END, id")->limit(15)->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Категорія')
                    ->options(Category::limit(15)->pluck('name', 'id')->toArray())
                    ->searchable(),
                Forms\Components\TextInput::make('title')
                    ->label('Мета заголовок')
                    ->required()
                    ->columnSpan('full')
                    ->maxLength(128),
                Forms\Components\MarkdownEditor::make('description')
                    ->label('Мета опис')
                    ->columnSpan('full')
                    ->maxLength(256),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('heading')
            ->columns([
                Tables\Columns\TextColumn::make('heading'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
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
