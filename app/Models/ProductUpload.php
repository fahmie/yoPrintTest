<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUpload extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'status', 'uploaded_at', 'updated_at', 'created_at'];
}
