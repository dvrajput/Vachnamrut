@extends('admin.layouts.app')
@section('title', __('Configuration Management'))

@section('style')
    <style>
        /* Configuration Container */
        .config-container {
            max-width: 1400px;
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

        .header-content h3.page-title {
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
        .btn-create-config {
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

        .btn-create-config:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: var(--admin-primary-dark);
            text-decoration: none;
        }

        .btn-create-config .btn-icon {
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

        .btn-create-config:hover .btn-icon {
            background: var(--admin-primary-dark);
            transform: rotate(90deg);
        }

        /* Access Denied Alert */
        .access-denied-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }

        .alert-access-denied {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--admin-shadow-sm);
        }

        .alert-access-denied h4 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .alert-access-denied p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
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

        #configTable {
            width: 100% !important;
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        #configTable thead th {
            background: var(--admin-primary) !important;
            color: white !important;
            font-weight: 600;
            padding: 15px 12px;
            text-align: center;
            border: none;
            font-size: 0.9rem;
            position: relative;
        }

        #configTable tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--admin-border-color);
            color: var(--admin-text-primary) !important;
            text-align: center;
            vertical-align: middle;
            background: var(--admin-bg-secondary) !important;
        }

        #configTable tbody tr:hover {
            background: var(--admin-primary-bg) !important;
        }

        /* Configuration Key Styling */
        .config-key {
            background: var(--admin-primary-bg);
            color: var(--admin-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid var(--admin-primary);
        }

        /* Configuration Value Styling */
        .config-value {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            padding: 4px 8px;
            background: var(--admin-bg-tertiary);
            border-radius: 4px;
            border: 1px solid var(--admin-border-color);
        }

        .config-value.boolean {
            font-weight: 600;
            text-transform: uppercase;
        }

        .config-value.boolean.true {
            color: #28a745;
            background: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
        }

        .config-value.boolean.false {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }

        /* Action Buttons */
        .action-btn {
            padding: 8px 12px;
            font-size: 0.85rem;
            border-radius: 6px;
            margin: 0 2px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
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

        /* DataTables Controls */
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

        /* Processing Indicator */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .config-container {
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

            .btn-create-config {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .table-responsive {
                padding: 15px;
                overflow-x: auto;
            }

            #configTable {
                font-size: 0.8rem;
            }

            #configTable thead th,
            #configTable tbody td {
                padding: 10px 8px;
            }

            .action-btn {
                padding: 6px 8px;
                font-size: 0.75rem;
            }

            .config-key,
            .config-value {
                font-size: 0.75rem;
                padding: 2px 6px;
            }
        }

        @media (max-width: 480px) {
            .access-denied-container {
                margin: 30px auto;
                padding: 0 15px;
            }

            .alert-access-denied {
                padding: 20px;
            }

            .page-header {
                padding: 15px;
            }

            .page-title {
                font-size: 1.3rem;
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $user = Auth::user();
        $isAdmin = $user && $user->role === 'admin';
    @endphp

    @if ($isAdmin)
        <div class="config-container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-content">
                    <h3 class="page-title">
                        <i class="fas fa-cogs"></i>
                        {{ __('Configuration Management') }}
                    </h3>
                    <p class="page-subtitle">{{ __('Manage system configurations and settings') }}</p>
                </div>
                <a href="{{ route('admin.config.create') }}" class="btn-create-config">
                    <span class="btn-icon">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="btn-text">{{ __('Create Config') }}</span>
                </a>
            </div>

            <!-- Configuration Table -->
            <div class="table-container">
                <div class="table-header">
                    <h4 class="table-title">
                        <i class="fas fa-list"></i>
                        {{ __('All Configurations') }}
                    </h4>
                </div>

                <div class="table-responsive">
                    <table id="configTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Key') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="access-denied-container">
            <div class="alert alert-access-denied">
                <h4>
                    <i class="fas fa-shield-alt"></i>
                    {{ __('Access Denied') }}
                </h4>
                <p>{{ __('You do not have permission to access configuration management. Please contact an administrator.') }}
                </p>
            </div>
        </div>
    @endif
@endsection

@section('script')
    @if ($isAdmin)
        <script>
            $(document).ready(function() {
                // Configuration
                const config = {
                    ajaxUrl: '{{ route('admin.config.index') }}',
                    editUrl: '{{ url('admin/config') }}',
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

                    showNotification('Error loading configurations. Please refresh the page.', 'error');
                }

                // Notification function
                function showNotification(message, type = 'info') {
                    const toast = $(`
            <div class="alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type === 'error' ? 'Error!' : 'Info!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                    $('body').append(toast);
                    setTimeout(() => toast.fadeOut(() => toast.remove()), 5000);
                }

                // Render configuration value with appropriate styling
                function renderConfigValue(data, type, row) {
                    if (type !== 'display' || !data) {
                        return data || '';
                    }

                    // Check if value is boolean-like
                    if (data === '0' || data === '1' || data === 'true' || data === 'false') {
                        const isTrue = data === '1' || data === 'true';
                        return `<span class="config-value boolean ${isTrue ? 'true' : 'false'}">${isTrue ? 'TRUE' : 'FALSE'}</span>`;
                    }

                    // Regular value
                    const truncated = data.length > 30 ? data.substr(0, 30) + '...' : data;
                    return `<span class="config-value" title="${data}">${truncated}</span>`;
                }

                // Render action buttons
                function renderActionButtons(data, type, row) {
                    if (type !== 'display') {
                        return '';
                    }

                    return `
            <div class="btn-group" role="group" aria-label="Actions">
                <a href="${config.editUrl}/${row.id}/edit" 
                   class="btn btn-sm btn-warning action-btn" 
                   data-bs-toggle="tooltip" 
                   title="{{ __('Edit Configuration') }}">
                    <i class="fas fa-edit"></i>
                    {{ __('Edit') }}
                </a>
            </div>
        `;
                }

                // Truncate text function
                function truncateText(text, maxLength = 50) {
                    if (!text || text.trim() === '') {
                        return '<span class="text-muted">—</span>';
                    }

                    const truncated = text.length > maxLength ? text.substr(0, maxLength) + '...' : text;
                    return `<span class="text-truncate" title="${text}">${truncated}</span>`;
                }

                // Initialize DataTable
                const table = $('#configTable').DataTable({
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
                            data: 'id',
                            name: 'id',
                            orderable: true,
                            width: '10%',
                            render: function(data, type, row) {
                                return `<span class="badge badge-secondary">#${data}</span>`;
                            }
                        },
                        {
                            data: 'key',
                            name: 'key',
                            orderable: true,
                            width: '25%',
                            render: function(data, type, row) {
                                return data ? `<code class="config-key">${data}</code>` :
                                    '<span class="text-muted">—</span>';
                            }
                        },
                        {
                            data: 'value',
                            name: 'value',
                            orderable: false,
                            width: '20%',
                            render: renderConfigValue
                        },
                        {
                            data: 'message',
                            name: 'message',
                            orderable: false,
                            width: '30%',
                            render: function(data, type, row) {
                                return truncateText(data, 60);
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: '15%',
                            render: renderActionButtons
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i> {{ __('Copy') }}',
                            className: 'dt-button',
                            exportOptions: {
                                columns: [0, 1, 2, 3]
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fas fa-file-csv"></i> {{ __('CSV') }}',
                            className: 'dt-button',
                            exportOptions: {
                                columns: [0, 1, 2, 3]
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> {{ __('Excel') }}',
                            className: 'dt-button',
                            exportOptions: {
                                columns: [0, 1, 2, 3]
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i> {{ __('PDF') }}',
                            className: 'dt-button',
                            exportOptions: {
                                columns: [0, 1, 2, 3]
                            },
                            customize: function(doc) {
                                doc.content[1].table.widths = ['15%', '30%', '25%', '30%'];
                                doc.styles.tableHeader.fillColor = '#d7861b';
                            }
                        }
                    ],
                    language: {
                        processing: '<i class="fas fa-spinner fa-spin"></i> {{ __('Loading configurations...') }}',
                        search: "{{ __('Search configurations') }}:",
                        lengthMenu: "{{ __('Show _MENU_ configurations') }}",
                        info: "{{ __('Showing _START_ to _END_ of _TOTAL_ configurations') }}",
                        infoEmpty: "{{ __('Showing 0 to 0 of 0 configurations') }}",
                        infoFiltered: "({{ __('filtered from _MAX_ total configurations') }})",
                        paginate: {
                            first: "{{ __('First') }}",
                            last: "{{ __('Last') }}",
                            next: "{{ __('Next') }}",
                            previous: "{{ __('Previous') }}"
                        },
                        emptyTable: "{{ __('No configurations available') }}",
                        zeroRecords: "{{ __('No matching configurations found') }}"
                    },
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "{{ __('All') }}"]
                    ],
                    responsive: true,
                    order: [
                        [0, 'asc']
                    ],
                    searchDelay: 500,
                    stateSave: true,
                    drawCallback: function(settings) {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    },
                    initComplete: function(settings, json) {
                        console.log('Configuration DataTable initialized successfully');
                        if (json && !json.success) {
                            showNotification('Warning: ' + (json.error || 'Unknown error occurred'),
                                'warning');
                        }
                    }
                });

                // Theme change handler
                window.addEventListener('themeChanged', function(e) {
                    setTimeout(function() {
                        table.draw(false);
                    }, 100);
                });

                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Auto-refresh table every 10 minutes (optional, since configs don't change frequently)
                setInterval(function() {
                    if (document.visibilityState === 'visible') {
                        table.ajax.reload(null, false);
                    }
                }, 600000); // 10 minutes
            });
        </script>
    @endif
@endsection