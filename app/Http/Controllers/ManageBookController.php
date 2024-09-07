<?php

namespace App\Http\Controllers;

use App\Models\ManageBook;
use Illuminate\Http\Request;

class ManageBookController extends Controller
{
    public function insertBook(Request $request)
    {
        \Log::info('Request Data: ', $request->all());

        try {
            $request->validate([
                'book_name' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'fiction' => 'required|boolean',
                'publication_date' => 'required|date',
                'copies_available' => 'required|integer|min:0',
                'isbn' => 'required|string|size:13|unique:books,isbn',
            ]);

            \Log::info('Validated Data: ', $request->all());

            $bookDetails = ManageBook::create($request->all());

            \Log::info('Book Created: ', $bookDetails->toArray());

            return response()->json([
                'message' => 'New book inserted successfully',
                'book' => $bookDetails
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Insertion Error: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to insert book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateBook(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|integer|exists:books,book_id',
                'book_name' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'fiction' => 'required|boolean',
                'publication_date' => 'required|date',
                'copies_available' => 'required|integer|min:0',
                'isbn' => 'required|string|size:13|unique:books,isbn,' . $request->book_id . ',book_id',

            ]);

            $book = ManageBook::findOrFail($request->book_id);

            $book->update($request->all());

            return response()->json([
                'message' => 'Book updated successfully',
                'book' => $book
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Update Error: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to update book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteBook(Request $request)
    {
        try {

            $request->validate([
                'book_id' => 'required|integer|exists:books,book_id',

            ]);
            $book = ManageBook::findOrFail($request->book_id);
            $book->delete();

            return response()->json([
                'message' => 'Book deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBooks()
    {
        $books = ManageBook::all();

        return response()->json($books);
    }
}
