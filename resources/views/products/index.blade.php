@extends('layouts.base')

@section('main')
    <div class="container">
        <div class="text-end">
            <a class="btn btn-dark mt-2" href="{{ route('products.create') }}">New Product</a>
        </div>
        {{-- @foreach ($products as $product)
            <img src="{{ asset('uploads/' . $product->image) }}" alt="Image">
        @endforeach --}}
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>Sno.</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <a style="text-decoration: none" class="text-dark" href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                        </td>
                        <td>
                            <img src="{{ asset('uploads/' . $product->image) }}" alt="" width="60px" height="60px"
                                class="rounded-circle">
                        </td>
                        <td>
                            <a href="product/{{ $product->id }}/edit" class="btn btn-sm btn-dark ">Edit</a>
                            <a href="product/{{ $product->id }}/delete" class="btn btn-sm btn-danger  ">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}


    </div>
@endsection
