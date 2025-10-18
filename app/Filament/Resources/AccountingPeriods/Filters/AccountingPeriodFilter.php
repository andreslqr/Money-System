<?php

namespace App\Filament\Resources\AccountingPeriods\Filters;

use Filament\Tables\Filters\SelectFilter;

class AccountingPeriodFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute('accounting_period_id');
        $this->multiple();
        $this->relationship('accountingPeriod', 'name');
        $this->searchable();
        $this->preload();
    }
}
