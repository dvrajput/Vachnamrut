@extends('admin.layouts.app')

@section('title', 'Admin Home')

@section('style')
    <style>
        .export-container {
            margin-top: 20px;
        }

        .export-button {
            padding: 0.5em 1em;
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ __('Export Data') }}</h3>
        </div>

        <!-- Export Form -->
        <div class="export-container">
            <form action="{{ route('admin.exports') }}" method="GET">
                @csrf
                <div class="row">
                    <!-- Subcategory Select (Multiple Selection) -->
                    <div class="col-md-3">
                        <label for="subcategories">{{ __('Select Subcategories') }}</label>
                        <select class="form-control select2" id="subcategories" name="subcategories[]" multiple="multiple"
                            data-placeholder="{{ __('Select Sub Categories') }}">
                            @foreach ($subCategories as $subcategory)
                                <option value="{{ $subcategory->sub_category_code }}">
                                    {{ $subcategory->sub_category_en }} ({{ $subcategory->sub_category_gu }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="playlists">{{ __('Select Playlists') }}</label>
                        <select class="form-control select2" id="playlists" name="playlists[]" multiple="multiple"
                            data-placeholder="{{ __('Select Sub Categories') }}">
                            @foreach ($playlists as $play)
                                <option value="{{ $play->playlist_code }}">
                                    {{ $play->playlist_en }} ({{ $play->playlist_gu }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Export Button -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary export-button">
                            <i class="fas fa-file-export"></i> {{ __('Export Data') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('Select Sub Categories') }}',
                allowClear: true
            });
        });
    </script>
@endsection
