<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 30000
        });
    </script>
@elseif (session()->has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 30000
        });
    </script>
@elseif (session()->has('message'))
<script>
    Swal.fire({
        icon: 'info',
        title: 'Info!',
        text: "{{ session('message') }}",
        showConfirmButton: false,
        timer: 30000
    });
</script>
@endif
