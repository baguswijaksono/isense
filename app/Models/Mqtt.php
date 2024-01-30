<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Mqtt extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mqtt_sub_info';

    protected $fillable = ['port','topic','host'];

    use HasFactory;
}
