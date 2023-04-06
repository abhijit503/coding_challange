<?php

namespace App\Models;

use Database\Factories\UsersFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table='users';

    protected static function factory()
    {
        return UsersFactory::new();
    }
}
