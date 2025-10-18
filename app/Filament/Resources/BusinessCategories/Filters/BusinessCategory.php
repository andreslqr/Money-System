<?php

namespace App\Filament\Resources\BusinessCategories\Filters;

use Filament\Tables\Filters\SelectFilter;

class BusinessCategory extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute('business_category_id');
        $this->multiple();
        $this->relationship('businessCategory', 'name');
        $this->searchable();
        $this->preload();
    }
}
