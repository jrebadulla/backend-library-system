<?php

namespace App\Http\Controllers;

use App\Models\ManageBook;
use Illuminate\Http\Request;
use App\Models\BorrowedBook;


class BorrowedBookController extends Controller
{
    public function borrowBook(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|integer|exists:books,book_id',
                'user_id' => 'required|integer|exists:users,user_id',
                'due_date' => 'required|date',
            ]);

            $book = ManageBook::where('book_id', $request->book_id)->firstOrFail();
            if ($book->copies_available <= 0) {
                return response()->json(['message' => 'Book not available'], 400);
            }

            $existingBorrow = BorrowedBook::where('book_id', $request->book_id)
                ->where('user_id', $request->user_id)
                ->first();

            if ($existingBorrow) {
                return response()->json(['message' => 'You have already borrowed this book.'], 400);
            }


            $borrowedBook = BorrowedBook::create([
                'book_id' => $request->book_id,
                'user_id' => $request->user_id,
                'borrowed_at' => now(),
                'due_date' => $request->due_date,
                'status' => 1,
            ]);


            $book->decrement('copies_available');

            return response()->json(['message' => 'Book borrowed successfully', 'borrowed_book' => $borrowedBook], 201);

        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return response()->json(['message' => 'You have already borrowed this book.'], 400);
            }

            return response()->json(['message' => 'Failed to borrow book', 'error' => $e->getMessage()], 500);
        }
    }
    public function getUserBorrowedBooks(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $borrowedBooks = BorrowedBook::where('user_id', $userId)
                ->join('books', 'borrowed_books.book_id', '=', 'books.book_id')
                ->select('borrowed_books.book_id', 'books.book_name', 'books.author', 'books.genre', 'books.isbn', 'books.publication_date', 'borrowed_books.status', 'books.copies_available')
                ->get();

            return response()->json([
                'borrowed_books' => $borrowedBooks
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch borrowed books',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelBorrowedRequest(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $bookId = $request->input('book_id');

            $borrowedBook = BorrowedBook::where('user_id', $userId)
                ->where('book_id', $bookId)
                ->first();

            if (!$borrowedBook) {
                return response()->json([
                    'message' => 'Borrowed book not found'
                ], 404);
            }

            $borrowedBook->delete();

            return response()->json([
                'message' => 'Borrowed book request has been canceled'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to cancel borrowed book request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}


