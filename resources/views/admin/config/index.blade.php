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
            <h3 class="mb-0">{{ __('Configuration') }}</h3>
            <a href="{{ route('admin.config.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                {{ __('Create Config') }}</a>
        </div>

        <!-- DevExtreme DataGrid container -->
        <table id="configTable" class="display text-center" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __('Id') }}</th>
                    <th>{{ __('Key') }}</th>
                    <th>{{ __('Value') }}</th>
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#configTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.config.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                    }, {
                        data: 'key',
                        name: 'key',
                        orderable: false,
                    },
                    {
                        data: 'value',
                        name: 'value',
                        orderable: false,
                    }, {
                        data: 'message',
                        name: 'message',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                
                                <a href="/admin/config/${row.id}/edit" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                            `;
                        }
                    }
                    // <form action="{{ url('admin/config') }}/${row.id}" method="POST" style="display:inline;">
                    //                 @csrf
                    //                 @method('DELETE')
                    //                 <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
                    //                     <i class="fas fa-trash"></i>
                    //                 </button>
                    //             </form>

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
