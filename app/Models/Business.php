<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Business extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'business_category_id',
        'coordinates'
    ];


    public function BusinessCategory(): BelongsTo
    {
        return $this->belongsTo(BusinessCategory::class);
    }
}
