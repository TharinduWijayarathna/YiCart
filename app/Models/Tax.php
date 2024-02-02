<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
 * Tax
 * php version 8
 *
 * @category Model

 * */
class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'abbreviation',
        'created_by',
        'updated_by',
    ];
}
