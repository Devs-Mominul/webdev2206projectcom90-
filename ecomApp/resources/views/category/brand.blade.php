@extends('layouts.admin')
@section('content')
<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">Add Brand</div>
        @if(session('category_status'))
        <div class="alert alert-info">{{ session('category_status') }}</div>

        @endif
        <div class="card-body">
            <form action="{{ route('add.brand.post') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Brand Name:</label>
                    <input type="text" name="brand_name" id="" class="form-control">
                </div>
                @error('brand_name')
                <span class="text-danger">    {{ $message }}</span>


                @enderror
                <div class="mb-3">
                    <label for="image" class="form-label">Brand Image:</label>
                    <input type="file" name="brand_img" id="" class="form-control">
                </div>
                @error('brand_img')
                <span class="text-danger">    {{ $message }}</span>


                @enderror
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

