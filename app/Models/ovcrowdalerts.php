<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ovcrowdalerts extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ovcrowdalerts';

    protected $fillable = ['deviceid','date','time','hours','minutes','seconds','peoplecount'];

    use HasFactory;
}