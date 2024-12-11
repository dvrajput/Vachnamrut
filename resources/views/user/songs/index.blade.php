@extends('user.layouts.app')
@section('title', 'Kirtanavali')

@section('style')
      <style>
            .container-fluid {
                  padding: 20px;
                  display: flex;
                  justify-content: center;
            }

            .table-container {
                  border: 1px solid #d7861b;
                  border-radius: 5px;
                  padding: 20px;
                  background-color: white;
                  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                  width: 70%;
            }

            td {
                  padding: 12px;
                  border: 1px solid #d7861b;
                  font-size: 20px;
            }

            /* Centered search bar styling */
            .dataTables_wrapper .dataTables_filter {
                  text-align: center !important;
                  margin: 20px 0 40px 0 !important;
            }

            .dataTables_wrapper .dataTables_filter input {
                  width: 300px;
                  padding: 8px 16px;
                  border: 2px solid #d7861b;
                  border-radius: 20px;
                  outline: none;
                  transition: all 0.3s ease;
                  font-size: 16px;
            }

            .dataTables_wrapper .dataTables_filter input:focus {
                  box-shadow: 0 0 5px rgba(215, 134, 27, 0.5);
                  border-color: #d7861b;
            }

            .dataTables_wrapper .dataTables_filter input::placeholder {
                  color: #999;
            }

            /* Hide length dropdown */
            .dataTables_wrapper .dataTables_length {
                  display: none;
            }

            /* Pagination styling */
            .dataTables_wrapper .dataTables_paginate {
                  justify-content: center;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                  padding: 0.5em 1em;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                  .table-container {
                        width: 95%;
                  }

                  .dataTables_wrapper .dataTables_filter input {
                        width: 200px;
                  }
            }
      </style>
@endsection

@section('content')
      <div class="container-fluid">
            <div class="table-container">
                  <table id="songsTable" class="display text-center" style="width:100%">
                        <thead>
                              <tr>
                                    <th></th>
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
                        pageLength: 20,
                        ajax: {
                              url: '{{ route('user.songs.index') }}',
                              data: function(d) {
                                    // Send search term to be matched against both languages
                                    d.searchBoth = d.search.value;
                              }
                        },
                        columns: [{
                              data: 'title_{{ app()->getLocale() }}',
                              name: 'title_{{ app()->getLocale() }}',
                              orderable: false,
                              render: function(data, type, row) {
                                    return `<a href="{{ url('songs') }}/${row.song_code}" style="color: black; text-decoration: none; display: block; height: 100%;">${data}</a>`;
                              }
                        }],
                        language: {
                              search: "",
                              searchPlaceholder: "Search Kirtan..."
                        },
                        dom: 'ft<"bottom"p>', // Only show filter, table and pagination
                        buttons: []
                  });

                  $('[data-toggle="tooltip"]').tooltip();
            });
      </script>
      <script>
            document.addEventListener('contextmenu', function(e) {
                  e.preventDefault();
            });
      </script>
@endsection