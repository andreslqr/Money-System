<?php

namespace App\Filament\Resources\PaymentMethods\Filters;

use Filament\Tables\Filters\SelectFilter;

class PaymentMethodFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute('payment_method_id');
        $this->multiple();
        $this->relationship('paymentMethod', 'name');
        $this->searchable();
        $this->preload();
    }
}
