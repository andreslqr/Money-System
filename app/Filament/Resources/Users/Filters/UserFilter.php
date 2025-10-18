<?php

namespace App\Filament\Resources\Users\Filters;

use Filament\Tables\Filters\SelectFilter;

class UserFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute('user_id');
        $this->multiple();
        $this->relationship('user', 'name');
        $this->searchable();
        $this->preload();
    }
}
