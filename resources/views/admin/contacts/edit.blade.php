@extends('admin.layouts.app')
@section('title', 'Admin - ' . __('Contact'))
@section('content')
    <h3 class="mt-4 mb-4">{{ __('Edit Contact') }}</h3>
    <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control id="name" name="name" placeholder="{{ __('Name') }}"
                value="{{ old('title_en', $contact->name) }}" required readonly>
        </div>
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="text" class="form-control id="email" name="email" placeholder="{{ __('Email') }}"
                value="{{ old('title_en', $contact->email) }}" required readonly>
        </div>
        <div class="form-group">
            <label for="song_code">{{ __('Song') }}</label>
            <input type="text" class="form-control id="song_code" name="song_code" placeholder="{{ __('No Song') }}"
                value="@if($songs!=null){{ $songs->song_code . ($songs->title_en) }}@endif" required readonly>
        </div>
        <div class="form-group">
            <label for="message">{{ __('Message') }}</label>
            <textarea class="form-control" id="message" name="message" rows="1" placeholder="{{ __('Enter Message') }}"
                required readonly>{{ old('title_en', $contact->message) }}</textarea>
        </div>
        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-control select2" id="status" name="status">
                <option value="">Select Status</option>
                <option value="0" {{ $contact->status == 0 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $contact->status == 1 ? 'selected' : '' }}>Approve</option>
                <option value="2" {{ $contact->status == 2 ? 'selected' : '' }}>Reject</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary ml-2">{{ __('Cancel') }}</a>
    </form>
@endsection
