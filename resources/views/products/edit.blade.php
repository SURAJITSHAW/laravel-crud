@extends('layouts.base')

@section('main')

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-sm-8">
                <div class="card mt-3 p-3 ">
                    <h3>Produc edit # {{ $record->name }}</h3>
                    <form action="{{ route('products.update', $record->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder=""
                                aria-describedby="helpId" autocomplete="off" value="{{ old('name', $record->name) }}">
                            @error('name')
                                <small id="helpId" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="" rows="3">{{ old('description', $record->description) }}</textarea>
                            @error('description')
                                <small id="helpId" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control" placeholder=""
                                aria-describedby="helpId" autocomplete="off" accept="image/jpeg, image/png, image/gif">
                            @error('image')
                                <small id="helpId" class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button class="btn btn-dark" type="submit">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
