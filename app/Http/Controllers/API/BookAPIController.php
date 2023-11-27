<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookAPIController extends Controller
{
    use HandlerResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderByDesc('id')->get();
        return $this->responseCollection(data: $books);
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
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'unique:books'],
            'isbn' => ['required', 'unique:books'],
            'author_id' => ['required'],
            'published_date' => ['required'],
            'categories' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }
        $request['created_by'] = auth()->guard('api')->user()->id;
        $book = Book::create($request->all());
        $book->categories()->sync(json_decode($request->categories));
        return $this->responseSuccess(data: $book, message: "Book Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                Rule::unique('books', 'title')->ignore($request->book),
            ],
            'isbn' => [
                'required',
                Rule::unique('books', 'isbn')->ignore($request->book),
            ],
            'author_id' => ['required'],
            'published_date' => ['required'],
            'categories' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }

        $book->update($request->all());
        $book->categories()->sync(json_decode($request->categories));
        return $this->responseSuccess(data: $book, message: "Book Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $is_exist = BookCategory::where('book_id', $book->id)->first();

        if ($is_exist) {
            return $this->responseUnprocessable(
                status_code: 422,
                message: "Sorry, you cannot delete this record.!",
            );
        } else {
            $book->delete();
            return $this->responseSuccessMessage(message: 'Book Deleted Successfully.', status_code: 201);
        }
    }
}
