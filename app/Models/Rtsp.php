<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model;

class Rtsp extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'rtsp';
    protected $fillable = ['name','raw_url', 'description' ,'image'];
    use HasFactory;
}
