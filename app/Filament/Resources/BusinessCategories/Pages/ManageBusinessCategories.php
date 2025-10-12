<?php

namespace App\Filament\Resources\BusinessCategories\Pages;

use App\Filament\Resources\BusinessCategories\BusinessCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBusinessCategories extends ManageRecords
{
    protected static string $resource = BusinessCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
