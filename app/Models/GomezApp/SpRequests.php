<?php

namespace App\Models\GomezApp;


use Illuminate\Database\Eloquent\Model;

class SpRequests extends Model
{
    protected $connection = 'mysql_gomezapp';
    protected $table = 'gomezapp.sprequests';
    public $timestamps = false;
}
