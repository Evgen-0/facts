<?php

namespace App\Filament\Resources\FactResource\Pages;

use App\Filament\Resources\FactResource;
use App\Models\Fact;
use App\Models\FactStat;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFacts extends ListRecords
{
    protected static string $resource = FactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function (CreateAction $action, Fact $record) {
                    FactStat::create([
                        'fact_id' => $record->id,
                        'views' => 0,
                        'likes' => 0,
                        'comments' => 0,
                    ]);
                }),
        ];
    }
}
