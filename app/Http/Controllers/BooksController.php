<?php

namespace App\Http\Controllers;

use App\Books;
use App\BooksCategories;
use Illuminate\Http\Request;
use DB;
//use Debugbar;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Books::where('deleted_at', null)->get();

        foreach ($books as $book) {//dodaję do każdego elemętu/rekordu $book kategorie z którymi jest powiązany
            $book['categories'] = Books::findOrFail($book['id_book'])->categories;
        }

        return $books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $book = new Books;//dodaję nowy rekord oczywiście najpierw formatując datę 
        $book->title = $request->title;
        $book->description = $request->description;
        $book->year_of_publishment = $request->year_of_publishment;
        $date = date( "Y-m-d", strtotime( $request->date_of_creation ) );
        $book->date_of_creation = $date;
        $book->save();

        foreach ($request->categories as $category) {
            $books_categories = new BooksCategories;
            $books_categories->id_book = $book->id_book;
            $books_categories->id_category = $category["id_category"];
            $books_categories->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\books  $books
     * @return \Illuminate\Http\Response
     */
    public function show(books $books)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\books  $books
     * @return \Illuminate\Http\Response
     */
    public function edit(books $books)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $book = Books::findOrFail($request->id_book);//szukam rekordu o danym id
        //Debugbar::info($book); //dodałem też debugera do projektu jednk go wyłączyłem żeby pokazać że wiem o jego istnieniu :)
        $book->title = $request->title;//przypisuje mu nowe dane 
        $book->description = $request->description;
        $book->year_of_publishment = $request->year_of_publishment;
        $date = date( "Y-m-d", strtotime( $request->date_of_creation ) );//formatuje mu oczywiście datę 
        $book->date_of_creation = $date;
        $book->save();//zapisuje go z nowymi danymi

        //zdecydowałem się usunąc na miętko wszystkie wpisy do tego rekordu w tabeli łącznikowej, a następnie przywracam te które wybrał użytkownik
        //zrobiłem to w ten sposub żeby mieć okazję do użycia DB ;)
        $books_categories = BooksCategories::where('id_book', $request->id_book)->delete();
        foreach ($request->categories as $category) {
            //o wiele bardziej wolę ten sposub zarządzania bazą w laravelu ponieważ kiedy zna się język MySQL jest według mnie po prostu szybciej coś zrobic w bazie
            $b_c = DB::update('update books_categories set deleted_at = NULL where id_book = :id_book and id_category = :id_category', ['id_book' => $request->id_book, 'id_category' => $category["id_category"]]);
        }
        
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\books  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $book = Books::findOrFail($request->id_book)->delete();//usuwam pozycję 
        $books_categories = BooksCategories::where('id_book', $request->id_book)->delete();

        return $request;
    }
}
