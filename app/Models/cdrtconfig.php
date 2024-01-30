<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class cdrtconfig extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cdrtconfig';

    protected $fillable = ['deviceid','latestRecordtoGet' , 'maxcrowd'];

    use HasFactory;
}
