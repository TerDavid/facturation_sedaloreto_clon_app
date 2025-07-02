<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateType extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public const ANULADO = '11';
    public const ACEPTADO = '05';
}