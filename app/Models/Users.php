<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table='users';

    protected $appends=['name'];

    public function getNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }
}
