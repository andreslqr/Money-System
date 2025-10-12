<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BusinessCategory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'color',
        'description',
        'sort'
    ];

    /**
     * Interact with the user's color.
     */
    protected function color(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->start('#'),
            set: fn (string $value) => Str::of($value)->chopStart('#'),
        );
    }
}
