<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', ['products'=>Product::latest()->paginate(3)]);
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

    public function edit($id)
    {
        $record = Product::find($id);

        if (!$record) {
            // Handle the case where the record with the given $id is not found
            abort(404, 'Record not found');
        }
        return view('products.edit', compact('record'));
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            // Handle the case where the product with the given $id is not found
            abort(404, 'product not found');
        }
        return view('products.show', compact('product'));
    }

    // public function update(Request $request, $id)
    // {
    //     // validating the inputs
    //     $request->validate([
    //         'name' => 'required|string',
    //         'description' => 'required|string', 
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

    //     ]);

    //     $product = Product::find($id);

    //     if (!$product) {
    //         abort(404, 'Record not found');
    //     }

    //     if(isset($request->image)){
    //         // moving or stroing the image in uploads directory
    //         $imageName = time() . '.' . $request->image->extension();
    //         $request->image->move(public_path('uploads'), $imageName);

    //         $product->image = $imageName;

    //     }

    //     $product->name = $request->name;
    //     $product->description = $request->description;
    //     $product->save();

    //     return redirect(route('products.index'))
    //         ->with('success', 'Product Updated successfully.');
    // }


    // public function destroy($id)
    // {
    //     // Find the product by id
    //     $product = Product::find($id);

    //     // Check if the product exists
    //     if ($product) {
    //         // Delete the product
    //         $product->delete();

    //         return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    //     } else {
    //         return redirect()->route('products.index')->with('error', 'Product not found.');
    //     }
    // }

    

    public function update(Request $request, $id)
    {
        // validating the inputs
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::find($id);

        if (!$product) {
            abort(404, 'Record not found');
        }

        // Check if a new image is provided
        if ($request->hasFile('image')) {
            // Get the old image path
            $oldImagePath = public_path('uploads') . '/' . $product->image;

            // Delete the old image file if it exists
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // Move the new image to the uploads directory
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);

            // Update the product's image field
            $product->image = $imageName;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return redirect(route('products.index'))
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        // Find the product by id
        $product = Product::find($id);

        // Check if the product exists
        if ($product) {
            // Delete the associated image file
            $imagePath = public_path('uploads') . '/' . $product->image;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the product
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
    }

}
