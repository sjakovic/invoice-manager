<?php

namespace App\Interfaces;

interface MapperInterface
{
    public function mapToModelCreate(array $data);
    public function mapToModelUpdate(array $data);
}
