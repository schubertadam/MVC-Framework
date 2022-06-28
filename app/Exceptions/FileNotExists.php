<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class FileNotExists extends Exception
{

    #[Pure] public function __construct(string $file)
    {
        parent::__construct("The required $file file not exists!");
    }
}