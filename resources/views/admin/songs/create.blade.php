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
                <div class="form-group">
                    <label for="song_code" class="form-label required">{{ __('Code') }}</label>
                    <input type="text" class="form-control" id="song_code" name="song_code"
                        placeholder="{{ __('e.g., 1, 2, 3, etc.') }}" required>
                    <small class="form-text text-muted">{{ __('Enter unique identifier') }}</small>
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
                            <input type="text" class="form-control gujarati-text" id="title_gu" name="title_gu"
                                placeholder="{{ __('વચનામૃતનું શીર્ષક લખો') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="lyrics_gu" class="form-label required">{{ __('Gujarati Content') }}</label>
                            <textarea class="form-control gujarati-text content-textarea" id="lyrics_gu" name="lyrics_gu" 
                                rows="15" placeholder="{{ __('વચનામૃતનું મૂળ લખાણ લખો...') }}" 
                                required></textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                {{ __('Use HTML: <abbr title="Full Form">Short Form</abbr> for abbreviations') }}
                            </small>
                        </div>
                    </div>

                    <!-- English Tab -->
                    <div class="tab-content" id="english-tab">
                        <div class="form-group">
                            <label for="title_en" class="form-label">{{ __('English Title') }}</label>
                            <input type="text" class="form-control" id="title_en" name="title_en"
                                placeholder="{{ __('English title (optional)') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="lyrics_en" class="form-label">{{ __('English Content') }}</label>
                            <textarea class="form-control content-textarea @error('lyrics_en') is-invalid @enderror" 
                                id="lyrics_en" name="lyrics_en" rows="15"
                                placeholder="{{ __('English translation (optional)') }}"></textarea>
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
                    <label for="category_code" class="form-label">{{ __('Categories') }}</label>
                    <select class="form-control select2" id="category_code" name="category_code[]" 
                        multiple="multiple" data-placeholder="{{ __('Select categories') }}">
                        @foreach ($categories as $scategory)
                            <option value="{{ $scategory->category_code }}">
                                {{ $scategory->category_en }} ({{ $scategory->category_gu }})
                            </option>
                        @endforeach
                    </select>
                    @error('category_code')
                        <div class="invalid-feedback">{{ $message }}</div>
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
@endsection

@section('style')
<style>
/* Container with proper navbar spacing */
.vachanamrut-admin-container {
    max-width: 1000px;
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

/* FIXED: Dropdown Arrow */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px;
}

[data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: var(--admin-text-muted) transparent transparent transparent;
}

/* FIXED: Clear Button */
[data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__clear {
    color: var(--admin-text-muted) !important;
}

[data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__clear:hover {
    color: var(--admin-error) !important;
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

    // Initialize Select2 on page load
    initializeSelect2();

    // Reinitialize Select2 when theme changes
    window.addEventListener('themeChanged', function(e) {
        setTimeout(function() {
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
        
        // Focus on first input in active tab
        $('#' + tabId + '-tab').find('input, textarea').first().focus();
    });

    // Auto-resize all textareas and set minimum heights
    $('.content-textarea').each(function() {
        autoResizeTextarea(this);
        $(this).on('input', function() {
            autoResizeTextarea(this);
        });
    });

    // Focus on Gujarati title by default (since Gujarati tab is active)
    setTimeout(function() {
        $('#title_gu').focus();
    }, 100);

    // Enhanced form validation
    $('.vachanamrut-form').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            toastr.error('{{ __('Please fill in all required fields.') }}', 'Validation Error');
            return false;
        }
    });

    // Real-time validation feedback
    $('.form-control[required]').on('input blur', function() {
        if ($(this).val().trim()) {
            $(this).removeClass('is-invalid');
        } else {
            $(this).addClass('is-invalid');
        }
    });
});

// Enhanced auto-resize function
function autoResizeTextarea(textarea) {
    if (textarea) {
        const minHeight = textarea.classList.contains('content-textarea') ? 300 : 120;
        textarea.style.height = 'auto';
        const newHeight = Math.max(textarea.scrollHeight, minHeight);
        textarea.style.height = newHeight + 'px';
    }
}

// Form validation function
function validateForm() {
    let isValid = true;
    const requiredFields = $('.form-control[required]');
    
    requiredFields.each(function() {
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
