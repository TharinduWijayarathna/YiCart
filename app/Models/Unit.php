<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
 * Unit
 * php version 8
 *
 * @category Model

 * */
class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'created_by',
        'updated_by',
    ];
}
