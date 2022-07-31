<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

abstract class BaseDTO implements Arrayable
{
    public string|int|null $id;
}
