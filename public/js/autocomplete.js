$(function () {
    //datatable
    $('#texts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-data') }}",
        columns: [
            {data: 'manager', name: 'manager'},
            {data: 'created_at', name: 'created_at'}
        ]
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Initialize Autocomplete for the input field
    $('#autocomplete').autocomplete({
        source: "{{ route('autocomplete') }}",
        minLength: 1
    });
    // Handle form submission using AJAX
    $('#textForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                // alert(response.message);
                $('#textForm')[0].reset();

                // Refresh Autocomplete source and DataTable
                $('#autocomplete').autocomplete("option", "source", "{{ route('autocomplete') }}");
                $('#texts-table').DataTable().ajax.reload();
            }
        });
    });

});

