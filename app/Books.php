<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use SoftDeletes;//dodaje do tej rabeli miękie usuwanie 

    protected $table = "books";//podaje nazwę tabeli
    protected $primaryKey = "id_book";// nazwę jej klucza 
    protected $dates = ["deleted_at"];// pole do miętkiego usuwania

    public function categories(){//wybieram wszystkie powiązane kategorie z daną książkom oczywiście te które nie zostały usunięte miękko
        return $this->belongsToMany('App\Categories', 'books_categories', 'id_book', 'id_category')->wherePivot('deleted_at', null);
    }
}
