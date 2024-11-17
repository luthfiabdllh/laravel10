<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BookController extends Controller
{

    public function __construct()
    {
    $this->middleware('auth')->only('index');
    $this->middleware('admin')->only('create', 'store', 'edit', 'update', 'destroy');
    }

    // table pages
    public function index()
    {
        $jumlahBuku = Book::count();
        $totalPrice = Book::sum('price');
        $data_book = Book::all();
        return view('book.index', compact('data_book', 'jumlahBuku', 'totalPrice'));
    }

    // to create book view
    public function create()
    {
        return view('book.create');
    }

    // create book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'creator' => 'required|string|max:30',
            'price' => 'required|numeric',
            'publication_date' => 'required|date',
            'photo' => 'image|nullable|max:1999',
        ]);

         // Default nilai untuk nama file jika tidak ada gambar
        $filenameOriginal = null;
        $filenameResized = null;

        if($request->hasFile('photo')){
            $manager = new ImageManager(new Driver());

            // Ambil file gambar
            $file = $request->file('photo');
            $filenameWithExt = $file->getClientOriginalName();

            $image = $manager->read($file);

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // Simpan original image
            $filenameOriginal = $filename . '_original_' . time() . '.' . $extension;
            $file->storeAs('public/photos', $filenameOriginal); // Simpan file original

            // Buat dan simpan resized image
            $filenameResized = $filename . '_resized_' . time() . '.' . $extension;
            $resizedImage = $manager->read($file);
            $resizedImage = $resizedImage->resize(300,300);// Resize sesuai kebutuhan
            $resizedImage->save(storage_path('app/public/photos/' . $filenameResized)); // Simpan file resized
        }

        $book = new Book();
        $book->title = $request->title;
        $book->author_id = Auth::user()->id ;
        $book->price = $request->price;
        $book->publication_date = $request->publication_date;
        $book->photo = $filenameOriginal; // Gambar original
        $book->photoTable = $filenameResized; // Gambar resized
        $book->save();

        return redirect('/book')->with('created', 'Data buku berhasil dibuat');
    }

    // delete book
    public function destroy($id){
        $book = Book::find($id);
        $book->delete();

        return redirect('/book')->with('deleted', 'Data buku berhasil dihapus');
    }
    // to edit book view
    public function edit($id){
        $book = Book::find($id);
        return view('buku.edit', compact('book'));
    }
    // update book
    public function update(Request $request, $id){
        $book = Book::find($id);

        $request->validate([
            'title' => 'required|string',
            'creator' => 'required|string|max:30',
            'price' => 'required|numeric',
            'publication_date' => 'required|date'
        ]);

        $book->title = $request->title;
        $book->creator = $request->creator;
        $book->price = $request->price;
        $book->publication_date = $request->publication_date;
        $book->save();

        return redirect('/book')->with('updated', 'Data buku berhasil diperbarui');
    }

    // public function show($id){
    //     $book = Book::find($id);
    //     return Storage
    // }
}
