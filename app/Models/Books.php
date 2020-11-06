<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes ;

class Books extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'author', 'editor', 'publisher', 'place_of_publication', 'copyright_date', 'edition', 'category', 'language'];
}