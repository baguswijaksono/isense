<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class cdStatistic extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cd_statistics';

    protected $fillable = ['deviceid','peoplecount','people_with_mask','people_without_mask','date','time','hours','minutes','seconds'];

    use HasFactory;
}

