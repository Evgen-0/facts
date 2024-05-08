<?php

namespace App\Filament\Resources\FactResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $label = 'Коментарі';

    protected static ?string $title = 'Коментарі';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->label('Текст')
                    ->required()
                    ->maxLength(255)
                    ->rows(5),
                Forms\Components\Select::make('user_id')
                    ->label('Користувач')
                    ->options(User::limit(15)->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('parent_id')
                    ->label('Відповідає на')
                    ->options(fn() => $form->getLivewire()->ownerRecord->comments->pluck('body', 'id')->toArray())
                    ->searchable(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([
                Tables\Columns\TextColumn::make('body')
                    ->label('Текст')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.body')
                    ->label('Відповідає на')
                    ->searchable()
                    ->default('—')
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
