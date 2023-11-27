<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryAPIController extends Controller
{
    use HandlerResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderByDesc('id')->get();
        return $this->responseCollection(data: $categories);
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
            'name' => ['required', 'unique:categories'],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }
        $request['created_by'] = auth()->guard('api')->user()->id;
        $category = Category::create($request->all());
        return $this->responseSuccess(data: $category, message: "Category Created Successfully");
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
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($request->category),
            ],
        ]);

        if ($validator->fails()) {
            return $this->responseValidationErrors([$validator->errors()]);
        }

        $category->update($request->all());

        return $this->responseSuccess(data: $category, message: "Author Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $is_exist = BookCategory::where('category_id', $category->id)->first();

        if ($is_exist) {
            return $this->responseUnprocessable(
                status_code: 422,
                message: "Sorry, you cannot delete this record.!",
            );
        } else {
            $category->delete();
            return $this->responseSuccessMessage(message: 'Category Deleted Successfully.', status_code: 201);
        }
    }
}
