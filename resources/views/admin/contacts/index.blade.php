@extends('admin.layouts.app')
@section('title', __('Contact Management'))

@section('style')
    <style>
        /* Contact Management Container */
        .contact-container {
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
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Statistics Cards */
        .stats-container {
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
        }

        .stat-label {
            color: var(--admin-text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-pending .stat-number {
            color: #ffc107;
        }

        .stat-approved .stat-number {
            color: #28a745;
        }

        .stat-rejected .stat-number {
            color: #dc3545;
        }

        /* Bulk Actions */
        .bulk-actions-container {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--admin-shadow-sm);
        }

        .bulk-actions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .bulk-actions-title {
            color: var(--admin-text-primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bulk-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .bulk-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .bulk-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .bulk-btn-delete {
            background: #dc3545;
            color: white;
        }

        .bulk-btn-delete:hover:not(:disabled) {
            background: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .bulk-btn-delete-all {
            background: #6c757d;
            color: white;
        }

        .bulk-btn-delete-all:hover {
            background: #5a6268;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
        }

        /* Selection Counter */
        .selection-info {
            color: var(--admin-text-secondary);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
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

        /* Enhanced DataTables Styling */
        .table-responsive {
            padding: 25px;
            background: var(--admin-bg-secondary);
        }

        #contactsTable {
            width: 100% !important;
            background: var(--admin-bg-secondary) !important;
            color: var(--admin-text-primary) !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        #contactsTable thead th {
            background: var(--admin-primary) !important;
            color: white !important;
            font-weight: 600;
            padding: 15px 12px;
            text-align: center;
            border: none;
            font-size: 0.9rem;
        }

        #contactsTable tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--admin-border-color);
            color: var(--admin-text-primary) !important;
            text-align: center;
            vertical-align: middle;
            background: var(--admin-bg-secondary) !important;
        }

        #contactsTable tbody tr:hover {
            background: var(--admin-primary-bg) !important;
        }

        /* Checkbox Styling */
        .select-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--admin-primary);
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #856404;
            border: 1px solid #ffc107;
        }

        .status-approved {
            background: rgba(40, 167, 69, 0.2);
            color: #155724;
            border: 1px solid #28a745;
        }

        .status-rejected {
            background: rgba(220, 53, 69, 0.2);
            color: #721c24;
            border: 1px solid #dc3545;
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

        .btn-approve {
            background: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background: #218838;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
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
            background: #6c757d;
            color: white;
        }

        .btn-delete:hover {
            background: #5a6268;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
        }

        /* Message Preview */
        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            .contact-container {
                padding: 15px;
            }

            .page-header {
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-container {
                flex-direction: column;
            }

            .bulk-actions-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .bulk-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .table-responsive {
                padding: 15px;
                overflow-x: auto;
            }

            #contactsTable {
                font-size: 0.8rem;
            }

            #contactsTable thead th,
            #contactsTable tbody td {
                padding: 10px 8px;
            }

            .action-btn {
                padding: 4px 6px;
                font-size: 0.75rem;
                margin: 1px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="contact-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div>
                    <h3 class="page-title">
                        <i class="fas fa-envelope"></i>
                        {{ __('Contact Management') }}
                    </h3>
                    <p class="page-subtitle">{{ __('Manage customer inquiries and feedback') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card stat-pending">
                <div class="stat-number" id="pendingCount">-</div>
                <div class="stat-label">{{ __('Pending') }}</div>
            </div>
            <div class="stat-card stat-approved">
                <div class="stat-number" id="approvedCount">-</div>
                <div class="stat-label">{{ __('Approved') }}</div>
            </div>
            <div class="stat-card stat-rejected">
                <div class="stat-number" id="rejectedCount">-</div>
                <div class="stat-label">{{ __('Rejected') }}</div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions-container">
            <div class="bulk-actions-header">
                <h4 class="bulk-actions-title">
                    <i class="fas fa-tasks"></i>
                    {{ __('Bulk Actions') }}
                </h4>
                <div class="bulk-actions">
                    <button id="deleteSelected" class="bulk-btn bulk-btn-delete" disabled>
                        <i class="fas fa-trash"></i>
                        {{ __('Delete Selected') }}
                    </button>
                    @if (auth()->user()->role == 'admin')
                        <button id="deleteAll" class="bulk-btn bulk-btn-delete-all">
                            <i class="fas fa-trash-alt"></i>
                            {{ __('Delete All Queries') }}
                        </button>
                    @endif
                </div>
            </div>
            <div class="selection-info">
                <i class="fas fa-info-circle"></i>
                <span id="selectionCount">{{ __('No contacts selected') }}</span>
            </div>
        </div>

        <!-- Contacts Table -->
        <div class="table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="fas fa-list"></i>
                    {{ __('All Contact Queries') }}
                </h4>
            </div>

            <div class="table-responsive">
                <table id="contactsTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" class="select-checkbox">
                            </th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Song Code') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Status') }}</th>
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
            let selectedContacts = [];

            // Configuration
            const config = {
                ajaxUrl: '{{ route('admin.contacts.index') }}',
                editUrl: '{{ url('admin/contacts') }}',
                deleteUrl: '{{ url('admin/contacts') }}',
                approveUrl: '{{ url('admin/contacts') }}',
                rejectUrl: '{{ url('admin/contacts') }}',
                bulkDeleteUrl: '{{ route('admin.contacts.bulk-delete') }}',
                deleteAllUrl: '{{ route('admin.contacts.delete-all') }}',
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

                showNotification('Error loading contacts. Please refresh the page.', 'error');
            }

            // Notification function
            function showNotification(message, type = 'info') {
                // Using toastr if available, otherwise fallback to alert
                if (typeof toastr !== 'undefined') {
                    toastr[type === 'error' ? 'error' : type === 'success' ? 'success' : 'info'](message);
                } else {
                    alert((type === 'error' ? 'Error: ' : type === 'success' ? 'Success: ' : 'Info: ') + message);
                }
            }

            // Update statistics
            function updateStatistics(stats) {
                if (stats) {
                    $('#pendingCount').text(stats.pending || 0);
                    $('#approvedCount').text(stats.approved || 0);
                    $('#rejectedCount').text(stats.rejected || 0);
                }
            }

            // Update selection info
            function updateSelectionInfo() {
                const count = selectedContacts.length;
                if (count === 0) {
                    $('#selectionCount').text('{{ __('No contacts selected') }}');
                } else {
                    $('#selectionCount').text(`{{ __('Selected') }}: ${count} {{ __('contact(s)') }}`);
                }
            }

            // Render status badge
            function renderStatusBadge(status) {
                switch (parseInt(status)) {
                    case 0:
                        return '<span class="status-badge status-pending">{{ __('Pending') }}</span>';
                    case 1:
                        return '<span class="status-badge status-approved">{{ __('Approved') }}</span>';
                    case 2:
                        return '<span class="status-badge status-rejected">{{ __('Rejected') }}</span>';
                    default:
                        return '<span class="status-badge">{{ __('Unknown') }}</span>';
                }
            }

            // Render action buttons
            function renderActionButtons(data, type, row) {
                if (type !== 'display') {
                    return '';
                }

                let actionButtons = '<div class="btn-group" role="group" aria-label="Actions">';

                // Approve/Reject buttons for pending contacts
                if (parseInt(row.status) === 0) {
                    actionButtons += `
                <button class="btn btn-sm btn-approve action-btn approve-btn" 
                        data-id="${row.id}" 
                        data-bs-toggle="tooltip" 
                        title="{{ __('Approve and send thanks email') }}">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn btn-sm btn-reject action-btn reject-btn" 
                        data-id="${row.id}" 
                        data-bs-toggle="tooltip" 
                        title="{{ __('Reject this query') }}">
                    <i class="fas fa-times"></i>
                </button>
            `;
                }

                actionButtons += `
            <a href="${config.editUrl}/${row.id}/edit" 
               class="btn btn-sm btn-edit action-btn" 
               data-bs-toggle="tooltip" 
               title="{{ __('Edit Contact') }}">
                <i class="fas fa-edit"></i>
            </a>
            <button type="button" 
                    class="btn btn-sm btn-delete action-btn delete-btn" 
                    data-id="${row.id}"
                    data-name="${row.name || 'Unknown'}"
                    data-bs-toggle="tooltip" 
                    title="{{ __('Delete Contact') }}">
                <i class="fas fa-trash"></i>
            </button>
        `;

                actionButtons += '</div>';
                return actionButtons;
            }

            // Truncate text function
            function truncateText(text, maxLength = 50) {
                if (!text || text.trim() === '') {
                    return '<span class="text-muted">—</span>';
                }

                const truncated = text.length > maxLength ? text.substr(0, maxLength) + '...' : text;
                return `<span class="message-preview" title="${text}">${truncated}</span>`;
            }

            // Initialize DataTable
            const table = $('#contactsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
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
                        data: null,
                        orderable: false,
                        searchable: false,
                        width: '30px',
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="select-contact select-checkbox" data-id="${row.id}">`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        width: '15%',
                        render: function(data, type, row) {
                            return data ? `<strong>${data}</strong>` :
                                '<span class="text-muted">—</span>';
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        width: '20%',
                        render: function(data, type, row) {
                            return data ? `<a href="mailto:${data}">${data}</a>` :
                                '<span class="text-muted">—</span>';
                        }
                    },
                    {
                        data: 'song_code',
                        name: 'song_code',
                        orderable: true,
                        width: '10%',
                        render: function(data, type, row) {
                            return data ? `<code>${data}</code>` :
                                '<span class="text-muted">—</span>';
                        }
                    },
                    {
                        data: 'message',
                        name: 'message',
                        orderable: false,
                        width: '25%',
                        render: function(data, type, row) {
                            return truncateText(data, 80);
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        width: '10%',
                        render: function(data, type, row) {
                            return renderStatusBadge(data);
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '20%',
                        render: renderActionButtons
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> {{ __('Copy') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> {{ __('CSV') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> {{ __('Excel') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> {{ __('PDF') }}',
                        className: 'dt-button',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> {{ __('Loading contacts...') }}',
                    search: "{{ __('Search contacts') }}:",
                    lengthMenu: "{{ __('Show _MENU_ contacts') }}",
                    info: "{{ __('Showing _START_ to _END_ of _TOTAL_ contacts') }}",
                    infoEmpty: "{{ __('Showing 0 to 0 of 0 contacts') }}",
                    infoFiltered: "({{ __('filtered from _MAX_ total contacts') }})",
                    paginate: {
                        first: "{{ __('First') }}",
                        last: "{{ __('Last') }}",
                        next: "{{ __('Next') }}",
                        previous: "{{ __('Previous') }}"
                    },
                    emptyTable: "{{ __('No contact queries available') }}",
                    zeroRecords: "{{ __('No matching contacts found') }}"
                },
                responsive: true,
                order: [
                    [1, 'desc']
                ],
                searchDelay: 500,
                drawCallback: function(settings) {
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Reset selections on redraw
                    selectedContacts = [];
                    $('#selectAll').prop('checked', false);
                    updateDeleteButtonState();
                    updateSelectionInfo();
                },
                initComplete: function(settings, json) {
                    console.log('Contacts DataTable initialized successfully');
                    if (json && json.success) {
                        updateStatistics(json.stats);
                    } else if (json && !json.success) {
                        showNotification('Warning: ' + (json.error || 'Unknown error occurred'),
                            'warning');
                    }
                }
            });

            // Update delete button state
            function updateDeleteButtonState() {
                $('#deleteSelected').prop('disabled', selectedContacts.length === 0);
            }

            // Select all checkboxes
            $('#selectAll').on('change', function() {
                const isChecked = $(this).prop('checked');
                $('.select-contact').prop('checked', isChecked);

                selectedContacts = [];
                if (isChecked) {
                    $('.select-contact').each(function() {
                        selectedContacts.push($(this).data('id'));
                    });
                }

                updateDeleteButtonState();
                updateSelectionInfo();
            });

            // Individual checkbox selection
            $(document).on('change', '.select-contact', function() {
                const contactId = $(this).data('id');

                if ($(this).prop('checked')) {
                    selectedContacts.push(contactId);
                } else {
                    selectedContacts = selectedContacts.filter(id => id !== contactId);
                    $('#selectAll').prop('checked', false);
                }

                updateDeleteButtonState();
                updateSelectionInfo();
            });

            // Handle approve button click
            $(document).on('click', '.approve-btn', function() {
                const contactId = $(this).data('id');
                const button = $(this);

                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: `${config.approveUrl}/${contactId}/approve`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': config.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        send_thanks: true
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification(response.message ||
                                '{{ __('Contact approved successfully') }}', 'success');
                            table.ajax.reload(null, false);
                        } else {
                            showNotification(response.message ||
                                '{{ __('Error approving contact') }}', 'error');
                            button.prop('disabled', false).html('<i class="fas fa-check"></i>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Approve error:', xhr.responseText);
                        showNotification(
                            '{{ __('An error occurred while processing your request') }}',
                            'error');
                        button.prop('disabled', false).html('<i class="fas fa-check"></i>');
                    }
                });
            });

            // Handle reject button click
            $(document).on('click', '.reject-btn', function() {
                const contactId = $(this).data('id');
                const button = $(this);

                if (confirm('{{ __('Are you sure you want to reject this contact query?') }}')) {
                    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: `${config.rejectUrl}/${contactId}/reject`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotification(response.message ||
                                    '{{ __('Contact rejected successfully') }}', 'success');
                                table.ajax.reload(null, false);
                            } else {
                                showNotification(response.message ||
                                    '{{ __('Error rejecting contact') }}', 'error');
                                button.prop('disabled', false).html(
                                    '<i class="fas fa-times"></i>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Reject error:', xhr.responseText);
                            showNotification(
                                '{{ __('An error occurred while processing your request') }}',
                                'error');
                            button.prop('disabled', false).html('<i class="fas fa-times"></i>');
                        }
                    });
                }
            });

            // Handle delete button click
            $(document).on('click', '.delete-btn', function() {
                const contactId = $(this).data('id');
                const contactName = $(this).data('name');

                const confirmMessage =
                    `{{ __('Are you sure you want to delete the contact from') }} "${contactName}"?\n\n{{ __('This action cannot be undone.') }}`;

                if (confirm(confirmMessage)) {
                    $.ajax({
                        url: `${config.deleteUrl}/${contactId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            showNotification('{{ __('Contact deleted successfully') }}',
                                'success');
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete error:', xhr.responseText);
                            showNotification('{{ __('Error deleting contact') }}', 'error');
                        }
                    });
                }
            });

            // Delete selected contacts
            $('#deleteSelected').on('click', function() {
                if (selectedContacts.length === 0) return;

                const confirmMessage =
                    `{{ __('Are you sure you want to delete the selected') }} ${selectedContacts.length} {{ __('contact queries?') }}\n\n{{ __('This action cannot be undone.') }}`;

                if (confirm(confirmMessage)) {
                    $.ajax({
                        url: config.bulkDeleteUrl,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        data: {
                            ids: selectedContacts
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotification(response.message ||
                                    '{{ __('Selected contacts deleted successfully') }}',
                                    'success');
                                table.ajax.reload();
                                selectedContacts = [];
                                $('#selectAll').prop('checked', false);
                                updateDeleteButtonState();
                                updateSelectionInfo();
                            } else {
                                showNotification(response.message ||
                                    '{{ __('Error deleting contacts') }}', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Bulk delete error:', xhr.responseText);
                            showNotification(
                                '{{ __('An error occurred while processing your request') }}',
                                'error');
                        }
                    });
                }
            });

            // Delete all contacts (admin only)
            $('#deleteAll').on('click', function() {
                const confirmMessage =
                    '{{ __('Are you sure you want to delete ALL contact queries? This action cannot be undone.') }}';

                if (confirm(confirmMessage)) {
                    $.ajax({
                        url: config.deleteAllUrl,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': config.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            if (response.success) {
                                showNotification(response.message ||
                                    '{{ __('All contact queries deleted successfully') }}',
                                    'success');
                                table.ajax.reload();
                                selectedContacts = [];
                                $('#selectAll').prop('checked', false);
                                updateDeleteButtonState();
                                updateSelectionInfo();
                            } else {
                                showNotification(response.message ||
                                    '{{ __('Error deleting all contacts') }}', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete all error:', xhr.responseText);
                            showNotification(
                                '{{ __('An error occurred while processing your request') }}',
                                'error');
                        }
                    });
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

            // Initialize selection info
            updateSelectionInfo();
        });
    </script>
@endsection