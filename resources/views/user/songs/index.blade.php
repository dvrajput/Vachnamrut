@extends('user.layouts.app')
@section('title', 'View Song')

@section('style')
    <style>
        .container-fluid {
            padding: 20px;
        }

        h3 {
            margin-bottom: 20px;
            text-align: center;
        }

        .table-container {
            border: 1px solid #d7861b;
            border-radius: 5px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .display {
            text-align: center;
            margin-top: 20px;
        }

        th {
            background-color: #d7861b;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border: 1px solid #d7861b;
        }


        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
        }

        .dataTables_wrapper .dataTables_paginate {
            justify-content: center;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin: 20px 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            table {
                width: 100%;
                /* Ensure table takes full width on smaller screens */
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h3 class="mb-0">Song List</h3>

        <div class="table-container">
            <!-- DataTable container -->
            <table id="songsTable" class="display text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('English Title') }}</th>
                        <th>{{ __('Gujarati Title') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#songsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.songs.index') }}',
                columns: [{
                        data: 'title_en',
                        name: 'title_en',
                        orderable:false,
                        render: function(data, type, row) {
                            return `<a href="{{ url('songs') }}/${row.song_code}" style="color: black; text-decoration: none; display: block; height: 100%;">${data}</a>`;
                        }
                    },
                    {
                        data: 'title_gu',
                        name: 'title_gu',
                        orderable:false,
                        render: function(data, type, row) {
                            return `<a href="{{ url('songs') }}/${row.song_code}" style="color: black; text-decoration: none; display: block; height: 100%;">${data}</a>`;
                        }
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    // 'copy', 'csv', 'excel', 'pdf'
                ]
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
