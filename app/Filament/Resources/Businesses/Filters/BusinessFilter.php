<?php

namespace App\Filament\Resources\Businesses\Filters;

use Filament\Tables\Filters\SelectFilter;

class BusinessFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute('business_id');
        $this->multiple();
        $this->relationship('business', 'name');
        $this->searchable();
        $this->preload();
    }
}
