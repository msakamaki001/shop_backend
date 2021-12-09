<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Items extends Model
{
    protected $table = 'items';
    protected $guarded = [
        'id'
    ];
}
