<?php

namespace App\Models;

use App\Enums\OutcomeStatus;

/**
 * @inheritDoc
 */
class Outcome extends Balance
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'accounting_period_id',
        'payment_method_id',
        'user_id',
        'business_id',
        'name',
        'description',
        'amount',
        'expense_date',
        'status',
        'receipt_photo'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'status' => OutcomeStatus::class
        ];
    }
}
