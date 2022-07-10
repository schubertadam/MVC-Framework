<?php

namespace App\Models;

use App\Core\Model;

class TestModel extends Model
{
    public string $username =  '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function label(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password'
        ];
    }
}