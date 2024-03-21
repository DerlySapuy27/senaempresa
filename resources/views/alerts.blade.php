{{-- Alert Exito --}}
@if (session('success'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Éxito",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif


    {{-- Alert de Confirmación de Eliminación --}}
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "¿Estás Seguro/a?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar" // Cambia la palabra Cancelar aquí
        }).then((result) => {
            if (result.isConfirmed) {
                // Envías el formulario directamente
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }
</script>