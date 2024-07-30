@extends('layouts.admin')
@section('content')
<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">Add Subcategory</div>
        @if(session('category_status'))
        <div class="alert alert-info">{{ session('category_status') }}</div>

        @endif
        <div class="card-body">
            <form action="{{ route('add.subcategory.post') }}" method="post" >
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Subcategory Name:</label>
                    <input type="text" name="subcategory_name" id="" class="form-control">
                </div>
                @error('subcategory_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="mb-3">
                    <label for="image" class="form-label">Category :</label>
                    <select name="category_id" id="" class="form-control">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>

                        @endforeach

                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                @error('category_img')
                <span class="text-danger">    {{ $message }}</span>


                @enderror
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Subcategory</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
