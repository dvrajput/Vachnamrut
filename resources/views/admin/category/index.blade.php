@extends('admin.layouts.app')
@section('title', __('Category Management'))

@section('content')
    <div class="admin-index-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h2 class="page-title">
                    <i class="fas fa-folder"></i>
                    {{ __('Category Management') }}
                </h2>
                <p class="page-subtitle">{{ __('Manage and organize all categories') }}</p>
            </div>
            @if ($createBtnShow == '1')
                <div class="header-actions">
                    <a href="{{ route('admin.categories.create') }}" class="btn-create-new">
                        <span class="btn-icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="btn-text">{{ __('Create Category') }}</span>
                        <span class="btn-shine"></span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Data Table Section -->
        <div class="table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="fas fa-list"></i>
                    {{ __('All Categories') }}
                </h4>
            </div>

            <div class="table-responsive">
                <table id="userTable" class="admin-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('English Category') }}</th>
                            <th>{{ __('Gujarati Category') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        /* Admin Index Container */
        .admin-index-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            color: white;
            box-shadow: var(--admin-shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-content h2.page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-content .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Modern Create Button */
        .btn-create-new {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(45deg, #ffffff, #f8f9fa);
            color: var(--admin-primary);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .btn-create-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: var(--admin-primary-dark);
            text-decoration: none;
        }

        .btn-create-new .btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: var(--admin-primary);
            color: white;
            border-radius: 50%;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-create-new:hover .btn-icon {
            background: var(--admin-primary-dark);
            transform: rotate(90deg);
        }

        .btn-create-new .btn-text {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Shine effect */
        .btn-create-new .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-create-new:hover .btn-shine {
            left: 100%;
        }

        /* Table Container */
        .table-container {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 12px;
            box-shadow: var(--admin-shadow-sm);
            overflow: hidden;
        }

        .table-header {
            background: var(--admin-bg-tertiary);
            padding: 20px 25px;
            border-bottom: 1px solid var(--admin-border-color);
        }

        .table-title {
            color: var(--admin-text-primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-title i {
            color: var(--admin-primary);
        }

        /* Enhanced DataTables Styling */
        .table-responsive {
            padding: 25px;
            background: var(--admin-bg-secondary);
        }

        .admin-table {
            width: 100% !important;
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .admin-table thead th {
            background: var(--admin-primary) !important;
            color: white !important;
            font-weight: 600;
            padding: 15px 12px;
            text-align: center;
            border: none;
            font-size: 0.9rem;
            position: relative;
        }

        /* Hide sorting arrows */
        .admin-table thead th.sorting:before,
        .admin-table thead th.sorting:after,
        .admin-table thead th.sorting_asc:before,
        .admin-table thead th.sorting_asc:after,
        .admin-table thead th.sorting_desc:before,
        .admin-table thead th.sorting_desc:after {
            display: none !important;
        }

        .admin-table tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--admin-border-color);
            color: var(--admin-text-primary) !important;
            text-align: center;
            vertical-align: middle;
            background: var(--admin-bg-secondary) !important;
        }

        .admin-table tbody tr:hover {
            background: var(--admin-primary-bg) !important;
        }

        /* Action Buttons */
        .btn-sm {
            padding: 6px 10px;
            font-size: 0.8rem;
            border-radius: 6px;
            margin: 0 2px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-info {
            background: var(--admin-info);
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-warning {
            background: var(--admin-warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: var(--admin-error);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        /* DataTables Controls Styling */
        .dataTables_wrapper {
            color: var(--admin-text-primary) !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--admin-text-primary) !important;
            margin: 10px 0;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            border-radius: 6px;
            padding: 6px 10px;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--admin-primary) !important;
            box-shadow: 0 0 0 3px rgba(215, 134, 27, 0.1) !important;
        }

        /* Pagination Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: var(--admin-bg-secondary) !important;
            border: 1px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--admin-primary-bg) !important;
            border-color: var(--admin-primary) !important;
            color: var(--admin-primary) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--admin-primary) !important;
            border-color: var(--admin-primary) !important;
            color: white !important;
        }

        /* DataTables Buttons - REMOVED Excel and CSV */
        .dt-buttons {
            margin-bottom: 15px;
        }

        .dt-button {
            background: var(--admin-bg-tertiary) !important;
            border: 2px solid var(--admin-border-color) !important;
            color: var(--admin-text-primary) !important;
            padding: 8px 16px;
            border-radius: 6px;
            margin: 0 4px 4px 0;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .dt-button:hover {
            background: var(--admin-primary) !important;
            border-color: var(--admin-primary) !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: var(--admin-shadow-sm);
        }

        /* Dark Mode DataTables Overrides */
        [data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: var(--admin-bg-tertiary) !important;
            color: var(--admin-text-primary) !important;
        }

        [data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--admin-primary-bg) !important;
            color: var(--admin-primary) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-index-container {
                padding: 15px;
            }

            .page-header {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .page-title {
                font-size: 1.5rem;
                justify-content: center;
            }

            .btn-create-new {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .table-responsive {
                padding: 15px;
                overflow-x: auto;
            }

            .admin-table {
                font-size: 0.8rem;
            }

            .admin-table thead th,
            .admin-table tbody td {
                padding: 10px 8px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
                margin: 1px;
            }

            .dt-buttons {
                text-align: center;
            }

            .dt-button {
                display: inline-block;
                margin: 2px;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                padding: 15px;
            }

            .page-title {
                font-size: 1.3rem;
                flex-direction: column;
                gap: 8px;
            }

            .table-header {
                padding: 15px;
            }

            .table-responsive {
                padding: 10px;
            }
        }

        /* Loading and Processing States */
        .dataTables_processing {
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border: 1px solid var(--admin-border-color) !important;
            border-radius: 8px;
        }
    </style>
    <style>
        /* Enhanced category code styling */
        .category-code {
            background: var(--admin-primary-bg);
            color: var(--admin-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid var(--admin-primary);
        }

        /* Enhanced Gujarati text styling */
        .gujarati-text {
            font-family: 'Noto Sans Gujarati', 'Shruti', sans-serif;
            font-size: 1.1em;
            line-height: 1.4;
        }

        /* Enhanced action buttons */
        .action-btn {
            transition: all 0.3s ease;
            min-width: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Enhanced processing indicator */
        .dataTables_processing {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 250px !important;
            margin-left: -125px !important;
            margin-top: -25px !important;
            text-align: center !important;
            background: var(--admin-bg-secondary) !important;
            border: 2px solid var(--admin-primary) !important;
            border-radius: 8px !important;
            padding: 15px !important;
            font-size: 16px !important;
            box-shadow: var(--admin-shadow-sm) !important;
        }

        /* Toast notifications positioning */
        .position-fixed {
            position: fixed !important;
        }

        /* Enhanced tooltips */
        .tooltip {
            font-size: 0.8rem;
            z-index: 10000;
        }

        .tooltip-inner {
            background: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
            border: 1px solid var(--admin-border-color);
            max-width: 200px;
        }

        /* Button group improvements */
        .btn-group .btn {
            border-radius: 6px !important;
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Table state indicators */
        .dataTables_wrapper .dataTables_info {
            color: var(--admin-text-secondary);
            font-size: 0.9rem;
        }

        /* Enhanced search box */
        .dataTables_wrapper .dataTables_filter input {
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            transform: scale(1.02);
        }

        /* Loading spinner animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Mobile enhancements */
        @media (max-width: 768px) {
            .category-code {
                font-size: 0.75rem;
                padding: 2px 6px;
            }

            .gujarati-text {
                font-size: 1em;
            }

            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 2px;
            }

            .action-btn {
                min-width: 28px;
                padding: 4px 6px;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const deleteBtn = @json($deleteBtn);

            // Configuration
            const config = {
                ajaxUrl: '{{ route('admin.categories.index') }}',
                editUrl: '{{ url('admin/categories') }}',
                deleteUrl: '{{ route('admin.categories.destroy', '') }}',
                showUrl: '{{ url('admin/categories') }}',
                csrfToken: '{{ csrf_token() }}'
            };

            // Enhanced error handling function
            function handleAjaxError(xhr, error, thrown) {
                console.error('DataTables AJAX Error:', {
                    status: xhr.status,
                    error: error,
                    thrown: thrown,
                    responseText: xhr.responseText
                });

                showNotification('Error loading categories. Please refresh the page.', 'error');
            }

            // Notification function
            function showNotification(message, type = 'info') {
                // Create a toast notification
                const toast = $(`
            <div class="alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type === 'error' ? 'Error!' : 'Info!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                $('body').append(toast);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.fadeOut(() => toast.remove());
                }, 5000);
            }

            // Render action buttons
            function renderActionButtons(data, type, row) {
                if (type !== 'display') {
                    return '';
                }

                let actionHtml = `
            <div class="btn-group" role="group" aria-label="Actions">
                <a href="${config.showUrl}/${row.category_code}" 
                   class="btn btn-sm btn-info action-btn" 
                   data-bs-toggle="tooltip" 
                   title="{{ __('View Category') }}">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="${config.editUrl}/${row.category_code}/edit" 
                   class="btn btn-sm btn-warning action-btn" 
                   data-bs-toggle="tooltip" 
                   title="{{ __('Edit Category') }}">
                    <i class="fas fa-edit"></i>
                </a>
        `;

                // Conditionally add delete button
                if (deleteBtn === '1') {
                    actionHtml += `
                <button type="button" 
                        class="btn btn-sm btn-danger action-btn delete-btn" 
                        data-category-code="${row.category_code}"
                        data-category-name="${row.category_en || row.category_gu || 'Unknown'}"
                        data-bs-toggle="tooltip" 
                        title="{{ __('Delete Category') }}">
                    <i class="fas fa-trash"></i>
                </button>
            `;
                }

                actionHtml += `</div>`;
                return actionHtml;
            }

            // Truncate text function with fallback
            function truncateText(text, maxLength = 30) {
                if (!text || text.trim() === '') {
                    return '<span class="text-muted">—</span>';
                }

                const truncated = text.length > maxLength ? text.substr(0, maxLength) + '...' : text;
                return `<span class="text-truncate" title="${text}">${truncated}</span>`;
            }

            // Initialize DataTable with improved configuration
            const table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: config.ajaxUrl,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    data: function(d) {
                        d._token = config.csrfToken;
                        return d;
                    },
                    error: handleAjaxError,
                    timeout: 30000
                },
                columns: [{
                        data: 'category_code',
                        name: 'category_code',
                        orderable: true,
                        width: '15%',
                        render: function(data, type, row) {
                            return data ? `<code class="category-code">${data}</code>` :
                                '<span class="text-muted">—</span>';
                        }
                    },
                    {
                        data: 'category_en',
                        name: 'category_en',
                        orderable: true,
                        width: '30%',
                        render: function(data, type, row) {
                            return truncateText(data, 35);
                        }
                    },
                    {
                        data: 'category_gu',
                        name: 'category_gu',
                        orderable: true,
                        width: '30%',
                        render: function(data, type, row) {
                            if (!data || data.trim() === '') {
                                return '<span class="text-muted">—</span>';
                            }
                            const truncated = data.length > 35 ? data.substr(0, 35) + '...' : data;
                            return `<span class="gujarati-text text-truncate" title="${data}">${truncated}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%',
                        render: renderActionButtons
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> {{ __('Copy') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [0, 1, 2] // Only export visible columns
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> {{ __('PDF') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        customize: function(doc) {
                            // Customize PDF layout
                            doc.content[1].table.widths = ['20%', '40%', '40%'];
                            doc.styles.tableHeader.fillColor = '#d7861b';
                        }
                    }
                ],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> {{ __('Processing...') }}',
                    search: "{{ __('Search categories') }}:",
                    lengthMenu: "{{ __('Show _MENU_ categories') }}",
                    info: "{{ __('Showing _START_ to _END_ of _TOTAL_ categories') }}",
                    infoEmpty: "{{ __('Showing 0 to 0 of 0 categories') }}",
                    infoFiltered: "({{ __('filtered from _MAX_ total categories') }})",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    },
                    emptyTable: "{{ __('No categories available') }}",
                    zeroRecords: "{{ __('No matching categories found') }}"
                },
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "{{ __('All') }}"]
                ],
                responsive: true,
                order: [
                    [0, 'asc']
                ], // Default sort by category_code
                searchDelay: 500,
                stateSave: true, // Save table state
                drawCallback: function(settings) {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $('.delete-btn').off('click').on('click', handleDeleteClick);
                },
                initComplete: function(settings, json) {
                    console.log('Categories DataTable initialized successfully');
                    if (json && !json.success) {
                        showNotification('Warning: ' + (json.error || 'Unknown error occurred'),
                            'warning');
                    }
                }
            });

            // Enhanced delete handler
            function handleDeleteClick() {
                const categoryCode = $(this).data('category-code');
                const categoryName = $(this).data('category-name');
                const button = $(this);

                // Enhanced confirmation dialog
                const confirmMessage =
                    `{{ __('Are you sure you want to delete category') }} "${categoryCode}"?\n\n` +
                    `{{ __('Category Name') }}: ${categoryName}\n\n` +
                    `{{ __('This action cannot be undone and may affect related songs.') }}`;

                if (confirm(confirmMessage)) {
                    // Disable button and show loading
                    button.prop('disabled', true)
                        .html('<i class="fas fa-spinner fa-spin"></i>')
                        .addClass('btn-loading');

                    // Perform AJAX delete request
                    $.ajax({
                        url: `${config.deleteUrl}/${categoryCode}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        timeout: 15000,
                        success: function(response) {
                            if (response.success) {
                                showNotification(`{{ __('Category deleted successfully') }}`,
                                    'success');
                                table.ajax.reload(null, false); // Reload without resetting pagination
                            } else {
                                showNotification(response.message ||
                                    '{{ __('Error deleting category') }}', 'error');
                                resetDeleteButton(button);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete error:', xhr.responseText);
                            let errorMessage = '{{ __('Error deleting category') }}';

                            if (xhr.status === 422) {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } else if (xhr.status === 404) {
                                errorMessage = '{{ __('Category not found') }}';
                            }

                            showNotification(errorMessage, 'error');
                            resetDeleteButton(button);
                        }
                    });
                }
            }

            // Reset delete button to original state
            function resetDeleteButton(button) {
                button.prop('disabled', false)
                    .html('<i class="fas fa-trash"></i>')
                    .removeClass('btn-loading');
            }

            // Theme change handler
            window.addEventListener('themeChanged', function(e) {
                setTimeout(function() {
                    table.draw(false);
                }, 100);
            });

            // Global error handler
            $(document).ajaxError(function(event, xhr, settings, thrownError) {
                if (settings.url === config.ajaxUrl) {
                    handleAjaxError(xhr, 'ajaxError', thrownError);
                }
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Auto-refresh table every 5 minutes (optional)
            setInterval(function() {
                if (document.visibilityState === 'visible') {
                    table.ajax.reload(null, false);
                }
            }, 300000); // 5 minutes
        });
    </script>
@endsection
