@extends('admin.layouts.app')
@section('title', __('View Sub Category'))

@section('style')
    <style>
        .display {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0"><a href="{{ route('admin.subCategories.index') }}"><i class="fas fa-arrow-left"></i></a>
                &nbsp;&nbsp;{{ __('Category Detail') }} : {{ $subCategory->{'sub_category_' . app()->getLocale()} }}</h3>
            <a href="{{ route('admin.subCategories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                {{ __('Create Sub Category') }}</a>
        </div>

        <table id="categorySongTable" class="display text-center" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __('Code') }}</th>
                    <th>{{ __('English Title') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const categoryId = "{{ $subCategory->sub_category_code }}";
            // console.log('sub category code',categoryId);

            $('#categorySongTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.subCategories.show', ':id') }}'.replace(':id', categoryId),
                columns: [{
                        data: 'song_code',
                        name: 'song_code'
                    },
                    {
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                    <a href="{{ url('admin/songs') }}/${row.song_code}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
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
        });
    </script>
@endsection
