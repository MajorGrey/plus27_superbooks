<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard()
    {
        //return the dashboard view
        return view('dashboard.index');
    }

    public function allBooks(Request $request)
    {
        //check if the request has a query string in the url and ready to prepare the search
        if($request->has('q')){
            //performs the search query by looping through the colums of rows of the books table and return 3 records to the books collection 
            $books = Books::where(function ($q) use ($request) {
                                if (strlen($request->q) >= 2) {
                                    $data = ['title', 'author', 'editor', 'publisher', 'place_of_publication', 'copyright_date', 'edition', 'category', 'language'];
                                    foreach ($data as $field)
                                        $q->orWhere($field, 'like', "%{$request->q}%");
                                }
                            })
                            ->paginate(3);
            
            //return the view with the books collection
            return view('dashboard.allBooks', ['books' => $books]);
        }
        //loads all books records into a pagination classs with a limit of 3 records per request
        $books = Books::paginate(3);

        //return the view with the books collection
        return view('dashboard.allBooks', ['books' => $books]);
    }

    public function allArchiveBooks(Request $request)
    {
        //check if the request has a query string in the url and ready to prepare the search
        if($request->has('q')){
            //performs the search query by looping through the colums of rows of the books table and return 3 records to the books collection 
            $books = Books::onlyTrashed()
                            ->where(function ($q) use ($request) {
                                if (strlen($request->q) >= 2) {
                                    $data = ['title', 'author', 'editor', 'publisher', 'place_of_publication', 'copyright_date', 'edition', 'category', 'language'];
                                    foreach ($data as $field)
                                        $q->orWhere($field, 'like', "%{$request->q}%");
                                }
                            })
                            ->paginate(3);
            
            //return the view with the books collection
            return view('dashboard.allBooks', ['books' => $books]);
        }
        //loads all books records into a pagination classs with a limit of 3 records per request
        $books = Books::onlyTrashed()->paginate(3);

        //return the view with the books collection
        return view('dashboard.archiveBooks', ['books' => $books]);
    }

    public function createBook()
    {
        //return the view
        return view('dashboard.createBook');
    }

    //validate the post request and insert necessary fields into the database
    public function saveBook(Request $request){

        //validate the request
        $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        //make an instance of the books model and add the request data to the databse
        $book = new Books();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->editor = $request->editor;
        $book->publisher = $request->publisher;
        $book->place_of_publication = $request->place_of_publication;
        $book->copyright_date = $request->copyright_date;
        $book->edition = $request->edition;
        $book->category = $request->category;
        $book->language = $request->language;
        $book->save();

        //redirect after saving data to the databse
        return redirect()->back()->with('status', 'Book saved successfully');
    }

    public function saveUpdateBook(Request $request, $id)
    {

        //validate the request to be updated
        $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
        
        //updating the validate request to the database
        $book = Books::find($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->editor = $request->editor;
        $book->publisher = $request->publisher;
        $book->place_of_publication = $request->place_of_publication;
        $book->copyright_date = $request->copyright_date;
        $book->edition = $request->edition;
        $book->category = $request->category;
        $book->language = $request->language;
        $book->save();

        //redirect back after updating with a message
        return redirect()->back()->with('status', 'Book updated successfully');
    }

    //get book details with book id 
    public function getBookDetails($id)
    {
        //find a book with it id and save it to a variable
        $book = Books::find($id);

        //return the book collectection
        return $book;

   }

   //get archieved book details with it id
   public function getArchiveBookDetails($id)
    {
        //find an archived book with it id and save it to a variable
        $book = Books::onlyTrashed()->whereId($id)->first();

        //return the book collectection
        return $book;

   }

   //get the book collection and send it to the view form for edithing
   public function updateBook($id)
   {

    //find a book with it id and save it to a variable
       $book = Books::find($id);

       //return view with the book collectection
       return view('dashboard.updateBook', ['book' => $book]);
   }

   //achieve a book 
   public function archiveBook($id)
   {
       Books::whereId($id)->delete();
       return redirect()->back()->with('status', 'Book Archive Successfully');
   }

   //restore an archieved book
   public function restoreBook($id)
   {
       Books::onlyTrashed()->whereId($id)->restore();

          //return redirect with message
       return redirect()->back()->with('status', 'Book Restored Successfully');
   }

   //delete a book colllection
   public function deleteBook($id)
   {
        //force delete a model instance
       Books::whereId($id)->forceDelete();

       //return redirect with message
       return redirect()->back()->with('status', 'Book Deleted Successfully');
   }
   
}