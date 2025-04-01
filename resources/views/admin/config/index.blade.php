@extends('admin.layouts.app')
@section('title', 'Admin Config')
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
    @php
        $user = Auth::user();
        $isAdmin = $user && $user->role === 'admin';
    @endphp

    @if($isAdmin)
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
    @else
        <div class="container-fluid">
            <div class="alert alert-danger">
                <h4>{{ __('Access Denied') }}</h4>
                <p>{{ __('You do not have permission to access this page.') }}</p>
            </div>
        </div>
    @endif
@endsection

@section('script')
    @if($isAdmin)
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
    @endif
@endsection