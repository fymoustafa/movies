<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','image','rate','user_id'];

    function categories() : BelongsToMany {
     return  $this->belongsToMany(Category::class,'movies_categories','movie_id','category_id');       
    }

    function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
    function getImageAttribute($value){
        return '/storage/'.$value;
    }
    function getNameAttribute($value){
        return Str::title($value);
    }
}
