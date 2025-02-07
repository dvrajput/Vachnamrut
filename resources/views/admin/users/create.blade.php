@extends('admin.layouts.app')
@section('title', 'Create User')
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New User') }}</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="{{ __('Enter English Title') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="text" class="form-control" id="password" name="password"
                        placeholder="{{ __('Enter English Title') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="text" class="form-control" id="email" name="email"
                        placeholder="{{ __('Enter Gujarati Title') }}" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('Select Sub Categories') }}',
                allowClear: true
            });
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set to scroll height
        }
    </script>
@endsection
