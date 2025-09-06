<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thank extends Model
{
    protected $table = 'thanks';
    protected $fillable = ['user'];
}
