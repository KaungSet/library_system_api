<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthorAPIController extends Controller
{
    use HandlerResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderByDesc('id')->get();
        return $this->responseCollection(data: $authors);
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
            'name' => ['required', 'unique:authors'],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }
        $request['created_by'] = auth()->guard('api')->user()->id;
        $author = Author::create($request->all());
        return $this->responseSuccess(data: $author, message: "Author Created Successfully");
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
    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('authors', 'name')->ignore($request->author),
            ],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }
        $author->update($request->all());

        return $this->responseSuccess(data: $author, message: "Author Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $is_exist = Book::where('author_id', $author->id)->first();

        if ($is_exist) {
            return $this->responseUnprocessable(
                status_code: 422,
                message: "Sorry, you cannot delete this record.!",
            );
        } else {
            $author->delete();
            return $this->responseSuccessMessage(message: 'Author Deleted Successfully.', status_code: 201);
        }
    }
}
