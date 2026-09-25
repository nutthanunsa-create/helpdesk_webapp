<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    protected $fillable = ['company', 'priority', 'hours', 'name_th'];
}
