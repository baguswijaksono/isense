<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class MqttMessage extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mqtt_messages';
   
    protected $fillable = ['topic','message'];
    use HasFactory;
}
