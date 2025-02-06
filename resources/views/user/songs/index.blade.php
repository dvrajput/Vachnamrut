@extends('user.layouts.app')
@section('title', 'Kirtanavali')

@section('style')
<style>
    :root {
        --primary-color: #d7861b;
        --bg-color: #f8f9fa;
        --card-bg: #ffffff;
        --text-color: #212529;
        --border-color: #d7861b;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --link-color: #212529;
    }

    [data-theme="dark"] {
        --bg-color: #212529;
        --card-bg: #2c3034;
        --text-color: #f8f9fa;
        --border-color: #d7861b;
        --shadow-color: rgba(0, 0, 0, 0.3);
        --link-color: #f8f9fa;
    }

    .container-fluid {
        padding: 20px;
        display: flex;
        justify-content: center;
        background-color: var(--bg-color);
    }

    .table-container {
        /* border: 1px solid var(--border-color); */
        border: none;
        border-radius: 5px;
        padding: 20px;
        background-color: var(--card-bg);
        box-shadow: 0 2px 10px var(--shadow-color);
        width: 70%;
    }

    td {
        padding: 12px;
        border: 1px solid var(--border-color);
        font-size: 23px;
        font-weight: 500;
        color: var(--text-color);
    }

    /* Table styles */
    #songsTable {
        color: var(--text-color);
    }

    #songsTable a {
        color: var(--link-color) !important;
        text-decoration: none;
        display: block;
        height: 100%;
    }

    table.dataTable.display tbody td {
    border-top: none;
      }

    /* Search bar styling */
    .dataTables_wrapper .dataTables_filter {
      float: none;
        text-align: center !important;
        margin: 20px auto 40px auto !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 400px;
        padding: 10px 16px;
        padding-top: 14px;
        border: 2px solid var(--border-color);
        border-radius: 20px;
        outline: none;
        transition: all 0.3s ease;
        font-size: 16px;
        background-color: var(--card-bg);
        color: var(--text-color);
        margin-bottom: -100px;
        margin-top: 10px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        box-shadow: 0 0 5px rgba(215, 134, 27, 0.5);
        border-color: var(--primary-color);
    }

    .dataTables_wrapper .dataTables_filter input::placeholder {
        color: var(--text-color);
        opacity: 0.6;
    }

    .table.dataTable thead tr {
      display: none;
    }

    /* Hide length dropdown */
    .dataTables_wrapper .dataTables_length {
        display: none;
    }

    /* Pagination styling */
.dataTables_wrapper .dataTables_paginate {
    justify-content: center;
    margin-top: 1.5rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5em 1em;
    color: var(--text-color) !important;
    border: none !important;
    border-radius: 4px;
    margin: 1px 2px;
    background: transparent !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: rgba(215, 134, 27, 0.1) !important;
    color: var(--text-color) !important;
    border: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: var(--primary-color) !important;
    color: white !important;
    border: none !important;
    font-weight: 500;
}

/* Dark theme specific */
[data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: rgba(215, 134, 27, 0.2) !important;
}
/* Remove default DataTables border */
table.dataTable thead th,
table.dataTable thead td {
    border-bottom: 1px solid var(--border-color) !important;
}

/* Remove double borders */
table.dataTable.no-footer {
    border-bottom: 1px solid var(--border-color);
}

    /* DataTables info */
    .dataTables_info {
        color: var(--text-color) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .table-container {
        border: none;
        border-radius: 0;
        padding: 10px;
        background-color: transparent;
        box-shadow: none;
        width: 100%;
    }

.container-fluid {
      padding: 0;
}


      .dataTables_wrapper .dataTables_filter input {
            width: 300px;
        }
      .dataTables_wrapper .dataTables_paginate .paginate_button {
    background: transparent !important;
      }
    }

    .table.dataTable thead .sorting,
.table.dataTable thead .sorting_asc,
.table.dataTable thead .sorting_desc {
    visibility: hidden;
    display: none;
    background-image: none
}

table.dataTable thead th, table.dataTable thead td {
      padding:0;
}

/* Update your DataTables Dark Mode Styling section */
[data-theme="dark"] table.dataTable tbody td {
    background-color: var(--card-bg) !important;
    color: var(--text-color) !important;
}

[data-theme="dark"] table.dataTable tbody tr {
    background-color: var(--card-bg) !important;
}

[data-theme="dark"] table.dataTable tbody tr:hover {
    background-color: #343a40 !important;
}

[data-theme="dark"] table.dataTable tbody tr a {
    color: var(--text-color) !important;
}

/* Force all DataTables elements to use theme colors */
[data-theme="dark"] .dataTables_wrapper table.dataTable {
    background-color: var(--card-bg) !important;
    border-color: var(--border-color) !important;
}

[data-theme="dark"] .dataTables_wrapper .dataTable * {
    background-color: var(--card-bg) !important;
    color: var(--text-color) !important;
}

[data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
    background: var(--card-bg) !important;
    color: var(--text-color) !important;
    border-color: var(--border-color) !important;
}

/* Search input specific styling */
[data-theme="dark"] .dataTables_filter input {
    background-color: var(--card-bg) !important;
    color: var(--text-color) !important;
    border-color: var(--border-color) !important;
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
                url: '{{ route('user.kirtans.index') }}',
                data: function(d) {
                    d.searchBoth = d.search.value;
                }
            },
            columns: [{
                data: 'title_{{ app()->getLocale() }}',
                name: 'title_{{ app()->getLocale() }}',
                orderable: false,
                render: function(data, type, row) {
                    const theme = document.documentElement.getAttribute('data-theme');
                    const textColor = theme === 'dark' ? '#f8f9fa' : '#212529';
                    return `<a href="{{ url('kirtans') }}/${row.song_code}" class="kirtan-link" style="color: ${textColor} !important;">${data}</a>`;
                }
            }],
            language: {
                search: "",
                searchPlaceholder: "{{ __('Search Kirtan...') }}"
            },
            dom: 'ft<"bottom"p>',
            buttons: [],
            createdRow: function(row, data, dataIndex) {
                // Apply theme to newly created rows
                const theme = document.documentElement.getAttribute('data-theme');
                if (theme === 'dark') {
                    $(row).css({
                        'background-color': 'var(--card-bg)',
                        'color': 'var(--text-color)'
                    });
                }
            },
            drawCallback: function() {
                // Update elements after table redraw
                const theme = document.documentElement.getAttribute('data-theme');
                if (theme === 'dark') {
                    $('.dataTables_wrapper').addClass('dark-mode');
                    $('table.dataTable').css({
                        'background-color': 'var(--card-bg)',
                        'color': 'var(--text-color)'
                    });
                    // Force text color for all table cells and links
                    $('table.dataTable td').css('color', 'var(--text-color)');
                    $('table.dataTable a').css('color', 'var(--text-color)');
                }
            },
            initComplete: function() {
                // Apply theme on initial load
                const theme = document.documentElement.getAttribute('data-theme');
                if (theme === 'dark') {
                    $('.dataTables_wrapper').addClass('dark-mode');
                    $('table.dataTable').css({
                        'background-color': 'var(--card-bg)',
                        'color': 'var(--text-color)'
                    });
                }
            }
        });

        // Theme change observer
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "data-theme") {
                    const theme = document.documentElement.getAttribute('data-theme');
                    const table = $('#songsTable').DataTable();
                    table.draw(); // Redraw the table to apply new theme
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme']
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