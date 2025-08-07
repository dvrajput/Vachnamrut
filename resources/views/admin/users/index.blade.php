@extends('admin.layouts.app')
@section('title', __('User Management'))

@section('style')
    <style>
        /* User Management Container */
        .user-container {
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
        .btn-create-user {
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

        .btn-create-user:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: var(--admin-primary-dark);
            text-decoration: none;
        }

        .btn-create-user .btn-icon {
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

        .btn-create-user:hover .btn-icon {
            background: var(--admin-primary-dark);
            transform: rotate(90deg);
        }

        /* User Stats */
        .user-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 8px;
            padding: 20px;
            flex: 1;
            min-width: 200px;
            text-align: center;
            box-shadow: var(--admin-shadow-sm);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--admin-primary);
        }

        .stat-label {
            color: var(--admin-text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        #usersTable {
            width: 100% !important;
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        #usersTable thead th {
            background: var(--admin-primary) !important;
            color: white !important;
            font-weight: 600;
            padding: 15px 12px;
            text-align: center;
            border: none;
            font-size: 0.9rem;
        }

        #usersTable tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--admin-border-color);
            color: var(--admin-text-primary) !important;
            text-align: center;
            vertical-align: middle;
            background: var(--admin-bg-secondary) !important;
        }

        #usersTable tbody tr:hover {
            background: var(--admin-primary-bg) !important;
        }

        /* User Role Badges */
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin {
            background: rgba(220, 53, 69, 0.2);
            color: #721c24;
            border: 1px solid #dc3545;
        }

        .role-editor {
            background: rgba(255, 193, 7, 0.2);
            color: #856404;
            border: 1px solid #ffc107;
        }

        .role-user {
            background: rgba(40, 167, 69, 0.2);
            color: #155724;
            border: 1px solid #28a745;
        }

        /* User Avatar */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--admin-primary);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 8px;
            font-size: 0.8rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .user-name {
            font-weight: 600;
            color: var(--admin-text-primary);
        }

        /* Action Buttons */
        .action-btn {
            padding: 6px 10px;
            font-size: 0.8rem;
            border-radius: 4px;
            margin: 0 2px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background: #e0a800;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        /* Email Link */
        .user-email {
            color: var(--admin-primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .user-email:hover {
            color: var(--admin-primary-dark);
            text-decoration: underline;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .user-container {
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

            .btn-create-user {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .user-stats {
                flex-direction: column;
            }

            .table-responsive {
                padding: 15px;
                overflow-x: auto;
            }

            #usersTable {
                font-size: 0.8rem;
            }

            #usersTable thead th,
            #usersTable tbody td {
                padding: 10px 8px;
            }

            .action-btn {
                padding: 4px 6px;
                font-size: 0.75rem;
            }

            .user-info {
                flex-direction: column;
                gap: 4px;
            }

            .user-avatar {
                margin-right: 0;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                padding: 15px;
            }

            .page-title {
                font-size: 1.3rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="user-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h3 class="page-title">
                    <i class="fas fa-users"></i>
                    {{ __('User Management') }}
                </h3>
                <p class="page-subtitle">{{ __('Manage system users and their permissions') }}</p>
            </div>
            @if ($createBtnShow == '1')
                <a href="{{ route('admin.users.create') }}" class="btn-create-user">
                    <span class="btn-icon">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="btn-text">{{ __('Create User') }}</span>
                </a>
            @endif
        </div>

        <!-- User Statistics -->
        <div class="user-stats">
            <div class="stat-card">
                <div class="stat-number" id="totalUsers">-</div>
                <div class="stat-label">{{ __('Total Users') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="adminUsers">-</div>
                <div class="stat-label">{{ __('Administrators') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="activeUsers">-</div>
                <div class="stat-label">{{ __('Active Users') }}</div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="fas fa-list"></i>
                    {{ __('All Users') }}
                </h4>
            </div>

            <div class="table-responsive">
                <table id="usersTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Role') }}</th>
                            @if ($createBtnShow == '1')
                                <th>{{ __('Actions') }}</th>
                            @endif
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
            const isAdmin = @json($createBtnShow == '1');

            // Configuration
            const config = {
                ajaxUrl: '{{ route('admin.users.index') }}',
                editUrl: '{{ url('admin/users') }}',
                deleteUrl: '{{ route('admin.users.destroy', '') }}',
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

                showNotification('Error loading users. Please refresh the page.', 'error');
                updateStatistics({
                    totalUsers: 0,
                    adminUsers: 0,
                    activeUsers: 0
                });
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

            // Update statistics
            function updateStatistics(stats) {
                $('#totalUsers').text(stats.totalUsers || '-');
                $('#adminUsers').text(stats.adminUsers || '-');
                $('#activeUsers').text(stats.activeUsers || '-');
            }

            // Generate user avatar
            function generateAvatar(name) {
                if (!name) return 'U';
                const parts = name.trim().split(' ');
                if (parts.length >= 2) {
                    return (parts[0][0] + parts[1][0]).toUpperCase();
                }
                return name[0].toUpperCase();
            }

            // Render user info with avatar
            function renderUserInfo(data, type, row) {
                if (type !== 'display') return data;

                const avatar = generateAvatar(row.name);
                return `
            <div class="user-info">
                <div class="user-avatar">${avatar}</div>
                <span class="user-name">${row.name || 'Unknown'}</span>
            </div>
        `;
            }

            // Render role badge
            function renderRoleBadge(role) {
                if (!role) return '<span class="text-muted">—</span>';

                let className = 'role-badge';
                switch (role.toLowerCase()) {
                    case 'admin':
                        className += ' role-admin';
                        break;
                    case 'editor':
                        className += ' role-editor';
                        break;
                    default:
                        className += ' role-user';
                }

                return `<span class="${className}">${role}</span>`;
            }

            // Render action buttons
            function renderActionButtons(data, type, row) {
                if (type !== 'display' || !isAdmin) {
                    return '';
                }

                return `
            <div class="btn-group" role="group" aria-label="Actions">
                <a href="${config.editUrl}/${row.id}/edit" 
                   class="btn btn-sm btn-warning action-btn" 
                   data-bs-toggle="tooltip" 
                   title="{{ __('Edit User') }}">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" 
                        class="btn btn-sm btn-danger action-btn delete-btn" 
                        data-user-id="${row.id}"
                        data-user-name="${row.name || 'Unknown'}"
                        data-bs-toggle="tooltip" 
                        title="{{ __('Delete User') }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
            }

            // Build table columns based on user role
            function getTableColumns() {
                const baseColumns = [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        width: isAdmin ? '30%' : '50%',
                        render: renderUserInfo
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        width: isAdmin ? '35%' : '50%',
                        render: function(data, type, row) {
                            return data ? `<a href="mailto:${data}" class="user-email">${data}</a>` :
                                '<span class="text-muted">—</span>';
                        }
                    }
                ];

                if (isAdmin) {
                    baseColumns.push({
                        data: 'role',
                        name: 'role',
                        orderable: true,
                        width: '15%',
                        render: function(data, type, row) {
                            return renderRoleBadge(data);
                        }
                    });

                    baseColumns.push({
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '20%',
                        render: renderActionButtons
                    });
                }

                return baseColumns;
            }

            // Initialize DataTable
            const table = $('#usersTable').DataTable({
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
                columns: getTableColumns(),
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> {{ __('Copy') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: isAdmin ? [0, 1, 2] : [0, 1]
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> {{ __('CSV') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: isAdmin ? [0, 1, 2] : [0, 1]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> {{ __('Excel') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: isAdmin ? [0, 1, 2] : [0, 1]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> {{ __('PDF') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: isAdmin ? [0, 1, 2] : [0, 1]
                        }
                    }
                ],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> {{ __('Loading users...') }}',
                    search: "{{ __('Search users') }}:",
                    lengthMenu: "{{ __('Show _MENU_ users') }}",
                    info: "{{ __('Showing _START_ to _END_ of _TOTAL_ users') }}",
                    infoEmpty: "{{ __('Showing 0 to 0 of 0 users') }}",
                    infoFiltered: "({{ __('filtered from _MAX_ total users') }})",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    },
                    emptyTable: "{{ __('No users available') }}",
                    zeroRecords: "{{ __('No matching users found') }}"
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
                    $('.delete-btn').off('click').on('click', handleDeleteClick);
                },
                initComplete: function(settings, json) {
                    console.log('Users DataTable initialized successfully');
                    if (json && json.success) {
                        // Calculate and update statistics
                        const data = json.data || [];
                        const adminCount = data.filter(user => user.role === 'admin').length;

                        updateStatistics({
                            totalUsers: json.recordsTotal || 0,
                            adminUsers: adminCount,
                            activeUsers: data.length
                        });
                    } else if (json && !json.success) {
                        showNotification('Warning: ' + (json.error || 'Unknown error occurred'),
                            'warning');
                    }
                }
            });

            // Handle delete button click
            function handleDeleteClick() {
                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');

                const confirmMessage =
                    `{{ __('Are you sure you want to delete user') }} "${userName}"?\n\n{{ __('This action cannot be undone.') }}`;

                if (confirm(confirmMessage)) {
                    $.ajax({
                        url: `${config.deleteUrl}/${userId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            showNotification('{{ __('User deleted successfully') }}', 'success');
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete error:', xhr.responseText);
                            let errorMessage = '{{ __('Error deleting user') }}';

                            if (xhr.status === 422) {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } else if (xhr.status === 404) {
                                errorMessage = '{{ __('User not found') }}';
                            }

                            showNotification(errorMessage, 'error');
                        }
                    });
                }
            }

            // Theme change handler
            window.addEventListener('themeChanged', function(e) {
                setTimeout(function() {
                    table.draw(false);
                }, 100);
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Auto-refresh table every 5 minutes
            setInterval(function() {
                if (document.visibilityState === 'visible') {
                    table.ajax.reload(null, false);
                }
            }, 300000); // 5 minutes
        });
    </script>
@endsection
