@extends('admin.layouts.app')
@section('title', 'Admin Home')
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
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ __('Contacts List') }}</h3>
        </div>

        <!-- DevExtreme DataGrid container -->
        <table id="contactsTable" class="display text-center" style="width:100%">
            <thead>
                <tr>
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
            $('#contactsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.contacts.index') }}',
                columns: [{
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
                            return `
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
        });
    </script>
@endsection
