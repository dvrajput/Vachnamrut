@extends('admin.layouts.app')
@section('title', 'Create Config')
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Add New Config') }}</h3>
    <form action="{{ route('admin.config.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="key">{{ __('Key') }}</label>
                    <input type="text" class="form-control" id="key" name="key"
                        placeholder="{{ __('Enter Key') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="value">{{ __('Value') }}</label>
                    <input type="text" class="form-control" id="value" name="value"
                        placeholder="{{ __('Enter Value') }}" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="message">{{ __('Message') }}</label>
                    <input type="text" class="form-control" id="message" name="message"
                        placeholder="{{ __('Enter Message') }}" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a href="{{ route('admin.config.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection
