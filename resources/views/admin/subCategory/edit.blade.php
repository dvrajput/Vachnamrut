@extends('admin.layouts.app')
@section('title', __('Edit Sub Category'))

@section('content')
    <div class="container-fluid">
        <h3 class="mt-4 mb-4">{{__('Edit Sub Category')}}</h3>
        <form action="{{ route('admin.subCategories.update', $subCategory->sub_category_code) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <!-- Title (English) -->
                <div class="col-md-6 col-12 mb-3">
                    <label for="sub_category_en" class="col-form-label">{{__('English Title')}}</label>
                    <input type="text" class="form-control @error('sub_category_en') is-invalid @enderror" id="sub_category_en"
                        name="sub_category_en" value="{{ old('sub_category_en', $subCategory->sub_category_en) }}" required>
                    @error('sub_category_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title (Gujarati) -->
                <div class="col-md-6 col-12 mb-3">
                    <label for="sub_category_gu" class="col-form-label">{{__('Gujarati Title')}}</label>
                    <input type="text" class="form-control" id="sub_category_gu" name="sub_category_gu"
                        value="{{ old('sub_category_gu', $subCategory->sub_category_gu) }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 col-12">
                    <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                    <a href="{{ route('admin.subCategories.index') }}" class="btn btn-secondary ml-2">{{__('Cancel')}}</a>
                </div>
            </div>
        </form>



        <h3 class="mt-4">{{__('Associated Songs')}} ({{ $subCategory->{'sub_category_' . app()->getLocale()} }})</h3>
        <table id="associatedSongsTable" class="table">
            <thead>
                <tr>
                    <th>{{__('Code')}}</th>
                    <th>{{__('English Title')}}</th>
                    <th>{{__('Gujarati Title')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
        </table>

        <h3 class="mt-4">{{__('Remaining Songs')}} ({{ $subCategory->{'sub_category_' . app()->getLocale()} }})</h3>
        <table id="remainingSongsTable" class="table">
            <thead>
                <tr>
                    <th>{{__('Code')}}</th>
                    <th>{{__('English Title')}}</th>
                    <th>{{__('Gujarati Title')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // DataTable for associated songs
            $('#associatedSongsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.subCategories.associated_songs', $subCategory->sub_category_code) }}',
                columns: [{
                        data: 'song_code',
                        name:'song_code',
                        orderable:false,
                    },
                    {
                        data: 'title_en',
                        name: 'title_en',
                        orderable:false,
                    },
                    {
                        data: 'title_gu',
                        name: 'title_gu',
                        orderable:false,
                    },
                    {
                        data: 'song_code',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // console.log('a',data);
                            
                            return `
                                <form action="{{ route('admin.subCategories.removeSong', '') }}/${data}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="sub_category_code" value="{{ $subCategory->sub_category_code }}">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
                                </form>
                            `;
                        }
                    }
                ]
            });

            // DataTable for remaining songs
            $('#remainingSongsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.subCategories.remaining_songs', $subCategory->sub_category_code) }}',
                columns: [{
                        data: 'song_code',
                        name:'song_code'
                    },
                    {
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'title_gu',
                        name: 'title_gu'
                    },
                    {
                        data: 'song_code',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <form action="{{ route('admin.subCategories.addSong') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="song_code" value="${data}">
                                    <input type="hidden" name="sub_category_code" value="{{ $subCategory->sub_category_code }}">
                                    <button type="submit" class="btn btn-sm btn-success">Add</button>
                                </form>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
