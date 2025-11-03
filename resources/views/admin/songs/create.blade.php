@extends('admin.layouts.app')
@section('title', 'Create Vachanamrut')

@section('content')
    <div class="vachanamrut-admin-container">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="page-title">
                <i class="fas fa-plus-circle"></i>
                {{ __('Add New Vachanamrut') }}
            </h2>
            <p class="page-subtitle">{{ __('Create a new Vachanamrut entry') }}</p>
        </div>

        <!-- Main Form -->
        <div class="form-container">
            <form action="{{ route('admin.songs.store') }}" method="POST" class="vachanamrut-form">
                @csrf

                <!-- Vachanamrut Code Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h4><i class="fas fa-code"></i> {{ __('Vachanamrut Code') }}</h4>
                    </div>

                    <div class="row">
                        <!-- Song Code -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="song_code" class="form-label required">{{ __('Code') }}</label>
                                <input type="text" class="form-control @error('song_code') is-invalid @enderror"
                                    id="song_code" name="song_code" value="{{ old('song_code') }}"
                                    placeholder="{{ __('e.g., 1, 2, 3, etc.') }}" required>
                                <small class="form-text text-muted">{{ __('Enter unique identifier') }}</small>
                                @error('song_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Vachanamrut Code -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vachnamrut_code"
                                    class="form-label required">{{ __('Vachanamrut Code') }}</label>
                                <input type="text" class="form-control @error('vachnamrut_code') is-invalid @enderror"
                                    id="vachnamrut_code" name="vachnamrut_code" value="{{ old('vachnamrut_code') }}"
                                    placeholder="{{ __('e.g., G-1, G-2, etc.') }}" required>
                                <small class="form-text text-muted">{{ __('Enter Vachanamrut code') }}</small>
                                @error('vachnamrut_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                            id="written_date" name="written_date" value="{{ old('written_date') }}"
                            placeholder="e.g., 17/09/1825, Saturday">
                        <small
                            class="form-text text-muted">{{ __('Enter date in format: DD/MM/YYYY, Day (e.g., 17/09/1825, Saturday)') }}</small>
                        @error('written_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
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
                                    id="title_gu" name="title_gu" value="{{ old('title_gu') }}"
                                    placeholder="{{ __('વચનામૃતનું શીર્ષક લખો') }}" required>
                                @error('title_gu')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="lyrics_gu" class="form-label required">{{ __('Gujarati Content') }}</label>

                                <!-- Custom Toolbar -->
                                <div class="custom-toolbar" data-target="lyrics_gu">
                                    <div class="toolbar-group">
                                        <span class="toolbar-label">Format:</span>
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
                                            data-font="ssgd3" title="Sanskardham Font">
                                            <i class="fas fa-font"></i> Sanskardham
                                        </button>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Sanskrit" title="Sanskrit Font">
                                            <i class="fas fa-font"></i> Sanskrit
                                        </button>
                                    </div>
                                </div>

                                <!-- Single Rich Text Editor with Live Preview -->
                                <div class="single-editor-container">
                                    <div class="section-title">
                                        {{ __('Editor') }} <span class="live-indicator">● LIVE</span>
                                    </div>

                                    <div class="rich-text-editor gujarati-text @error('lyrics_gu') is-invalid-editor @enderror"
                                        id="rich_editor_lyrics_gu" contenteditable="true" data-target="lyrics_gu"
                                        data-placeholder="{{ __('વચનામૃતનું મૂળ લખાણ લખો...') }}">{{ old('lyrics_gu') }}
                                    </div>

                                    <!-- Hidden textarea to maintain form functionality -->
                                    <textarea
                                        class="form-control gujarati-text content-textarea custom-editor hidden-textarea @error('lyrics_gu') is-invalid @enderror"
                                        id="lyrics_gu" name="lyrics_gu" required style="display: none;">{{ old('lyrics_gu') }}</textarea>
                                </div>

                                @error('lyrics_gu')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    {{ __('Use the toolbar buttons to format your text. Select text first, then click formatting buttons. Live preview shows as you type.') }}
                                </small>
                            </div>
                        </div>

                        <!-- English Tab -->
                        <div class="tab-content" id="english-tab">
                            <div class="form-group">
                                <label for="title_en" class="form-label">{{ __('English Title') }}</label>
                                <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                                    id="title_en" name="title_en" value="{{ old('title_en') }}"
                                    placeholder="{{ __('English title (optional)') }}">
                                @error('title_en')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                            data-font="ssgd3" title="Sanskardham Font">
                                            <i class="fas fa-font"></i> Sanskardham
                                        </button>
                                        <button type="button" class="toolbar-btn font-btn" data-action="font"
                                            data-font="Sanskrit" title="Sanskrit Font">
                                            <i class="fas fa-font"></i> Sanskrit
                                        </button>
                                    </div>
                                </div>

                                <!-- Single Rich Text Editor with Live Preview -->
                                <div class="single-editor-container">
                                    <div class="section-title">
                                        {{ __('Editor') }} <span class="live-indicator">● LIVE</span>
                                    </div>

                                    <div class="rich-text-editor @error('lyrics_en') is-invalid-editor @enderror"
                                        id="rich_editor_lyrics_en" contenteditable="true" data-target="lyrics_en"
                                        data-placeholder="{{ __('English translation (optional)') }}">
                                        {{ old('lyrics_en') }}</div>

                                    <!-- Hidden textarea to maintain form functionality -->
                                    <textarea class="form-control content-textarea custom-editor hidden-textarea @error('lyrics_en') is-invalid @enderror"
                                        id="lyrics_en" name="lyrics_en" style="display: none;">{{ old('lyrics_en') }}</textarea>
                                </div>

                                @error('lyrics_en')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
                        <label for="category_code" class="form-label required">{{ __('Categories') }}</label>
                        <select class="form-control select2 @error('category_code') is-invalid @enderror"
                            id="category_code" name="category_code" data-placeholder="{{ __('Select categories') }}">
                            <option value="">{{ __('Select categories') }}</option>
                            @foreach ($categories as $scategory)
                                <option value="{{ $scategory->category_code }}"
                                    {{ old('category_code') == $scategory->category_code ? 'selected' : '' }}>
                                    {{ $scategory->category_en }} ({{ $scategory->category_gu }})
                                </option>
                            @endforeach
                        </select>
                        @error('category_code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ __('Save Vachanamrut') }}
                    </button>
                    <a href="{{ route('admin.songs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('Back to List') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Tooltip Container -->
    <div id="custom-tooltip" class="custom-tooltip" style="display: none;"></div>
@endsection

@section('style')
    <style>
        /* Import fonts */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati:wght@100;200;300;400;500;600;700;800;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@100;200;300;400;500;600;700;800;900&display=swap');

        /* Define font faces for local fonts */
        @font-face {
            font-family: 'Gopika';
            src: url('{{ asset('fonts/Gopika.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'ssgd3';
            src: url('{{ asset('fonts/ssgd3.ttf') }}') format('truetype');
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

        .page-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0 0 5px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .page-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
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

        .font-btn[data-font="ssgd3"] {
            font-family: 'ssgd3', 'Noto Sans Gujarati', sans-serif;
        }

        .font-btn[data-font="Sanskrit"] {
            font-family: 'Sanskrit', 'Noto Sans Devanagari', sans-serif;
        }

        /* Single Editor Container */
        .single-editor-container {
            border: 2px solid var(--admin-border-color);
            border-top: none;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
            background-color: var(--admin-bg-secondary);
        }

        .section-title {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-secondary);
            padding: 8px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            border-bottom: 1px solid var(--admin-border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Rich Text Editor with Clean Live Preview */
        .rich-text-editor {
            border: none !important;
            border-radius: 0 !important;
            min-height: 400px !important;
            padding: 15px;
            font-size: 1.5rem;
            line-height: 1.6;
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif;
            background-color: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            outline: none;
            resize: none;
            text-align: justify;
        }

        .rich-text-editor:focus {
            background-color: var(--admin-bg-secondary);
            border: 2px solid var(--admin-primary) !important;
            margin: -2px;
        }

        .rich-text-editor:empty::before {
            content: attr(data-placeholder);
            color: var(--admin-text-muted);
            font-style: italic;
            pointer-events: none;
        }

        /* Clean formatting styles - NO COLORS, just subtle differences */
        .rich-text-editor strong {
            font-weight: bold;
        }

        .rich-text-editor abbr {
            text-decoration: underline dotted;
            cursor: help;
            border-bottom: 1px dotted var(--admin-text-muted);
        }

        .rich-text-editor abbr:hover {
            opacity: 0.8;
        }

        /* Clean font styling - NO COLORS, just font changes */
        .rich-text-editor .font-gopika,
        .rich-text-editor span[style*="Gopika"] {
            font-family: 'Gopika', 'Noto Sans Gujarati', sans-serif !important;
        }

        .rich-text-editor .font-ssgd3,
        .rich-text-editor span[style*="ssgd3"] {
            font-family: 'ssgd3', 'Noto Sans Gujarati', sans-serif !important;
        }

        .rich-text-editor .font-sanskrit,
        .rich-text-editor span[style*="Sanskrit"] {
            font-family: 'Sanskrit', 'Noto Sans Devanagari', sans-serif !important;
        }

        .rich-text-editor .font-gujarati,
        .rich-text-editor span[style*="Noto Sans Gujarati"] {
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif !important;
        }

        .rich-text-editor .font-english,
        .rich-text-editor span[style*="Arial"] {
            font-family: 'Arial', 'Helvetica', sans-serif !important;
        }

        /* Clean alignment styling - NO COLORS, just alignment */
        .rich-text-editor div[style*="text-align: center"] {
            text-align: center !important;
        }

        .rich-text-editor div[style*="text-align: right"] {
            text-align: right !important;
        }

        .rich-text-editor div[style*="text-align: left"] {
            text-align: left !important;
        }

        /* Simple live indicator - minimal */
        .live-indicator {
            color: var(--admin-text-muted);
            font-size: 0.7rem;
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .live-indicator::before {
            content: '';
            width: 6px;
            height: 6px;
            background-color: var(--admin-text-muted);
            border-radius: 50%;
        }

        /* Hidden textarea */
        .hidden-textarea {
            display: none !important;
        }

        /* Selection and cursor styling */
        .rich-text-editor::selection {
            background-color: var(--admin-primary);
            color: white;
        }

        .rich-text-editor {
            caret-color: var(--admin-primary);
        }

        /* Scrollbar styling for rich editor */
        .rich-text-editor::-webkit-scrollbar {
            width: 6px;
        }

        .rich-text-editor::-webkit-scrollbar-track {
            background: var(--admin-bg-tertiary);
        }

        .rich-text-editor::-webkit-scrollbar-thumb {
            background: var(--admin-border-color);
            border-radius: 3px;
        }

        .rich-text-editor::-webkit-scrollbar-thumb:hover {
            background: var(--admin-text-muted);
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

        /* Enhanced Custom Tooltip with Font Support */
        .custom-tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            z-index: 10000;
            pointer-events: none;
            white-space: nowrap;
            max-width: 300px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -6px;
            border: 6px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.9);
        }

        /* Font preservation in custom tooltip */
        .custom-tooltip .font-gopika {
            font-family: 'Gopika', 'Noto Sans Gujarati', sans-serif !important;
        }

        .custom-tooltip .font-ssgd3 {
            font-family: 'ssgd3', 'Noto Sans Gujarati', sans-serif !important;
        }

        .custom-tooltip .font-sanskrit {
            font-family: 'Sanskrit', 'Noto Sans Devanagari', sans-serif !important;
        }

        .custom-tooltip .font-gujarati {
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif !important;
        }

        .custom-tooltip .font-english {
            font-family: 'Arial', 'Helvetica', sans-serif !important;
        }

        .custom-tooltip strong {
            font-weight: bold;
        }

        /* Simple guidance tooltip styles */
        .toolbar-tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            z-index: 1000;
            pointer-events: none;
            white-space: nowrap;
        }

        .toolbar-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border: 5px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.8);
        }

        /* Responsive Design */
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

            .rich-text-editor {
                min-height: 300px !important;
                font-size: 1.2rem;
                padding: 12px;
                text-align: justify;
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

            .vachanamrut-admin-container {
                max-width: 100%;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .rich-text-editor {
                min-height: 250px !important;
                font-size: 1rem;
                padding: 10px;
            }

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

        .invalid-feedback.d-block {
            display: block !important;
            color: var(--admin-error, #dc3545);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Invalid editor border */
        .rich-text-editor.is-invalid-editor {
            border: 2px solid var(--admin-error, #dc3545) !important;
        }

        /* All other existing styles from the original file */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati:wght@100;200;300;400;500;600;700;800;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@100;200;300;400;500;600;700;800;900&display=swap');

        @font-face {
            font-family: 'Gopika';
            src: url('{{ asset('fonts/Gopika.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'ssgd3';
            src: url('{{ asset('fonts/ssgd3.ttf') }}') format('truetype');
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

        /* Add this to preserve spaces in rich text editor */
        .rich-text-editor {
            white-space: pre-wrap !important;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* For displaying saved content on the view page */
        .vachanamrut-content,
        .lyrics-display {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize Select2 with old value preservation
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
                    const richEditor = $('#' + tabId + '-tab').find('.rich-text-editor').first();
                    if (richEditor.length) {
                        richEditor.focus();
                    }
                }, 100);
            });

            // Rich Text Editor functionality with SPACE PRESERVATION
            function initializeRichEditor(editorId) {
                const richEditor = $('#rich_editor_' + editorId);
                const hiddenTextarea = $('#' + editorId);

                // Set initial content from textarea to rich editor (preserving old values)
                const initialContent = hiddenTextarea.val();
                if (initialContent) {
                    richEditor.html(initialContent);
                }

                // FIXED: Improved content synchronization with space preservation
                function syncContent() {
                    let htmlContent = richEditor.html();

                    // Don't treat empty content as valid
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = htmlContent;
                    const textContent = tempDiv.textContent || tempDiv.innerText || '';

                    if (!textContent.trim() && htmlContent.trim() === '<br>') {
                        htmlContent = '';
                    }

                    hiddenTextarea.val(htmlContent);

                    // Trigger validation check
                    if (hiddenTextarea.attr('required')) {
                        if (textContent.trim()) {
                            hiddenTextarea.removeClass('is-invalid');
                            richEditor.removeClass('is-invalid-editor');
                        }
                    }
                }

                // Update hidden textarea when rich editor content changes
                richEditor.on('input keyup', function() {
                    syncContent();
                });

                // FIXED: Improved paste handler to preserve ALL formatting including spaces
                richEditor.on('paste', function(e) {
                    e.preventDefault();

                    const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
                    const htmlData = clipboardData.getData('text/html');
                    const textData = clipboardData.getData('text/plain');

                    if (htmlData) {
                        // Create a temporary div to process the pasted HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = htmlData;

                        // Clean but preserve spaces and line breaks
                        const cleanHTML = cleanPastedHTML(tempDiv);

                        // Insert the cleaned HTML
                        const selection = window.getSelection();
                        if (selection.rangeCount > 0) {
                            const range = selection.getRangeAt(0);
                            range.deleteContents();

                            const fragment = range.createContextualFragment(cleanHTML);
                            range.insertNode(fragment);

                            // Move cursor to end of inserted content
                            range.collapse(false);
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                    } else if (textData) {
                        // For plain text, preserve spaces and line breaks
                        const formattedText = preserveSpacesAndLineBreaks(textData);
                        document.execCommand('insertHTML', false, formattedText);
                    }

                    // Sync content after paste
                    setTimeout(() => {
                        syncContent();
                    }, 50);
                });

                // FIXED: Function to preserve spaces and line breaks in plain text
                function preserveSpacesAndLineBreaks(text) {
                    // Replace multiple spaces with non-breaking spaces
                    // Keep the last space as regular space for proper word wrapping
                    text = text.replace(/ {2,}/g, function(match) {
                        return '&nbsp;'.repeat(match.length - 1) + ' ';
                    });

                    // Replace line breaks with <br> tags
                    text = text.replace(/\n/g, '<br>');

                    return text;
                }

                // FIXED: Function to clean pasted HTML while preserving spaces
                function cleanPastedHTML(element) {
                    // Remove script tags and other dangerous elements
                    const scripts = element.querySelectorAll('script, iframe, object, embed, link, meta');
                    scripts.forEach(script => script.remove());

                    // Process all text nodes to preserve spaces
                    const walker = document.createTreeWalker(
                        element,
                        NodeFilter.SHOW_TEXT,
                        null,
                        false
                    );

                    const textNodes = [];
                    let node;
                    while (node = walker.nextNode()) {
                        textNodes.push(node);
                    }

                    // Replace multiple spaces in text nodes with &nbsp;
                    textNodes.forEach(textNode => {
                        let text = textNode.textContent;
                        // Preserve multiple spaces by converting them to &nbsp;
                        text = text.replace(/ {2,}/g, function(match) {
                            return '&nbsp;'.repeat(match.length - 1) + ' ';
                        });

                        if (text !== textNode.textContent) {
                            const span = document.createElement('span');
                            span.innerHTML = text;
                            textNode.parentNode.replaceChild(span, textNode);
                        }
                    });

                    // Clean attributes but preserve formatting and inline styles
                    const allElements = element.querySelectorAll('*');
                    allElements.forEach(el => {
                        // Keep safe attributes including white-space styles
                        const allowedAttrs = ['style', 'class', 'data-meaning', 'data-tooltip', 'title'];
                        const attrs = [...el.attributes];
                        attrs.forEach(attr => {
                            if (!allowedAttrs.includes(attr.name)) {
                                el.removeAttribute(attr.name);
                            }
                        });

                        // Preserve white-space style if present
                        if (el.style && !el.style.whiteSpace) {
                            el.style.whiteSpace = 'pre-wrap';
                        }
                    });

                    // Convert regular line breaks to <br> tags
                    let html = element.innerHTML;

                    return html;
                }

                // Handle keyboard shortcuts
                richEditor.on('keydown', function(e) {
                    // Ctrl+B for bold
                    if (e.ctrlKey && e.which === 66) {
                        e.preventDefault();
                        document.execCommand('bold', false, null);
                        setTimeout(() => syncContent(), 10);
                        return false;
                    }

                    // Ctrl+I for italic
                    if (e.ctrlKey && e.which === 73) {
                        e.preventDefault();
                        document.execCommand('italic', false, null);
                        setTimeout(() => syncContent(), 10);
                        return false;
                    }

                    // Handle Tab key to insert spaces instead of losing focus
                    if (e.which === 9) {
                        e.preventDefault();
                        // Insert 4 non-breaking spaces for tab
                        document.execCommand('insertHTML', false, '&nbsp;&nbsp;&nbsp;&nbsp;');
                        setTimeout(() => syncContent(), 10);
                        return false;
                    }

                    // Handle Enter key to ensure proper line breaks
                    if (e.which === 13 && !e.shiftKey) {
                        e.preventDefault();
                        document.execCommand('insertHTML', false, '<br><br>');
                        setTimeout(() => syncContent(), 10);
                        return false;
                    }
                });

                // FIXED: Sync on blur to ensure content is saved
                richEditor.on('blur', function() {
                    syncContent();
                });

                // Handle multiple spaces typed manually
                richEditor.on('keypress', function(e) {
                    // If space is pressed
                    if (e.which === 32) {
                        const selection = window.getSelection();
                        if (selection.rangeCount > 0) {
                            const range = selection.getRangeAt(0);
                            const textBeforeCursor = range.startContainer.textContent.substring(0, range
                                .startOffset);

                            // If the previous character was a space, insert &nbsp; instead
                            if (textBeforeCursor.endsWith(' ') || textBeforeCursor.endsWith('\u00A0')) {
                                e.preventDefault();
                                document.execCommand('insertHTML', false, '&nbsp;');
                                setTimeout(() => syncContent(), 10);
                                return false;
                            }
                        }
                    }
                });
            }

            // Custom Tooltip System
            let customTooltip = $('#custom-tooltip');
            let tooltipTimeout;

            function showCustomTooltip(element, content) {
                clearTimeout(tooltipTimeout);
                customTooltip.html(content);

                const elementOffset = $(element).offset();
                const elementWidth = $(element).outerWidth();
                const tooltipWidth = customTooltip.outerWidth();

                const left = elementOffset.left + (elementWidth / 2) - (tooltipWidth / 2);
                const top = elementOffset.top - customTooltip.outerHeight() - 10;

                customTooltip.css({
                    left: Math.max(10, left) + 'px',
                    top: top + 'px',
                    display: 'block'
                });
            }

            function hideCustomTooltip() {
                tooltipTimeout = setTimeout(() => {
                    customTooltip.hide();
                }, 300);
            }

            // Enhanced toolbar functionality - FIXED VERSION
            $('.toolbar-btn').on('click', function(e) {
                e.preventDefault();

                const action = $(this).data('action');
                const target = $(this).closest('.custom-toolbar').data('target');
                const richEditor = $('#rich_editor_' + target)[0];
                const $richEditor = $('#rich_editor_' + target);

                richEditor.focus();

                const selection = window.getSelection();

                // Check if text is selected for actions that require it
                const requiresSelection = ['font', 'alignLeft', 'alignCenter', 'alignRight', 'bold',
                'abbr'];
                if (requiresSelection.includes(action) && (selection.rangeCount === 0 || selection
                        .isCollapsed)) {
                    let message = '{{ __('Please select text first') }}';
                    if (action === 'font') message = '{{ __('Please select text first to change font') }}';
                    else if (action.startsWith('align')) message =
                        '{{ __('Please select text first to align') }}';
                    else if (action === 'bold') message =
                        '{{ __('Please select text first to make bold') }}';

                    showTooltip($(this), message);
                    return;
                }

                if (action === 'font') {
                    const fontFamily = $(this).data('font');
                    const range = selection.getRangeAt(0);
                    const span = document.createElement('span');
                    span.style.fontFamily = fontFamily;
                    span.style.whiteSpace = 'pre-wrap'; // Preserve spaces in formatted text
                    span.className = 'font-' + fontFamily.toLowerCase().replace(/\s+/g, '');

                    try {
                        range.surroundContents(span);
                    } catch (e) {
                        const contents = range.extractContents();
                        span.appendChild(contents);
                        range.insertNode(span);
                    }

                    selection.removeAllRanges();
                    selection.addRange(range);

                } else if (['alignLeft', 'alignCenter', 'alignRight'].includes(action)) {
                    let alignValue = 'left';
                    if (action === 'alignCenter') alignValue = 'center';
                    else if (action === 'alignRight') alignValue = 'right';

                    const range = selection.getRangeAt(0);
                    const div = document.createElement('div');
                    div.style.textAlign = alignValue;
                    div.style.whiteSpace = 'pre-wrap'; // Preserve spaces in aligned text

                    try {
                        range.surroundContents(div);
                    } catch (e) {
                        const contents = range.extractContents();
                        div.appendChild(contents);
                        range.insertNode(div);
                    }

                    selection.removeAllRanges();

                } else if (action === 'bold') {
                    document.execCommand('bold', false, null);

                } else if (action === 'abbr') {
                    const selectedRange = selection.getRangeAt(0);
                    const selectedContent = selectedRange.cloneContents();

                    const tempDiv = document.createElement('div');
                    tempDiv.appendChild(selectedContent);
                    const selectedHTML = tempDiv.innerHTML;

                    const title = prompt('{{ __('Enter abbreviation meaning:') }}');
                    if (title) {
                        const range = selection.getRangeAt(0);
                        const abbr = document.createElement('abbr');
                        abbr.setAttribute('data-meaning', title);
                        abbr.setAttribute('data-tooltip', selectedHTML);
                        abbr.title = '';
                        abbr.style.whiteSpace = 'pre-wrap'; // Preserve spaces in abbreviations

                        try {
                            range.surroundContents(abbr);
                        } catch (e) {
                            const contents = range.extractContents();
                            abbr.appendChild(contents);
                            range.insertNode(abbr);
                        }

                        selection.removeAllRanges();
                        setupCustomTooltips();
                    }
                }

                // Sync content after toolbar action
                setTimeout(() => {
                    $('#' + target).val($richEditor.html());
                }, 10);

                $(this).addClass('active');
                setTimeout(() => {
                    $(this).removeClass('active');
                }, 300);
            });

            // Setup custom tooltips
            function setupCustomTooltips() {
                $('.rich-text-editor abbr').off('mouseenter mouseleave');

                $('.rich-text-editor abbr').on('mouseenter', function(e) {
                    const meaning = $(this).attr('data-meaning');
                    const tooltipContent = $(this).attr('data-tooltip');

                    if (meaning) {
                        const formattedTooltip = '<div><strong>Text:</strong> ' + tooltipContent +
                            '</div><div><strong>Meaning:</strong> ' + meaning + '</div>';
                        showCustomTooltip(this, formattedTooltip);
                    }
                });

                $('.rich-text-editor abbr').on('mouseleave', function(e) {
                    hideCustomTooltip();
                });
            }

            // Tooltip function
            function showTooltip(element, message) {
                const tooltip = $('<div class="toolbar-tooltip">' + message + '</div>');
                $('body').append(tooltip);

                const offset = element.offset();
                tooltip.css({
                    top: offset.top - 35,
                    left: offset.left + (element.outerWidth() / 2) - (tooltip.outerWidth() / 2)
                });

                setTimeout(() => {
                    tooltip.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 2000);
            }

            // Initialize rich editors
            initializeRichEditor('lyrics_gu');
            initializeRichEditor('lyrics_en');

            setTimeout(() => {
                setupCustomTooltips();
            }, 500);

            // FIXED: Enhanced form validation with proper sync
            $('.vachanamrut-form').on('submit', function(e) {
                // Force sync all editors before validation
                $('.rich-text-editor').each(function() {
                    const target = $(this).data('target');
                    const htmlContent = $(this).html();
                    $('#' + target).val(htmlContent);
                });

                if (!validateForm()) {
                    e.preventDefault();

                    // Scroll to first error
                    const firstError = $('.is-invalid, .is-invalid-editor').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }

                    if (typeof toastr !== 'undefined') {
                        toastr.error('{{ __('Please fill in all required fields.') }}',
                        'Validation Error');
                    } else {
                        alert('{{ __('Please fill in all required fields.') }}');
                    }
                    return false;
                }
            });

            // Real-time validation
            $('.form-control[required], .rich-text-editor').on('input blur', function() {
                if ($(this).hasClass('rich-text-editor')) {
                    const target = $(this).data('target');
                    const hiddenField = $('#' + target);

                    // Check actual text content, not HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = $(this).html();
                    const textContent = tempDiv.textContent || tempDiv.innerText || '';

                    if (textContent.trim()) {
                        hiddenField.removeClass('is-invalid');
                        $(this).removeClass('is-invalid-editor');
                    } else if (hiddenField.attr('required')) {
                        hiddenField.addClass('is-invalid');
                        $(this).addClass('is-invalid-editor');
                    }
                } else {
                    if ($(this).val().trim()) {
                        $(this).removeClass('is-invalid');
                    } else if ($(this).attr('required')) {
                        $(this).addClass('is-invalid');
                    }
                }
            });

            // Focus on song code by default
            setTimeout(function() {
                $('#song_code').focus();
            }, 100);
        });

        // Form validation function - FIXED VERSION
        function validateForm() {
            let isValid = true;

            // Validate text inputs
            $('.form-control[required]').each(function() {
                if (!$(this).val().trim()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validate rich text editors
            $('.rich-text-editor').each(function() {
                const target = $(this).data('target');
                const hiddenField = $('#' + target);

                if (hiddenField.attr('required')) {
                    // Check actual text content
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = $(this).html();
                    const textContent = tempDiv.textContent || tempDiv.innerText || '';

                    if (!textContent.trim()) {
                        hiddenField.addClass('is-invalid');
                        $(this).addClass('is-invalid-editor');
                        isValid = false;
                    } else {
                        hiddenField.removeClass('is-invalid');
                        $(this).removeClass('is-invalid-editor');
                    }
                }
            });

            return isValid;
        }
    </script>
@endsection
