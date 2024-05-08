<?php

namespace App\Filament\Resources\FactResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LikesRelationManager extends RelationManager
{
    protected static string $relationship = 'likes';

    protected static ?string $label = 'Лайки';

    protected static ?string $title = 'Лайки';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Користувач')
                    ->options(User::limit(15)->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Forms\Components\Toggle::make('is_like')
                    ->label('')
                    ->onIcon('heroicon-m-hand-thumb-up')
                    ->offIcon('heroicon-m-hand-thumb-down')
                    ->onColor('success')
                    ->offColor('danger')
                    ->required(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('is_like')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_like')
                    ->label('Лайк/Дизлайк')
                    ->onIcon('heroicon-m-hand-thumb-up')
                    ->offIcon('heroicon-m-hand-thumb-down')
                    ->onColor('success')
                    ->offColor('danger'),
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
