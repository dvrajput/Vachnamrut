@extends('admin.layouts.app')
@section('title', __('Show') . ' - ' . $category->{'category_' . app()->getLocale()})

@section('style')
    <style>
        /* Category Show Container */
        .category-show-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Category Header */
        .category-header {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            color: white;
            box-shadow: var(--admin-shadow-sm);
        }

        .header-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        .back-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            transform: translateX(-3px);
        }

        .category-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 10px 0 0 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .category-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .songs-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .btn-create-subcategory {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(45deg, #ffffff, #f8f9fa);
            color: var(--admin-primary);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-create-subcategory:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: var(--admin-primary-dark);
            text-decoration: none;
        }

        /* Table Container */
        .songs-table-container {
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .table-stats {
            color: var(--admin-text-secondary);
            font-size: 0.9rem;
        }

        /* Enhanced DataTables Styling */
        .table-responsive {
            padding: 25px;
            background: var(--admin-bg-secondary);
        }

        #categorySongTable {
            width: 100% !important;
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        #categorySongTable thead th {
            background: var(--admin-primary) !important;
            color: white !important;
            font-weight: 600;
            padding: 15px 12px;
            text-align: center;
            border: none;
            font-size: 0.9rem;
        }

        #categorySongTable tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--admin-border-color);
            color: var(--admin-text-primary) !important;
            text-align: center;
            vertical-align: middle;
            background: var(--admin-bg-secondary) !important;
        }

        #categorySongTable tbody tr:hover {
            background: var(--admin-primary-bg) !important;
        }

        /* Song Code Styling */
        .song-code {
            background: var(--admin-primary-bg);
            color: var(--admin-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid var(--admin-primary);
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
            width: 200px !important;
            margin-left: -100px !important;
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
            .category-show-container {
                padding: 15px;
            }

            .category-header {
                padding: 20px;
            }

            .header-navigation {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .category-title {
                font-size: 1.4rem;
            }

            .category-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 15px;
            }

            .table-responsive {
                padding: 15px;
                overflow-x: auto;
            }

            #categorySongTable {
                font-size: 0.8rem;
            }

            #categorySongTable thead th,
            #categorySongTable tbody td {
                padding: 10px 8px;
            }

            .action-btn {
                padding: 6px 8px;
                font-size: 0.75rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="category-show-container">
        <!-- Category Header -->
        <div class="category-header">
            <div class="header-navigation">
                <div>
                    <a href="{{ route('admin.categories.index') }}" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('Back to Categories') }}
                    </a>
                    <h3 class="category-title">
                        <i class="fas fa-folder-open"></i>
                        {{ $category->{'category_' . app()->getLocale()} }}
                    </h3>
                    <div class="category-info">
                        <span class="songs-count" id="songsCount">
                            <i class="fas fa-music"></i>
                            {{ __('Loading songs...') }}
                        </span>
                        <span>{{ __('Category Code') }}: <strong>{{ $category->category_code }}</strong></span>
                    </div>
                </div>
                <a href="{{ route('admin.subCategories.create') }}" class="btn-create-subcategory">
                    <i class="fas fa-plus"></i>
                    {{ __('Create Sub Category') }}
                </a>
            </div>
        </div>

        <!-- Songs Table -->
        <div class="songs-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="fas fa-list"></i>
                    {{ __('Songs in this Category') }}
                </h4>
                <div class="table-stats" id="tableStats"></div>
            </div>

            <div class="table-responsive">
                <table id="categorySongTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('Song Code') }}</th>
                            <th>{{ __('English Title') }}</th>
                            <th>{{ __('Gujarati Title') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const categoryCode = "{{ $category->category_code }}";

            // Configuration
            const config = {
                ajaxUrl: '{{ route('admin.categories.show', $category->category_code) }}',
                songViewUrl: '{{ url('admin/songs') }}',
                songEditUrl: '{{ url('admin/songs') }}',
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

                showNotification('Error loading songs. Please refresh the page.', 'error');
                updateSongsCount(0);
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

            // Update songs count in header
            function updateSongsCount(count) {
                $('#songsCount').html(`<i class="fas fa-music"></i> ${count} {{ __('Songs') }}`);
            }

            // Update table stats
            function updateTableStats(info) {
                if (info.recordsTotal > 0) {
                    $('#tableStats').text(`{{ __('Total') }}: ${info.recordsTotal} {{ __('songs') }}`);
                } else {
                    $('#tableStats').text('{{ __('No songs found') }}');
                }
            }

            // Render action buttons
            function renderActionButtons(data, type, row) {
                if (type !== 'display') {
                    return '';
                }

                return `
            <div class="btn-group" role="group" aria-label="Actions">
                <a href="${config.songViewUrl}/${row.song_code}" 
                   class="btn btn-sm btn-info action-btn" 
                   data-bs-toggle="tooltip" 
                   title="{{ __('View Song') }}">
                    <i class="fas fa-eye"></i>
                    {{ __('View') }}
                </a>
                <a href="${config.songEditUrl}/${row.song_code}/edit" 
                   class="btn btn-sm btn-warning action-btn" 
                   data-bs-toggle="tooltip" 
                   title="{{ __('Edit Song') }}">
                    <i class="fas fa-edit"></i>
                    {{ __('Edit') }}
                </a>
            </div>
        `;
            }

            // Truncate text function
            function truncateText(text, maxLength = 40) {
                if (!text || text.trim() === '') {
                    return '<span class="text-muted">—</span>';
                }

                const truncated = text.length > maxLength ? text.substr(0, maxLength) + '...' : text;
                return `<span class="text-truncate" title="${text}">${truncated}</span>`;
            }

            // Initialize DataTable
            const table = $('#categorySongTable').DataTable({
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
                        data: 'song_code',
                        name: 'song_code',
                        orderable: true,
                        width: '15%',
                        render: function(data, type, row) {
                            return data ? `<code class="song-code">${data}</code>` :
                                '<span class="text-muted">—</span>';
                        }
                    },
                    {
                        data: 'title_en',
                        name: 'title_en',
                        orderable: true,
                        width: '30%',
                        render: function(data, type, row) {
                            return truncateText(data, 50);
                        }
                    },
                    {
                        data: 'title_gu',
                        name: 'title_gu',
                        orderable: false,
                        width: '30%',
                        render: function(data, type, row) {
                            if (!data || data.trim() === '') {
                                return '<span class="text-muted">—</span>';
                            }
                            const truncated = data.length > 50 ? data.substr(0, 50) + '...' : data;
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
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> {{ __('CSV') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> {{ __('Excel') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [0, 1, 2]
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
                            doc.content[1].table.widths = ['20%', '40%', '40%'];
                            doc.styles.tableHeader.fillColor = '#d7861b';
                        }
                    }
                ],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> {{ __('Loading songs...') }}',
                    search: "{{ __('Search songs') }}:",
                    lengthMenu: "{{ __('Show _MENU_ songs') }}",
                    info: "{{ __('Showing _START_ to _END_ of _TOTAL_ songs') }}",
                    infoEmpty: "{{ __('Showing 0 to 0 of 0 songs') }}",
                    infoFiltered: "({{ __('filtered from _MAX_ total songs') }})",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    },
                    emptyTable: "{{ __('No songs found in this category') }}",
                    zeroRecords: "{{ __('No matching songs found') }}"
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
                drawCallback: function(settings) {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                initComplete: function(settings, json) {
                    console.log('Category songs DataTable initialized successfully');
                    if (json && json.success) {
                        updateSongsCount(json.recordsTotal || 0);
                        updateTableStats(json);
                    } else if (json && !json.success) {
                        showNotification('Warning: ' + (json.error || 'Unknown error occurred'),
                            'warning');
                        updateSongsCount(0);
                    }
                },
                infoCallback: function(settings, start, end, max, total, pre) {
                    updateTableStats({
                        recordsTotal: total
                    });
                    return pre;
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
        });
    </script>
@endsection
