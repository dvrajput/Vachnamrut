@extends('admin.layouts.app')
@section('title', __('Edit Vachanamrut') . ' - ' . $song->{'title_' . app()->getLocale()})

@section('content')
    <div class="vachanamrut-admin-container">
        <!-- FIXED: Page Header (renamed from admin-header) -->
        <div class="page-header">
            <div class="header-content">
                <h2 class="page-title">
                    <i class="fas fa-edit"></i>
                    {{ __('Edit Vachanamrut') }}
                </h2>
                <p class="page-subtitle">{{ __('Update Vachanamrut entry') }}</p>
                <div class="edit-badge">
                    <i class="fas fa-info-circle"></i>
                    {{ __('Editing Code') }}: {{ $song->song_code }}
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="form-container">
            <form action="{{ route('admin.songs.update', $song->song_code) }}" method="POST" class="vachanamrut-form">
                @csrf
                @method('PUT')

                <!-- Vachanamrut Code Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-code"></i> {{ __('Vachanamrut Code') }}</h4>
                    </div>
                    <div class="form-group">
                        <label for="song_code" class="form-label">{{ __('Code') }}</label>
                        <input type="text" class="form-control readonly-input @error('song_code') is-invalid @enderror"
                            id="song_code" name="song_code" value="{{ old('song_code', $song->song_code) }}" readonly>
                        @error('song_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-lock"></i>
                            {{ __('Code cannot be changed during editing') }}
                        </small>
                    </div>
                </div>

                <!-- Written Date Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-calendar-alt"></i> {{ __('Written Date') }}</h4>
                    </div>
                    <div class="form-group">
                        <label for="written_date" class="form-label">{{ __('Date Written') }}</label>
                        <input type="text" class="form-control @error('written_date') is-invalid @enderror"
                            id="written_date" name="written_date" placeholder="e.g., 17/09/1825, Saturday"
                            value="{{ old('written_date', $song->written_date) }}">
                        @error('written_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small
                            class="form-text text-muted">{{ __('Enter date in format: DD/MM/YYYY, Day (e.g., 17/09/1825, Saturday)') }}</small>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-language"></i> {{ __('Content') }}</h4>
                    </div>

                    <div class="language-tabs">
                        <div class="tab-buttons">
                            <!-- FIXED: GUJARATI IS NOW DEFAULT -->
                            <button type="button" class="tab-btn active" data-tab="gujarati">
                                <i class="fas fa-font"></i> {{ __('ગુજરાતી') }}
                            </button>
                            <button type="button" class="tab-btn" data-tab="english">
                                <i class="fas fa-globe"></i> {{ __('English') }}
                            </button>
                        </div>

                        <!-- Gujarati Tab - NOW DEFAULT ACTIVE -->
                        <div class="tab-content active" id="gujarati-tab">
                            <div class="form-group">
                                <label for="title_gu" class="form-label required">{{ __('Gujarati Title') }}</label>
                                <input type="text"
                                    class="form-control gujarati-text @error('title_gu') is-invalid @enderror"
                                    id="title_gu" name="title_gu" value="{{ old('title_gu', $song->title_gu) }}"
                                    placeholder="{{ __('વચનામૃતનું શીર્ષક લખો') }}" required>
                                @error('title_gu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="lyrics_gu" class="form-label required">{{ __('Gujarati Content') }}</label>
                                <textarea class="form-control gujarati-text summernote-editor @error('lyrics_gu') is-invalid @enderror" id="lyrics_gu"
                                    name="lyrics_gu" placeholder="{{ __('વચનામૃતનું મૂળ લખાણ લખો...') }}" required>{{ old('lyrics_gu', $song->lyrics_gu) }}</textarea>
                                @error('lyrics_gu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    {{ __('Use the rich text editor to format your content') }}
                                </small>
                            </div>
                        </div>

                        <!-- English Tab -->
                        <div class="tab-content" id="english-tab">
                            <div class="form-group">
                                <label for="title_en" class="form-label">{{ __('English Title') }}</label>
                                <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                                    id="title_en" name="title_en" value="{{ old('title_en', $song->title_en) }}"
                                    placeholder="{{ __('English title (optional)') }}">
                                @error('title_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="lyrics_en" class="form-label">{{ __('English Content') }}</label>
                                <textarea class="form-control summernote-editor @error('lyrics_en') is-invalid @enderror" id="lyrics_en"
                                    name="lyrics_en" placeholder="{{ __('English translation (optional)') }}">{{ old('lyrics_en', $song->lyrics_en) }}</textarea>
                                @error('lyrics_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Categories Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-tags"></i> {{ __('Categories') }}</h4>
                    </div>
                    <div class="form-group">
                        <label for="sub_category_code" class="form-label">{{ __('Sub Categories') }}</label>
                        <select class="form-control select2" id="sub_category_code" name="sub_category_code[]"
                            multiple="multiple" data-placeholder="{{ __('Select categories') }}">
                            @foreach ($allSubCategories as $category)
                                <option value="{{ $category->sub_category_code }}"
                                    {{ $subCategories->contains('sub_category_code', $category->sub_category_code) ? 'selected' : '' }}>
                                    {{ $category->sub_category_en }} ({{ $category->sub_category_gu }})
                                </option>
                            @endforeach
                        </select>
                        @error('sub_category_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ __('Update Vachanamrut') }}
                    </button>
                    <a href="{{ route('admin.songs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('Back to List') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('style')
    <style>
        /* Summernote Editor Styles */
        .note-editor {
            border: 2px solid var(--admin-border-color) !important;
            border-radius: 6px !important;
            background-color: var(--admin-bg-secondary) !important;
        }

        .note-editor.note-frame {
            border: 2px solid var(--admin-border-color) !important;
        }

        .note-editor.note-frame.codeview .note-editing-area .note-codable {
            background-color: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border: none !important;
        }

        .note-toolbar {
            background-color: var(--admin-bg-tertiary) !important;
            border-bottom: 1px solid var(--admin-border-color) !important;
            border-radius: 6px 6px 0 0 !important;
        }

        .note-editing-area {
            background-color: var(--admin-bg-secondary) !important;
            min-height: 300px !important;
        }

        .note-editable {
            background-color: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            min-height: 300px !important;
            padding: 15px !important;
            line-height: 1.6 !important;
        }

        /* Text Alignment Styles */
        .note-editable .text-left,
        .note-editable [style*="text-align: left"] {
            text-align: left !important;
        }

        .note-editable .text-center,
        .note-editable [style*="text-align: center"] {
            text-align: center !important;
        }

        .note-editable .text-right,
        .note-editable [style*="text-align: right"] {
            text-align: right !important;
        }

        .note-editable .text-justify,
        .note-editable [style*="text-align: justify"] {
            text-align: justify !important;
        }

        /* Additional HTML element styles */
        .note-editable blockquote {
            padding: 10px 20px;
            margin: 0 0 20px;
            font-size: 1.1em;
            border-left: 5px solid var(--admin-primary);
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
            font-style: italic;
        }

        .note-editable pre {
            background-color: var(--admin-bg-tertiary);
            border: 1px solid var(--admin-border-color);
            border-radius: 4px;
            padding: 15px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            color: var(--admin-text-primary);
            white-space: pre-wrap;
        }

        .note-editable code {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-primary);
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .note-editable strong,
        .note-editable b {
            font-weight: bold;
            color: var(--admin-text-primary);
        }

        .note-editable em,
        .note-editable i {
            font-style: italic;
            color: var(--admin-text-primary);
        }

        .note-editable u {
            text-decoration: underline;
            color: var(--admin-text-primary);
        }

        .note-editable s,
        .note-editable strike,
        .note-editable del {
            text-decoration: line-through;
            color: var(--admin-text-muted);
        }

        .note-editable sup {
            vertical-align: super;
            font-size: smaller;
        }

        .note-editable sub {
            vertical-align: sub;
            font-size: smaller;
        }

        .note-editable p {
            margin: 0 0 10px 0;
            line-height: 1.6;
            color: var(--admin-text-primary);
        }

        .note-editable h1,
        .note-editable h2,
        .note-editable h3,
        .note-editable h4,
        .note-editable h5,
        .note-editable h6 {
            color: var(--admin-text-primary);
            margin: 15px 0 10px 0;
            font-weight: bold;
        }

        /* Gujarati font for Gujarati editor */
        .gujarati-editor .note-editable {
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif !important;
            direction: ltr !important;
        }

        /* Dark mode specific styles */
        [data-theme="dark"] .note-toolbar .btn {
            color: var(--admin-text-primary) !important;
            background-color: transparent !important;
            border: 1px solid transparent !important;
        }

        [data-theme="dark"] .note-toolbar .btn:hover {
            background-color: var(--admin-border-light) !important;
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .note-toolbar .btn.active {
            background-color: var(--admin-primary) !important;
            color: white !important;
        }

        [data-theme="dark"] .note-dropdown-menu {
            background-color: var(--admin-bg-secondary) !important;
            border: 1px solid var(--admin-border-color) !important;
        }

        [data-theme="dark"] .note-dropdown-menu .dropdown-item {
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .note-dropdown-menu .dropdown-item:hover {
            background-color: var(--admin-primary) !important;
            color: white !important;
        }

        /* Focus states */
        .note-editor.note-frame:focus-within {
            border-color: var(--admin-primary) !important;
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1) !important;
        }

        /* Summernote validation styles */
        .note-editor.is-invalid {
            border-color: var(--admin-error) !important;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1) !important;
        }

        .note-editor.is-invalid .note-toolbar {
            border-bottom-color: var(--admin-error) !important;
        }

        /* Custom toolbar button styles */
        .note-toolbar .note-btn-group .note-btn {
            background: transparent;
            border: none;
            color: var(--admin-text-primary);
            padding: 6px 8px;
            margin: 2px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .note-toolbar .note-btn-group .note-btn:hover {
            background-color: var(--admin-border-light);
            color: var(--admin-text-primary);
        }

        .note-toolbar .note-btn-group .note-btn.active {
            background-color: var(--admin-primary);
            color: white;
        }


        /* FIXED: Admin Edit Page with Theme Support */
        .vachanamrut-admin-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 15px;
        }

        /* FIXED: Page Header (renamed from admin-header to avoid navbar conflict) */
        .page-header {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            text-align: center;
            box-shadow: var(--admin-shadow-sm);
        }

        .header-content .page-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .header-content .page-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0 0 10px 0;
        }

        .edit-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        /* Form Container */
        .form-container {
            background-color: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 10px;
            box-shadow: var(--admin-shadow-sm);
            overflow: hidden;
        }

        .vachanamrut-form {
            padding: 0;
        }

        /* Form Sections */
        .form-section {
            padding: 20px;
            border-bottom: 1px solid var(--admin-border-color);
        }

        .form-section:last-child {
            border-bottom: none;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 15px;
        }

        .section-header h4 {
            color: var(--admin-text-primary);
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-header h4 i {
            color: var(--admin-primary);
            font-size: 1rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--admin-text-primary);
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .form-label.required::after {
            content: '*';
            color: var(--admin-error);
            margin-left: 3px;
        }

        /* Enhanced Form Controls */
        .form-control {
            border: 2px solid var(--admin-border-color);
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background-color: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1);
            background-color: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
        }

        .readonly-input {
            background-color: var(--admin-bg-tertiary) !important;
            color: var(--admin-text-muted) !important;
            cursor: not-allowed;
        }

        .readonly-input:focus {
            border-color: var(--admin-border-color) !important;
            box-shadow: none !important;
        }

        /* FIXED: BIGGER CONTENT TEXTAREAS */
        .content-textarea {
            min-height: 300px !important;
            resize: vertical;
            line-height: 1.6;
            font-family: inherit;
        }

        .gujarati-text {
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif;
            direction: ltr;
        }

        .form-text {
            font-size: 0.8rem;
            color: var(--admin-text-muted);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Language Tabs */
        .language-tabs {
            border: 2px solid var(--admin-border-color);
            border-radius: 8px;
            overflow: hidden;
            background-color: var(--admin-bg-secondary);
        }

        .tab-buttons {
            display: flex;
            background-color: var(--admin-bg-tertiary);
            border-bottom: 1px solid var(--admin-border-color);
        }

        .tab-btn {
            flex: 1;
            padding: 12px 16px;
            border: none;
            background: transparent;
            color: var(--admin-text-secondary);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.9rem;
        }

        .tab-btn.active {
            background-color: var(--admin-primary);
            color: white;
        }

        .tab-btn:hover:not(.active) {
            background-color: var(--admin-border-light);
            color: var(--admin-text-primary);
        }

        .tab-content {
            display: none;
            padding: 20px;
        }

        .tab-content.active {
            display: block;
        }

        /* Form Actions */
        .form-actions {
            padding: 20px;
            background-color: var(--admin-bg-tertiary);
            border-top: 1px solid var(--admin-border-color);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            border: 2px solid transparent;
        }

        .btn-primary {
            background-color: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        .btn-primary:hover {
            background-color: var(--admin-primary-dark);
            border-color: var(--admin-primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--admin-shadow-md);
        }

        .btn-secondary {
            background-color: var(--admin-bg-secondary);
            color: var(--admin-text-secondary);
            border-color: var(--admin-border-color);
        }

        .btn-secondary:hover {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
            border-color: var(--admin-text-muted);
        }

        /* FIXED: Complete Select2 Integration with Dark Mode Support */
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            background-color: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            border-radius: 6px !important;
            min-height: 42px !important;
        }

        .select2-container--default .select2-selection--multiple {
            padding: 6px 10px !important;
        }

        /* FIXED: Placeholder Text in Both Modes */
        .select2-container--default .select2-selection--single .select2-selection__placeholder,
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: var(--admin-text-muted) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--admin-text-primary) !important;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: var(--admin-text-primary) !important;
        }

        /* FIXED: Dark Mode Specific Styles */
        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__placeholder,
        [data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: var(--admin-text-muted) !important;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: var(--admin-text-primary) !important;
        }

        /* FIXED: Dropdown Menu Dark Mode */
        [data-theme="dark"] .select2-dropdown {
            background-color: var(--admin-bg-secondary) !important;
            border: 1px solid var(--admin-border-color) !important;
            border-radius: 6px;
            box-shadow: var(--admin-shadow-lg);
        }

        [data-theme="dark"] .select2-search--dropdown .select2-search__field {
            background-color: var(--admin-bg-tertiary) !important;
            border: 1px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .select2-results__option {
            background-color: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            padding: 8px 12px;
        }

        [data-theme="dark"] .select2-results__option--highlighted {
            background-color: var(--admin-primary) !important;
            color: white !important;
        }

        [data-theme="dark"] .select2-results__option[aria-selected="true"] {
            background-color: var(--admin-primary-bg) !important;
            color: var(--admin-primary) !important;
        }

        /* FIXED: Selected Items in Multiple Select */
        [data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--admin-primary) !important;
            border: 1px solid var(--admin-primary-dark) !important;
            color: white !important;
            border-radius: 4px;
            padding: 2px 8px;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 16px;
            font-weight: bold;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: white !important;
        }

        /* Light Mode Styles */
        [data-theme="light"] .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--admin-primary) !important;
            border: 1px solid var(--admin-primary-dark) !important;
            color: white !important;
            border-radius: 4px;
            padding: 2px 8px;
        }

        /* FIXED: Focus States */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--admin-primary) !important;
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1) !important;
        }

        /* Validation States */
        .is-invalid {
            border-color: var(--admin-error) !important;
        }

        .invalid-feedback {
            color: var(--admin-error);
            font-size: 0.8rem;
            margin-top: 4px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .vachanamrut-admin-container {
                padding: 10px;
            }

            .page-header {
                padding: 15px;
                margin-bottom: 15px;
            }

            .page-title {
                font-size: 1.4rem;
                flex-direction: column;
                gap: 5px;
            }

            .form-section {
                padding: 15px;
            }

            .section-header h4 {
                font-size: 1rem;
            }

            .content-textarea {
                min-height: 250px !important;
            }

            .form-actions {
                flex-direction: column;
                gap: 8px;
                padding: 15px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .tab-buttons {
                flex-direction: column;
            }

            .tab-btn {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                padding: 12px;
            }

            .page-title {
                font-size: 1.2rem;
            }

            .form-section {
                padding: 12px;
            }

            .tab-content {
                padding: 15px;
            }

            .content-textarea {
                min-height: 200px !important;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize Summernote editors with comprehensive HTML support
            function initializeSummernote() {
                // Destroy existing instances
                $('.summernote-editor').each(function() {
                    if ($(this).hasClass('note-editor-preview')) {
                        $(this).summernote('destroy');
                    }
                });

                // Comprehensive Summernote configuration with all HTML tags + Text Alignment
                const summernoteConfig = {
                    height: 300,
                    minHeight: 300,
                    maxHeight: 600,
                    focus: false,
                    // COMPREHENSIVE TOOLBAR WITH TEXT ALIGNMENT OPTIONS
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'italic', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['align', ['alignLeft', 'alignCenter', 'alignRight',
                        'alignJustify']], // TEXT ALIGNMENT ADDED
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video', 'hr']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                        ['custom', ['blockquote', 'strikethrough', 'superscript', 'subscript']]
                    ],
                    // ALLOW ALL HTML TAGS AND ATTRIBUTES
                    codeviewFilter: false,
                    codeviewIframeFilter: false,
                    // CUSTOM STYLE TAGS
                    styleTags: [
                        'p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                        {
                            title: 'Blockquote',
                            tag: 'blockquote',
                            className: 'blockquote',
                            value: 'blockquote'
                        },
                        {
                            title: 'Pre',
                            tag: 'pre',
                            className: 'pre',
                            value: 'pre'
                        },
                        {
                            title: 'Code',
                            tag: 'code',
                            className: 'code',
                            value: 'code'
                        }
                    ],
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact',
                        'Tahoma', 'Times New Roman', 'Verdana', 'Noto Sans Gujarati', 'Shruti'
                    ],
                    fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36',
                        '48', '64'
                    ],
                    placeholder: 'Start typing your content...',
                    // ALLOW ALL HTML TAGS - NO FILTERING
                    cleaner: {
                        action: 'paste',
                        newline: '<br>',
                        notTime: 2400,
                        icon: '<i class="note-icon">[Your Button]</i>',
                        keepHtml: true,
                        keepOnlyTags: false, // Keep all tags
                        keepClasses: true,
                        badTags: [], // No bad tags - allow everything
                        badAttributes: [], // No bad attributes - allow everything
                        limitChars: false,
                        limitDisplay: 'both',
                        limitStop: false
                    },
                    // CUSTOM BUTTON DEFINITIONS
                    buttons: {
                        blockquote: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-quote-left"></i>',
                                tooltip: 'Insert Blockquote',
                                click: function() {
                                    context.invoke('editor.formatBlock', 'blockquote');
                                }
                            });
                            return button.render();
                        },
                        strikethrough: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-strikethrough"></i>',
                                tooltip: 'Strikethrough',
                                click: function() {
                                    context.invoke('editor.strikethrough');
                                }
                            });
                            return button.render();
                        },
                        superscript: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-superscript"></i>',
                                tooltip: 'Superscript',
                                click: function() {
                                    context.invoke('editor.superscript');
                                }
                            });
                            return button.render();
                        },
                        subscript: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-subscript"></i>',
                                tooltip: 'Subscript',
                                click: function() {
                                    context.invoke('editor.subscript');
                                }
                            });
                            return button.render();
                        },
                        // CUSTOM ALIGNMENT BUTTONS (if you want more control)
                        alignLeft: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-align-left"></i>',
                                tooltip: 'Align Left',
                                click: function() {
                                    context.invoke('editor.justifyLeft');
                                }
                            });
                            return button.render();
                        },
                        alignCenter: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-align-center"></i>',
                                tooltip: 'Align Center',
                                click: function() {
                                    context.invoke('editor.justifyCenter');
                                }
                            });
                            return button.render();
                        },
                        alignRight: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-align-right"></i>',
                                tooltip: 'Align Right',
                                click: function() {
                                    context.invoke('editor.justifyRight');
                                }
                            });
                            return button.render();
                        },
                        alignJustify: function(context) {
                            var ui = $.summernote.ui;
                            var button = ui.button({
                                contents: '<i class="fa fa-align-justify"></i>',
                                tooltip: 'Justify',
                                click: function() {
                                    context.invoke('editor.justifyFull');
                                }
                            });
                            return button.render();
                        }
                    },
                    callbacks: {
                        onInit: function() {
                            // Custom initialization
                        },
                        onChange: function(contents, $editable) {
                            // Auto-save or validation logic can go here
                        },
                        onFocus: function() {
                            $(this).closest('.note-editor').css('border-color', 'var(--admin-primary)');
                        },
                        onBlur: function() {
                            $(this).closest('.note-editor').css('border-color',
                            'var(--admin-border-color)');
                        },
                        // PRESERVE ALL HTML ON PASTE
                        onPaste: function(e) {
                            // Allow all HTML content on paste
                            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData)
                                .getData('Text');
                            e.preventDefault();
                            document.execCommand('insertHTML', false, bufferText);
                        }
                    }
                };

                // Initialize Gujarati editor with special font and all HTML support
                $('#lyrics_gu').summernote({
                    ...summernoteConfig,
                    fontNames: ['Noto Sans Gujarati', 'Shruti', 'Arial', 'Arial Black', 'Comic Sans MS',
                        'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'
                    ],
                    placeholder: 'વచનામૃતનું મૂળ લખાણ લખો...',
                    callbacks: {
                        ...summernoteConfig.callbacks,
                        onInit: function() {
                            // Set Gujarati font as default
                            $(this).closest('.note-editor').addClass('gujarati-editor');
                            // Set default font
                            $(this).summernote('fontName', 'Noto Sans Gujarati');
                        }
                    }
                });

                // Initialize English editor with all HTML support
                $('#lyrics_en').summernote({
                    ...summernoteConfig,
                    placeholder: 'English translation (optional)...'
                });
            }

            // Enhanced Select2 initialization with proper theme support
            function initializeSelect2() {
                // Destroy existing instance if it exists
                if ($('.select2').hasClass('select2-hidden-accessible')) {
                    $('.select2').select2('destroy');
                }

                // Initialize with proper settings
                $('.select2').select2({
                    placeholder: '{{ __('Select categories') }}',
                    allowClear: true,
                    width: '100%',
                    theme: 'default',
                    language: {
                        noResults: function() {
                            return '{{ __('No results found') }}';
                        },
                        searching: function() {
                            return '{{ __('Searching...') }}';
                        }
                    }
                });
            }

            // Initialize components
            initializeSummernote();
            initializeSelect2();

            // Reinitialize on theme change
            window.addEventListener('themeChanged', function(e) {
                setTimeout(function() {
                    initializeSummernote();
                    initializeSelect2();
                }, 150);
            });

            // Tab functionality with Gujarati as DEFAULT
            $('.tab-btn').on('click', function() {
                const tabId = $(this).data('tab');

                // Update active tab button
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                // Update active tab content
                $('.tab-content').removeClass('active');
                $('#' + tabId + '-tab').addClass('active');

                // Refresh Summernote in active tab
                setTimeout(function() {
                    $('#' + tabId + '-tab').find('.summernote-editor').summernote('focus');
                }, 100);
            });

            // Enhanced form validation
            $('.vachanamrut-form').on('submit', function(e) {
                // Update Summernote content to textareas before validation
                $('.summernote-editor').each(function() {
                    const content = $(this).summernote('code');
                    $(this).val(content);
                });

                if (!validateForm()) {
                    e.preventDefault();
                    toastr.error('{{ __('Please fill in all required fields.') }}', 'Validation Error');
                    return false;
                }
            });

            // Real-time validation for required fields
            $('.form-control[required]').on('input blur', function() {
                if ($(this).val().trim()) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });

            // Summernote validation
            $('.summernote-editor[required]').on('summernote.change', function() {
                const content = $(this).summernote('code');
                const textContent = $('<div>').html(content).text().trim();

                if (textContent.length > 0) {
                    $(this).closest('.note-editor').removeClass('is-invalid');
                } else {
                    $(this).closest('.note-editor').addClass('is-invalid');
                }
            });

            // Focus on Gujarati title by default (since Gujarati tab is active)
            setTimeout(function() {
                $('#title_gu').focus();
            }, 100);
        });

        // Enhanced form validation function
        function validateForm() {
            let isValid = true;

            // Validate regular required fields
            $('.form-control[required]').not('.summernote-editor').each(function() {
                if (!$(this).val().trim()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validate Summernote editors
            $('.summernote-editor[required]').each(function() {
                const content = $(this).summernote('code');
                const textContent = $('<div>').html(content).text().trim();

                if (textContent.length === 0) {
                    $(this).closest('.note-editor').addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).closest('.note-editor').removeClass('is-invalid');
                }
            });

            return isValid;
        }
    </script>
@endsection
