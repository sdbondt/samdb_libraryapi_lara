<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanedBookCollection;
use App\Http\Resources\LoanedBookResource;
use App\Models\Book;
use App\Models\Client;
use App\Models\LoanedBook;
use App\Models\ReadBook;


class LoanedBookController extends Controller
{
    public function store(Book $book, Client $client) {
        if($book->available() <1) {
            return [
                'msg' => 'Book is currently not available'
            ];
        } else {
            $loanedBook = LoanedBook::create([
                'book_id' => $book->id,
                'client_id' => $client->id,
                'return_date' => now()->addDays(31),
                'start_date' => now()
            ]);
            return [
                'book' => new LoanedBookResource($loanedBook)
            ];
        }
    }

    public function destroy(LoanedBook $loanedbook) {
        $alreadyRead = ReadBook::where([
            'client_id' => $loanedbook->client_id,
            'book_id' => $loanedbook->book_id
        ])->exists();
        if(! $alreadyRead) {
            ReadBook::create([
                'book_id' => $loanedbook->book_id,
                'client_id' => $loanedbook->client_id
            ]);
        }
        $onTime = $loanedbook->late ? ' too late': ' on time';
        $loanedbook->delete();
        return [
            'msg' => 'Book got returned' . $onTime
        ];
    }

    public function show(LoanedBook $loanedbook) {
        return [
            'loan' => new LoanedBookResource($loanedbook)
        ];
    }

    public function index() {
        $loans = LoanedBook::latest()->filter(request(['q', 'late']))->paginate();
        return [
            'loans' => new LoanedBookCollection($loans)
        ];
    }
}
