<x-admin-layout>
    <div class="container py-12">
        @livewire('admin.create-category')
    </div>

    @push('script')
        <script>
            Livewire.on('delete-category', category_slug => {
                Swal.fire({
                    title: 'Eliminar?',
                        text: "No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.create-category', 'delete', category_slug)
                        Swal.fire(
                            'Eliminado!',
                            '',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</x-admin-layout>
