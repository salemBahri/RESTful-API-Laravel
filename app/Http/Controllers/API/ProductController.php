<?php

namespace App\Http\Controllers\API;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;


class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();
        return $this->sendResponse(ProductResource::collection($products),
        'All products send');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make($input,[
            'name'=>'required',
            'detail'=>'required',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please Valdate error',$validator->errors());
        }
        $product=Product::create($input);
        return $this->sendResponse(new ProductResource($product), 'Product created succssesfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product=Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found');
        }
        return $this->sendResponse(new ProductResource($product), 'Product found succssesfuly');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $input=$request->all();
        $validator=Validator::make($input,[
            'name'=>'required',
            'detail'=>'required',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please Valdate error',$validator->errors());
        }
        $product->name=$input['name'];
        $product->detail=$input['detail'];
        $product->price=$input['price'];
        $product->save();
        return $this->sendResponse(new ProductResource($product), 'Product updated succssesfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse(new ProductResource($product), 'Product deleted succssesfuly');

    }
}
