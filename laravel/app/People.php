<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'people';
    protected $primaryKey = 'id';
    protected $fillable = ['first_name', 'last_name', 'age', 'gender', 'hoby'];
    public $timestamps = true;
}
