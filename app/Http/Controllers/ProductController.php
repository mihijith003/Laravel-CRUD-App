<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = Product::latest()->get();
            return Datatables::of($data)
            ->addIndexToColumn()
            ->addToColumn('action',function($row){
                $editUrl =route('products.edit',$row->id);
                $deleteUrl = route('products.destroy',$row->id);
                return '<a href="'.$editUrl.'" class="btn btn-primary btn-sm">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('products.index');
        //return Product::latest()->get();
    }

    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Product::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]));    

        Product::create($validated);

       // return response()->json($product, 201);
       // Redirect back to the table with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product;
    }


   /*Show the form for editing the specified resource*/
   public function edit(Product $product)
   {
    return view('products.edit',compact('product'));
   }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product -> update($request->validate([
            'name' => 'sometimes|string|max:255',
            'decrription' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
        ]));

        $product->update($validated);

        return redirect()->route('products.index')->with('success','Product updated successfully.');

        //return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) 
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully.');

    }
}
