<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freequote extends Model
{
    use HasFactory;

        protected $guarded = [];

    protected $table = "request_quote";
}