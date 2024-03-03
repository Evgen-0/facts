<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FactResource\Pages;
use App\Filament\Resources\FactResource\RelationManagers\TagsRelationManager;
use App\Models\Category;
use App\Models\Fact;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FactResource extends Resource
{
    protected static ?string $model = Fact::class;

    protected static ?string $label = 'Факти';

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('body')
                    ->label('Картинка'),
                Tables\Columns\TextColumn::make('heading')
                    ->label('Заголовок')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категорія'),
                Tables\Columns\TextColumn::make('stat.views')
                    ->label('Переглядів')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stat.likes')
                    ->label('Лайків')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stat.comments')
                    ->label('Коментарів')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Мета заголовок')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Мета опис')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->markdown()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacts::route('/'),
            'create' => Pages\CreateFact::route('/create'),
            'edit' => Pages\EditFact::route('/{record}/edit'),
        ];
    }
}
