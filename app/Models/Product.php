<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'unique_key', 'product_title', 'product_description', 'style', 'sanmar_mainframe_color', 'size', 'color_name', 'piece_price'];
}
