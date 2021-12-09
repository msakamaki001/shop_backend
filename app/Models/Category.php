<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Items;

class Category extends Model
{
    protected $table = 'category';
    protected $guarded = [
        'id'
    ];
}
