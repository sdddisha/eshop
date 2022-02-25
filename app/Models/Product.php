<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table= 'products';
    protected $fillable=['cat_id','pname','name','price','sku','desc','sub_cat','file_path'];
}
