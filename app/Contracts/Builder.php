<?php

declare(strict_types = 1);

namespace App\Contracts;

interface Builder
{
    public function build(): self;
}
