<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{


    public function __construct()
    {
        $this->middleware('premission:view-products')->only(['index','show']);
        $this->middleware('permission:create-products')->only(['create','store']);
        $this->middleware('permission:edit-products')->only(['edit','update']);
        $this->middleware('permission:delete-products')->only(['destroy','trash']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::latest()->get();
    }

    /**
     * Server-side DataTables source for the products page.
     */
public function datatable()
{
    return DataTables::of(Product::query())
        ->addIndexColumn()
        ->addColumn('actions', function (Product $row) {
            $html = '';

            if (auth()->user()->can('edit-products')) {
                $editUrl = route('products.edit', $row->id);

                $html .= '<a href="'.$editUrl.'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">Edit</a> ';
            }

            if (auth()->user()->can('delete-products')) {
                $deleteUrl = route('products.destroy', $row->id);

                $html .= '<form action="'.$deleteUrl.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Delete this product?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Delete</button>
                </form>';
            }

            return $html;
        })
        ->rawColumns(['actions'])
        ->make(true);
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
        $product = Product::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]));

        if ($request->expectsJson()) {
            return response()->json($product, 201);
        }

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
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
        ]));

        if ($request->expectsJson()) {
            return $product;
        }

        return redirect()->route('products.index')->with('success','Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Bypass the scope: trashed products must still resolve so they can be purged
        $product = Product::withoutGlobalScope('notTrashed')->findOrFail($id);

        if ($product->status === Product::STATUS_TRASHED) {
            $product->delete();
            return redirect()->route('products.trash')->with('success','Product permanently deleted.');
        }

        $product->status = Product::STATUS_TRASHED;
        $product->save();

        return redirect()->route('products.index')->with('success','Product moved to trash.');
    }

    /**
     * List trashed products.
     */
    public function trash()
    {
        $products = Product::withoutGlobalScope('notTrashed')
            ->where('status', Product::STATUS_TRASHED)
            ->latest()
            ->get();

        return view('products.trash', compact('products'));
    }
}
