<?php

namespace App\DTO;

class BaseDTO
{
    public static function from(array $parameters): static
    {
        return app(static::class, $parameters);
    }

    public function all(): array
    {
        return get_object_vars($this);
    }
}
