<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {

        /**
         * Asignacion Masiva validada por FormRequest 
         * y protegida por el modelo
         */
        try {
            $product = Product::create($request->all());
            return response()->json($product->toArray(), 200);
        } catch (\Exception $e) {
            // return response()->json($e->getMessage(), 500);
            return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required|int',
            'name' => 'required|max:25|min:3|unique:products,name,'. $request->id,
            'description' => 'required|max:25|min:3',
            'sku' => 'alpha_dash|required|max:25|min:3|unique:products,sku,'. $request->id,
            'price' => 'numeric',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }
        try {
            $client = Product::findOrFail($request->id);
            $client->name = trim( $request->name);
            $client->sku = trim($request->sku);
            $client->description = trim($request->description);
            $client->active = $request->active;
            $client->price = $request->price;
            $client->updated_at = now();
            $client->save();

            return  response()->json($client->toArray(), 200);


        } catch (\Exception $e) {
            // return response()->json($e->getMessage(), 500);
            return response()->json(['res' => false, 'msg' => 'Internal Error!'], 500);
        }
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
