<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', ['products'=>Product::all()]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // validating the inputs
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        // moving or stroing the image in uploads directory
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        // store in DB
        $product = new Product();
        $product->image = $imageName;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return back()
            ->with('success', 'Product created successfully.');
    }

    public function update(Request $request, $id)
    {
        // validating the inputs
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        $product = Product::find($id);

        if (!$product) {
            abort(404, 'Record not found');
        }

        if(isset($request->image)){
            // moving or stroing the image in uploads directory
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
    
            $product->image = $imageName;

        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return redirect(route('products.index'))
            ->with('success', 'Product Updated successfully.');
    }

    public function edit($id)
    {
        $record = Product::find($id);

        if (!$record) {
            // Handle the case where the record with the given $id is not found
            abort(404, 'Record not found');
        }
        return view('products.edit', compact('record'));
    }
}
