<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\FactsRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Користувачі';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Інформація про користувача')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Ім\'я')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn(Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('slug')
                            ->unique(ignorable: fn () => $form->getRecord())
                            ->required()
                            ->maxLength(128),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('Пароль')
                            ->password()
                            ->revealable()
                            ->required()
                            ->visible(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255),
                    ])
                    ->columns(),
                Forms\Components\Section::make('Картинка')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Картинка')
                            ->image()
                            ->columnSpan('full'),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make('Мета-дані')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Мета заголовок')
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(128),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Мета опис')
                            ->columnSpan('full')
                            ->maxLength(256),
                    ]),
                Forms\Components\Section::make('Пов\'язані дані')
                    ->relationship('link')
                    ->schema([
                        Forms\Components\TextInput::make('telegram_id')
                            ->label('Telegram ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('instagram_id')
                            ->label('Instagram ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('facebook_id')
                            ->label('Facebook ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('twitter_id')
                            ->label('Twitter ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tiktok_id')
                            ->label('TikTok ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('github_id')
                            ->label('GitHub ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('gitlab_id')
                            ->label('GitLab ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('twitch_id')
                            ->label('Twitch ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('discord_id')
                            ->label('Discord ID')
                            ->columnSpan('full')
                            ->maxLength(255),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Картинка'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ім\'я')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Email підтверджено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            FactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
