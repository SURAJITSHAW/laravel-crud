@extends('layouts.base')

@section('main')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 mt-4">
                <div class="card p-4 ">
                    <p><b>Name:</b> {{$product->name}}</p>
                    <p><b>Description:</b> {{$product->description}}</p>
                    <p>
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="" class="rounded" height="500px" width="500px">
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection