<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class cdStatistic extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cd_statistics';

    protected $fillable = ['deviceid','peoplecount','date','time'];

    use HasFactory;
}

