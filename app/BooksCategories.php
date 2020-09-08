<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BooksCategories extends Model
{
    use SoftDeletes;//dodaje do tej rabeli miękie usuwanie 

    protected $table = "books_categories";//podaje nazwę tabeli
    protected $primaryKey = "id"; // nazwę jej klucza 
    protected $dates = ["deleted_at"];// pole do miętkiego usuwania

}
