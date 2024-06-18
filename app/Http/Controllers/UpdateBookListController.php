<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UpdateBookListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchInput = $request->input('search');
        $book = new Book();
        $results = $book->search($searchInput);
        return response()->json($results);
/*
 *
        $books = Book::all()->where(function ($subquery) use ($columns, $searchInput){
            foreach ($columns as $column){
                $subquery = $subquery->orWhere($column, 'LIKE', "%{$searchInput}");
            }
            return $subquery;
        })->select($columns)->get();

        $resultsArray = array();

        foreach($columns as $column)
        {
            $results = $query->where($column, '=', $searchInput);
        }
        dd($results);
        return response()->json($resultsArray);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $xlsxFile  = $request->file('books');
            //Delete all existing books from the DB and update the new updated list
            DB::table('books')->select(['*'])->delete();
            //Import the updated list
            Excel::import(new BooksImport(), $xlsxFile);
        } catch (\Exception $e){
            return response()->json(['message' => nl2br("Ha ocurrido un error al intentar actualizar la base de libros. " . " Mensaje de error: " . $e->getMessage())],400);
        }

        Storage::delete($xlsxFile);
        return response()->json(['message' => "Base de libros actualizada correctamente"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $updateBookList
     * @return \Illuminate\Http\Response
     */
    public function show(Book $updateBookList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $updateBookList
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $updateBookList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $updateBookList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $updateBookList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $updateBookList
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $updateBookList)
    {
        //
    }
}
