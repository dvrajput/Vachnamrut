@extends('admin.layouts.app')
@section('title', __('Edit') . ' - ' . $config->{'title_' . app()->getLocale()})
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Edit Config') }}</h3>
    <form action="{{ route('admin.config.update', $config->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="key">{{ __('Key') }}</label>
                    <input type="text" class="form-control" id="key" name="key"
                        value="{{ old('key', $config->key) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="value">{{ __('Value') }}</label>
                    <input type="text" class="form-control" id="value" name="value"
                        value="{{ old('value', $config->value) }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="message">{{ __('Message') }}</label>
                    <input type="text" class="form-control" id="message" name="message"
                        value="{{ old('message', $config->message) }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.config.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection
