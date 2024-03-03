<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $label = 'Категорії';

    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Інформація про категорію')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Назва')
                            ->live()
                            ->afterStateUpdated(fn(Forms\Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                            ->required()
                            ->maxLength(128),
                        Forms\Components\TextInput::make('slug')
                            ->unique(ignorable: fn() => $form->getRecord())
                            ->required()
                            ->maxLength(128),
                        Forms\Components\Repeater::make('aliases')
                            ->label('Псевдоніми')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Псевдонім')
                                    ->maxLength(128),
                            ]),
                        Forms\Components\Select::make('parent_id')
                            ->label('Батьківська категорія')
                            ->searchable()
                            ->options(Category::limit(15)->pluck('name', 'id')->toArray()),
                    ]),
                Forms\Components\Section::make('Картинка')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Картинка')
                            ->columnSpan('full'),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make('Мета-дані')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Мета заголовок')
                            ->required()
                            ->maxLength(128),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Мета опис')
                            ->maxLength(256),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Картинка'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Мета заголовок')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->label('Мета опис')
                    ->searchable()
                    ->markdown()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Батьківська категорія'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
