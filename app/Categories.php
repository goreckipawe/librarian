<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;//dodaje do tej rabeli miękie usuwanie 

    protected $table = "categories";//podaje nazwę tabeli
    protected $primaryKey = "id_category";// nazwę jej klucza 
    protected $dates = ["deleted_at"];// pole do miętkiego usuwania

    public function books(){
        return $this->belongsToMany('App\Books', 'books_categories', 'id_category', 'id_book');
    }
}
