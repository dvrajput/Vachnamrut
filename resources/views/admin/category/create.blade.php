@extends('admin.layouts.app')
@section('title', 'Create Song')
@section('content')
    <h1 class="mt-4 mb-4">Add New Category</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category_en">Title (English)</label>
            <input type="text" class="form-control id="category_en" name="category_en" placeholder="Enter English Title"
                required>
        </div>

        <div class="form-group">
            <label for="category_gu">Title (Gujarati)</label>
            <input type="text" class="form-control" id="category_gu" name="category_gu" placeholder="Enter English Title"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
@endsection
