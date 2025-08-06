@extends('admin.layouts.app')
@section('title', __('Edit Vachanamrut') . ' - ' . $song->{'title_' . app()->getLocale()})

@section('content')
    <div class="vachanamrut-admin-container">
        <!-- Page Header -->
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
                            <!-- GUJARATI IS DEFAULT ACTIVE -->
                            <button type="button" class="tab-btn active" data-tab="gujarati">
                                <i class="fas fa-font"></i> {{ __('ગુજરાતી') }}
                            </button>
                            <button type="button" class="tab-btn" data-tab="english">
                                <i class="fas fa-globe"></i> {{ __('English') }}
                            </button>
                        </div>

                        <!-- Gujarati Tab - DEFAULT ACTIVE -->
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

                                <!-- Custom Toolbar -->
                                <div class="custom-toolbar" data-target="lyrics_gu">
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Format:</span>
                                        <button type="button" class="toolbar-btn" data-action="bold" title="Bold">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button type="button" class="toolbar-btn" data-action="abbr" title="Abbreviation">
                                            <i class="fas fa-text-width"></i>
                                        </button>
                                    </div>
                                    <div class="toolbar-separator"></div>
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Align:</span>
                                        <button type="button" class="toolbar-btn" data-action="alignLeft"
                                            title="Align Left">
                                            <i class="fas fa-align-left"></i>
                                        </button>
                                        <button type="button" class="toolbar-btn" data-action="alignCenter"
                                            title="Align Center">
                                            <i class="fas fa-align-center"></i>
                                        </button>
                                        <button type="button" class="toolbar-btn" data-action="alignRight"
                                            title="Align Right">
                                            <i class="fas fa-align-right"></i>
                                        </button>
                                    </div>
                                    <div class="toolbar-separator"></div>
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Font:</span>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Noto Sans Gujarati" title="Default Gujarati">
                                            <i class="fas fa-font"></i> Default
                                        </button>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Gopika" title="Gopika Font">
                                            <i class="fas fa-font"></i> Gopika
                                        </button>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Sanskrit" title="Sanskrit Font">
                                            <i class="fas fa-font"></i> Sanskrit
                                        </button>
                                    </div>
                                </div>

                                <!-- Split Editor and Preview Layout -->
                                <div class="editor-preview-container">
                                    <div class="editor-section">
                                        <div class="section-title">{{ __('Editor') }}</div>
                                        <textarea class="form-control gujarati-text content-textarea custom-editor @error('lyrics_gu') is-invalid @enderror"
                                            id="lyrics_gu" name="lyrics_gu" placeholder="{{ __('વચનામૃતનું મૂળ લખાણ લખો...') }}" required>{{ old('lyrics_gu', $song->lyrics_gu) }}</textarea>
                                    </div>

                                    <div class="preview-section">
                                        <div class="section-title">{{ __('Preview') }}</div>
                                        <div class="live-preview gujarati-text" id="preview_lyrics_gu">
                                            <div class="preview-content">{{ __('Preview will appear here...') }}</div>
                                        </div>
                                    </div>
                                </div>

                                @error('lyrics_gu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    {{ __('Use the toolbar buttons to format your text. Select text first, then click formatting, alignment, or font buttons. Preview updates automatically.') }}
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

                                <!-- Custom Toolbar -->
                                <div class="custom-toolbar" data-target="lyrics_en">
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Format:</span>
                                        <button type="button" class="toolbar-btn" data-action="bold" title="Bold">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button type="button" class="toolbar-btn" data-action="abbr"
                                            title="Abbreviation">
                                            <i class="fas fa-text-width"></i>
                                        </button>
                                    </div>
                                    <div class="toolbar-separator"></div>
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Align:</span>
                                        <button type="button" class="toolbar-btn" data-action="alignLeft"
                                            title="Align Left">
                                            <i class="fas fa-align-left"></i>
                                        </button>
                                        <button type="button" class="toolbar-btn" data-action="alignCenter"
                                            title="Align Center">
                                            <i class="fas fa-align-center"></i>
                                        </button>
                                        <button type="button" class="toolbar-btn" data-action="alignRight"
                                            title="Align Right">
                                            <i class="fas fa-align-right"></i>
                                        </button>
                                    </div>
                                    <div class="toolbar-separator"></div>
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Font:</span>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Arial" title="Default English">
                                            <i class="fas fa-font"></i> Default
                                        </button>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Gopika" title="Gopika Font">
                                            <i class="fas fa-font"></i> Gopika
                                        </button>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Sanskrit" title="Sanskrit Font">
                                            <i class="fas fa-font"></i> Sanskrit
                                        </button>
                                    </div>
                                </div>

                                <!-- Split Editor and Preview Layout -->
                                <div class="editor-preview-container">
                                    <div class="editor-section">
                                        <div class="section-title">{{ __('Editor') }}</div>
                                        <textarea class="form-control content-textarea custom-editor @error('lyrics_en') is-invalid @enderror" id="lyrics_en"
                                            name="lyrics_en" placeholder="{{ __('English translation (optional)') }}">{{ old('lyrics_en', $song->lyrics_en) }}</textarea>
                                    </div>

                                    <div class="preview-section">
                                        <div class="section-title">{{ __('Live Preview') }}</div>
                                        <div class="live-preview" id="preview_lyrics_en">
                                            <div class="preview-content">{{ __('Preview will appear here...') }}</div>
                                        </div>
                                    </div>
                                </div>

                                @error('lyrics_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Section -->
                {{-- <div class="form-section">
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
                </div> --}}

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
        /* Import fonts */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati:wght@100;200;300;400;500;600;700;800;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@100;200;300;400;500;600;700;800;900&display=swap');

        /* Define font faces for local Gopika and Sanskrit fonts */
        @font-face {
            font-family: 'Gopika';
            src: url('{{ asset('fonts/Gopika.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Sanskrit';
            src: url('{{ asset('fonts/Sanskrit.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        /* Container with proper navbar spacing */
        .vachanamrut-admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
        }

        /* Page Header */
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

        /* Enhanced Custom Toolbar Styles */
        .custom-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            padding: 12px;
            background-color: var(--admin-bg-tertiary);
            border: 1px solid var(--admin-border-color);
            border-radius: 6px 6px 0 0;
            border-bottom: none;
            flex-wrap: wrap;
        }

        .toolbar-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .toolbar-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--admin-text-secondary);
            margin-right: 4px;
        }

        .toolbar-separator {
            width: 1px;
            height: 30px;
            background-color: var(--admin-border-color);
            margin: 0 4px;
        }

        .toolbar-btn {
            background-color: transparent;
            border: 1px solid var(--admin-border-color);
            border-radius: 4px;
            padding: 8px 12px;
            color: var(--admin-text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            min-height: 36px;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .toolbar-btn:hover {
            background-color: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        .toolbar-btn.active {
            background-color: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        /* Font-specific styles for different buttons */
        .font-btn[data-font="Noto Sans Gujarati"],
        .font-btn[data-font="Arial"] {
            font-weight: 500;
        }

        .font-btn[data-font="Gopika"] {
            font-family: 'Gopika', 'Noto Sans Gujarati', sans-serif;
        }

        .font-btn[data-font="Sanskrit"] {
            font-family: 'Sanskrit', 'Noto Sans Devanagari', sans-serif;
        }

        /* Split Editor and Preview Layout */
        .editor-preview-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border: 2px solid var(--admin-border-color);
            border-top: none;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
        }

        .editor-section,
        .preview-section {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-secondary);
            padding: 8px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            border-bottom: 1px solid var(--admin-border-color);
        }

        /* Custom Editor Styles */
        .custom-editor {
            border: none !important;
            border-radius: 0 !important;
            min-height: 300px !important;
            resize: none;
            line-height: 1.6;
            font-family: inherit;
            flex: 1;
        }

        .custom-editor:focus {
            box-shadow: none !important;
        }

        /* Live Preview Styles */
        .live-preview {
            background-color: var(--admin-bg-secondary);
            min-height: 300px;
            flex: 1;
            overflow-y: auto;
        }

        .preview-content {
            padding: 15px;
            color: var(--admin-text-primary);
            line-height: 1.6;
            min-height: 270px;
            font-size: 1.5rem;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .preview-content:empty::before {
            content: attr(data-placeholder);
            color: var(--admin-text-muted);
            font-style: italic;
        }

        /* Font classes for content */
        .font-gopika,
        .preview-content .font-gopika {
            font-family: 'Gopika', 'Noto Sans Gujarati', sans-serif !important;
        }

        .font-sanskrit,
        .preview-content .font-sanskrit {
            font-family: 'Sanskrit', 'Noto Sans Devanagari', sans-serif !important;
        }

        .font-gujarati,
        .preview-content .font-gujarati {
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif !important;
        }

        .font-english,
        .preview-content .font-english {
            font-family: 'Arial', 'Helvetica', sans-serif !important;
        }

        /* Preview HTML rendering */
        .preview-content strong {
            font-weight: bold;
        }

        .preview-content abbr {
            text-decoration: underline dotted;
            cursor: help;
            border-bottom: 1px dotted var(--admin-text-secondary);
        }

        .preview-content abbr:hover {
            background-color: var(--admin-primary-bg);
            color: var(--admin-primary);
        }

        /* Alignment styles for preview */
        .preview-content div[style*="text-align: left"] {
            text-align: left !important;
        }

        .preview-content div[style*="text-align: center"] {
            text-align: center !important;
        }

        .preview-content div[style*="text-align: right"] {
            text-align: right !important;
        }

        /* Handle line breaks and spaces in preview */
        .preview-content {
            white-space: pre-wrap;
        }

        #lyrics_gu {
            font-size: 1.5rem;
        }

        /* BIGGER CONTENT TEXTAREAS */
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

        /* Select2 Styles (keeping existing) */
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
        @media (max-width: 992px) {
            .editor-preview-container {
                grid-template-columns: 1fr;
            }

            .vachanamrut-admin-container {
                max-width: 100%;
                padding: 10px;
            }
        }

        @media (max-width: 768px) {
            .custom-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .toolbar-group {
                justify-content: center;
            }

            .toolbar-separator {
                display: none;
            }

            .toolbar-btn {
                font-size: 0.75rem;
                padding: 6px 8px;
                min-height: 32px;
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
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            function initializeSelect2() {
                if ($('.select2').hasClass('select2-hidden-accessible')) {
                    $('.select2').select2('destroy');
                }

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

            // Initialize Select2
            initializeSelect2();

            // Reinitialize on theme change
            window.addEventListener('themeChanged', function(e) {
                setTimeout(function() {
                    initializeSelect2();
                }, 150);
            });

            // Tab functionality
            $('.tab-btn').on('click', function() {
                const tabId = $(this).data('tab');

                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                $('.tab-content').removeClass('active');
                $('#' + tabId + '-tab').addClass('active');

                setTimeout(function() {
                    $('#' + tabId + '-tab').find('textarea').first().focus();
                }, 100);
            });

            // Live preview update function
            function updatePreview(textareaId) {
                const textarea = $('#' + textareaId);
                const previewContainer = $('#preview_' + textareaId + ' .preview-content');
                let content = textarea.val();

                if (content.trim()) {
                    // Handle line breaks and preserve formatting
                    content = content.replace(/\n/g, '<br>');

                    // Handle font spans properly
                    content = content.replace(
                        /<span style="font-family:\s*['"](.*?)['"]">(.*?)<\/span>/g,
                        '<span style="font-family: $1">$2</span>'
                    );

                    previewContainer.html(content);
                } else {
                    previewContainer.attr('data-placeholder', '{{ __('Preview will appear here...') }}');
                    previewContainer.html('');
                }
            }

            // Enhanced Custom toolbar functionality
            $('.toolbar-btn').on('click', function(e) {
                e.preventDefault();

                const action = $(this).data('action');
                const target = $(this).closest('.custom-toolbar').data('target');
                const textarea = $('#' + target)[0];

                if (action === 'font') {
                    // Font change functionality
                    const fontFamily = $(this).data('font');
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const selectedText = textarea.value.substring(start, end);

                    if (selectedText === '') {
                        alert('{{ __('Please select text first to change font') }}');
                        return;
                    }

                    // Create font span with inline style
                    let wrappedText = '<span style="font-family: \'' + fontFamily + '\'">' + selectedText +
                        '</span>';

                    // Replace selected text with wrapped text
                    const newValue = textarea.value.substring(0, start) + wrappedText + textarea.value
                        .substring(end);
                    textarea.value = newValue;

                    // Set cursor position after the wrapped text
                    const newCursorPos = start + wrappedText.length;
                    textarea.setSelectionRange(newCursorPos, newCursorPos);
                    textarea.focus();

                    // Update preview immediately
                    updatePreview(target);

                    // Visual feedback
                    $(this).addClass('active');
                    setTimeout(() => {
                        $(this).removeClass('active');
                    }, 300);

                } else if (['alignLeft', 'alignCenter', 'alignRight'].includes(action)) {
                    // Alignment functionality
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const selectedText = textarea.value.substring(start, end);

                    if (selectedText === '') {
                        alert('{{ __('Please select text first to align') }}');
                        return;
                    }

                    let alignValue = 'left';
                    if (action === 'alignCenter') alignValue = 'center';
                    else if (action === 'alignRight') alignValue = 'right';

                    let wrappedText = '<div style="text-align: ' + alignValue + '">' + selectedText +
                        '</div>';

                    // Replace selected text with wrapped text
                    const newValue = textarea.value.substring(0, start) + wrappedText + textarea.value
                        .substring(end);
                    textarea.value = newValue;

                    // Set cursor position after the wrapped text
                    const newCursorPos = start + wrappedText.length;
                    textarea.setSelectionRange(newCursorPos, newCursorPos);
                    textarea.focus();

                    // Update preview immediately
                    updatePreview(target);

                    // Visual feedback
                    $(this).addClass('active');
                    setTimeout(() => {
                        $(this).removeClass('active');
                    }, 300);

                } else {
                    // Existing formatting functionality (bold, abbr)
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const selectedText = textarea.value.substring(start, end);

                    if (selectedText === '') {
                        alert('{{ __('Please select text first') }}');
                        return;
                    }

                    let wrappedText = '';

                    if (action === 'bold') {
                        wrappedText = '<strong>' + selectedText + '</strong>';
                    } else if (action === 'abbr') {
                        const title = prompt('{{ __('Enter abbreviation meaning:') }}');
                        if (title) {
                            wrappedText = '<abbr title="' + title + '">' + selectedText + '</abbr>';
                        } else {
                            return;
                        }
                    }

                    // Replace selected text with wrapped text
                    const newValue = textarea.value.substring(0, start) + wrappedText + textarea.value
                        .substring(end);
                    textarea.value = newValue;

                    // Set cursor position after the wrapped text
                    const newCursorPos = start + wrappedText.length;
                    textarea.setSelectionRange(newCursorPos, newCursorPos);
                    textarea.focus();

                    // Update preview immediately
                    updatePreview(target);

                    // Visual feedback
                    $(this).addClass('active');
                    setTimeout(() => {
                        $(this).removeClass('active');
                    }, 200);
                }
            });

            // Live preview on typing (with debouncing for performance)
            let previewTimeout;
            $('textarea.custom-editor').on('input keyup paste', function() {
                const textareaId = $(this).attr('id');

                // Clear previous timeout
                clearTimeout(previewTimeout);

                // Update preview after a short delay to improve performance
                previewTimeout = setTimeout(function() {
                    updatePreview(textareaId);
                }, 100);
            });

            // Initial preview update with existing content
            $('textarea.custom-editor').each(function() {
                const textareaId = $(this).attr('id');
                updatePreview(textareaId);
            });

            // Enhanced form validation
            $('.vachanamrut-form').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    if (typeof toastr !== 'undefined') {
                        toastr.error('{{ __('Please fill in all required fields.') }}',
                        'Validation Error');
                    } else {
                        alert('{{ __('Please fill in all required fields.') }}');
                    }
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

            // Focus on Gujarati title by default
            setTimeout(function() {
                $('#title_gu').focus();
            }, 100);
        });

        // Enhanced form validation function
        function validateForm() {
            let isValid = true;

            $('.form-control[required]').each(function() {
                if (!$(this).val().trim()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            return isValid;
        }
    </script>
@endsection
