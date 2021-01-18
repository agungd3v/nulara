<?php

namespace App\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserToken extends Model
{
    use SoftDeletes;

    protected $connection   = 'mysql';
    protected $table        = 'user_token';
    public $timestamps      = true;
    
}