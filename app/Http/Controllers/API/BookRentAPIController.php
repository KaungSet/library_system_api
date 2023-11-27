<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookRentAPIController extends Controller
{
    use HandlerResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'user_id' => ['required'],
            'books' => ['required'],
            'checkout_date' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }

        $request['created_by'] = auth()->guard('api')->user()->id;
        $rent = Rent::create($request->all());
        $books = json_decode($request->books);
        $user_books = $rent->books()->sync($books);

        foreach ($books as $book) {
            $book = Book::find($book);
            $book->decrement('quantity', 1);
            $book->save();
        }
        return $this->responseSuccess(data: $rent, message: "Rent Created Successfully");
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
