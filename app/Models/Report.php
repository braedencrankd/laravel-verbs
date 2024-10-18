<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasSnowflakes;

    protected $guarded = [];
}
