@extends('admin.layouts.app')
@section('title', __('Contact'))
@section('style')
    <style>
        .display {
            text-align: center;
            /* Center-aligns text in the table */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            /* Padding for pagination buttons */
        }
        
        .select-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .bulk-actions {
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ __('Contacts List') }}</h3>
            
            <div class="bulk-actions">
                <button id="deleteSelected" class="btn btn-danger" disabled>
                    <i class="fas fa-trash"></i> {{ __('Delete Selected') }}
                </button>
                
                @if(auth()->user()->role == 'admin')
                <button id="deleteAll" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> {{ __('Delete All Queries') }}
                </button>
                @endif
            </div>
        </div>

        <!-- DevExtreme DataGrid container -->
        <table id="contactsTable" class="display text-center" style="width:100%">
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
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let selectedContacts = [];
            
            const table = $('#contactsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50, // Set number of records per page
                ajax: '{{ route('admin.contacts.index') }}',
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        width: '30px',
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="select-contact select-checkbox" data-id="' + row.id + '">';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false,
                    },
                    {
                        data: 'song_code',
                        name: 'message',
                        orderable: false,
                    },
                    {
                        data: 'message',
                        name: 'message',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        render: function(data) {
                            switch (data) {
                                case 0:
                                    return '<span class="badge bg-warning text-dark">Pending</span>';
                                case 1:
                                    return '<span class="badge bg-success">Approve</span>';
                                case 2:
                                    return '<span class="badge bg-danger">Reject</span>';
                                default:
                                    return '<span class="badge bg-secondary">Unknown</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let actionButtons = '';
                            
                            // Only show approve/reject buttons for pending contacts
                            if (row.status == 0) {
                                actionButtons += `
                                    <button class="btn btn-sm btn-success approve-btn" data-id="${row.id}" data-toggle="tooltip" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger reject-btn" data-id="${row.id}" data-toggle="tooltip" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                `;
                            }
                            
                            actionButtons += `
                                <a href="/admin/contacts/${row.id}/edit" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ url('admin/contacts') }}/${row.id}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            `;
                            
                            return actionButtons;
                        }
                    }
                ],

                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ]
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Handle approve button click - now automatically sends email
            $(document).on('click', '.approve-btn', function() {
                const contactId = $(this).data('id');
                
                $.ajax({
                    url: '{{ url("admin/contacts") }}/' + contactId + '/approve',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        send_thanks: true // Always send thanks email
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred while processing your request.');
                    }
                });
            });
            
            // Handle reject button click
            $(document).on('click', '.reject-btn', function() {
                const contactId = $(this).data('id');
                
                $.ajax({
                    url: '{{ url("admin/contacts") }}/' + contactId + '/reject',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred while processing your request.');
                    }
                });
            });
            
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
            });
            
            // Update delete button state
            function updateDeleteButtonState() {
                $('#deleteSelected').prop('disabled', selectedContacts.length === 0);
            }
            
            // Delete selected contacts
            $('#deleteSelected').on('click', function() {
                if (selectedContacts.length === 0) return;
                
                if (confirm('Are you sure you want to delete the selected contact queries?')) {
                    $.ajax({
                        url: '{{ route("admin.contacts.bulk-delete") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedContacts
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                table.ajax.reload();
                                selectedContacts = [];
                                $('#selectAll').prop('checked', false);
                                updateDeleteButtonState();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function() {
                            toastr.error('An error occurred while processing your request.');
                        }
                    });
                }
            });
            
            // Delete all contacts (owner only)
            $('#deleteAll').on('click', function() {
                if (confirm('Are you sure you want to delete ALL contact queries? This action cannot be undone.')) {
                    $.ajax({
                        url: '{{ route("admin.contacts.delete-all") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                table.ajax.reload();
                                selectedContacts = [];
                                $('#selectAll').prop('checked', false);
                                updateDeleteButtonState();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function() {
                            toastr.error('An error occurred while processing your request.');
                        }
                    });
                }
            });
        });
    </script>
@endsection