@extends('user.layouts.app')
@section('title', __('Create Category'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow">
                <!-- <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Contact Us') }}</h3>
                </div> -->
                <div class="card-body">
                    <form action="{{ route('user.contact.store') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <i class="fa-regular fa-user input-group-text uf-ct-03-input-group-text lh-lg"></i>
                            <input type="text" class="form-control" id="name" name="name" 
                                placeholder="{{ __('Name') }}" autofocus required>
                        </div>

                        <div class="input-group mb-3">
                            <i class="fa-regular fa-envelope input-group-text uf-ct-03-input-group-text lh-lg"></i>
                            <input type="email" class="form-control" id="email" name="email" 
                                placeholder="{{ __('Email') }}" required>
                        </div>
                        
                        <div class="mb-3 kirtan-select">
                            <!-- <label for="song_code" class="form-label">{{ __('Kirtan') }}</label> -->
                            <select class="form-control select2" id="song_code" name="song_code"
                                data-placeholder="{{ __('Select Kirtan (optional)') }}">
                                <!-- Songs will be loaded via AJAX -->
                            </select>
                            @error('song_code')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <!-- <label for="message" class="form-label">{{ __('Message/Suggestion') }}</label> -->
                            <textarea class="form-control" id="message" name="message" rows="3" 
                                placeholder="{{ __('Message/Suggestion') }}" required 
                                oninput="autoResize(this)"></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-lg uf-ct-03-btn-primary text-uppercase w-100">
                            {{ __('Send') }} <i class="fa-regular fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .card {
        border-radius: 10px;
        border: none;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(215, 134, 27, 0.25);
        border-color: #d7861b;
    }
    .uf-contact-form-03 {
        background-color: #f8f9fa;
    }
    
    .uf-cf-03-main {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .input-group:focus-within {
    box-shadow: 0 0 0 0.2rem rgba(215, 134, 27, 0.25);
    border-radius: 0.375rem;
}

.input-group:focus-within .form-control {
    border-color: var(--primary-color) !important;
    box-shadow: none;
}

.input-group:focus-within .uf-ct-03-input-group-text {
    border-color: var(--primary-color) !important;
    color: var(--primary-color);
}

/* Remove individual input focus styles when in group */
.input-group .form-control:focus {
    box-shadow: none;
}

/* Keep existing input group styles */
.uf-ct-03-input-group-text {
    background-color: transparent;
    border-right: none;
    color: var(--primary-color);
    border-color: var(--border-color);
    transition: all 0.2s ease;
}
    
    .form-control {
        border-left: none;
        padding: 0.75rem 1rem;
        color: var(--text-color) !important;
        background-color: var(--card-bg) !important;
        border-color: var(--border-color) !important;
    }

    .form-control::placeholder {
        color: var(--text-color);
        opacity: 0.6;
    }

    /* Input Group Text */
    .uf-ct-03-input-group-text {
        background-color: transparent;
        border-right: none;
        color: var(--primary-color);
        border-color: var(--border-color) !important;
    }

    /* Select2 Theme Support */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 0.375rem !important;
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px !important;
        padding-left: 12px;
        color: var(--text-color) !important;
    }

    .select2-dropdown {
        background-color: var(--card-bg) !important;
        border-color: var(--border-color) !important;
    }

    .select2-search__field {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        border-color: var(--border-color) !important;
    }

    .select2-results__option {
        color: var(--text-color) !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary-color) !important;
        color: #ffffff !important;
    }

    /* Textarea specific styles */
    textarea.form-control {
        border: 1px solid var(--border-color) !important;
        color: var(--text-color) !important;
        background-color: var(--card-bg) !important;
    }

    /* Focus States */
    .form-control:focus,
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 0.2rem rgba(215, 134, 27, 0.25);
    }

    /* Button Styles */
    .uf-ct-03-btn-primary {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 25px;
        transition: all 0.3s ease;
    }

    .uf-ct-03-btn-primary:hover {
        background-color: #c27616;
        transform: translateY(-2px);
    }

    /* Dark theme specific overrides */
    [data-theme="dark"] .select2-container--default .select2-selection--single {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
    }

    [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text-color) !important;
    }

    [data-theme="dark"] .select2-results__option {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
    }

    [data-theme="dark"] .select2-search__field {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
    }

    [data-theme="dark"] .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary-color) !important;
        color: #ffffff !important;
    }
</style>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            // Initialize select2 with AJAX support
            $('#song_code').select2({
                placeholder: 'Select Songs',
                allowClear: true,
                ajax: {
                    url: '{{ route('user.contact.create') }}', // The route for fetching songs
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds between typing and sending the request
                    data: function(params) {
                        return {
                            q: params.term // Send the search term as query parameter
                        };
                    },
                    processResults: function(data) {
                        // console.log(data);

                        return {
                            results: data.map(function(song) {
                                return {
                                    id: song.song_code,
                                    text: song.title_en + '(' + song.song_code + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set to scroll height
        }
    </script>
    <script>
  document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    });
    </script>
@endsection
