<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShare extends Model
{
    use HasFactory;

    protected $table = 'orders_share';

    public $timestamps = false;
}