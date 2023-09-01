

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Autocomplete and DataTables</title>
    <!-- Include necessary CSS and JS libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/css/bootstrap.min.css">

</head>
<body>

<div class="container">
    <h2>Autocomplete Text Box</h2>

    <form id="textForm">
        <input type="text" id="autocomplete" name="manager" placeholder="Enter Manager">
        <button type="submit">Submit</button>
    </form>

    <h2>Texts</h2>
    <table id="texts-table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Manager</th>
            <th>Created At</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
{{--<script src="{{ asset('js/autocomplete.js') }}"></script>--}}
<script>
    $(function () {
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
</script>
</body>
</html>
