<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClasification extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    public $timestamps = false;
    protected $table = 'users_clasification';

    protected $fillable = [
        'name',
    ];
}
