@extends('admin.layouts.app')
@section('title', __('Edit'))
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Edit User') }}</h3>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="text" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" value="" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="{{ old('email', $user->email) }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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

            autoResize(document.getElementById('lyrics_en'));
            autoResize(document.getElementById('lyrics_gu'));
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set to scroll height
        }
    </script>
@endsection
