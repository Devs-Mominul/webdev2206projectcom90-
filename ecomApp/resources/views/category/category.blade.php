@extends('layouts.admin')
@section('content')
@can('category_access')
<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">Add Category</div>
        @if(session('category_status'))
        <div class="alert alert-info">{{ session('category_status') }}</div>

        @endif
        <div class="card-body">
            <form action="{{ route('add.category.post') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name:</label>
                    <input type="text" name="category_name" id="" class="form-control">
                </div>
                @error('category_name')
                <span class="text-danger">    {{ $message }}</span>


                @enderror
                <div class="mb-3">
                    <label for="image" class="form-label">Category Image:</label>
                    <input type="file" name="category_img" id="" class="form-control">
                </div>
                @error('category_img')
                <span class="text-danger">    {{ $message }}</span>


                @enderror
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<h1 class="danger">You are not access it </h1>

@endcan


@endsection
