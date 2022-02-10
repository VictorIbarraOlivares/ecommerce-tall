<div class="container py-12">
    {{-- The whole world belongs to you. --}}
    <x-jet-form-section submit='save' class="mb-6">
        <x-slot name='title'>
            Agregar un nuevo departamento
        </x-slot>
        <x-slot name='description'>
            Completar informacion necesaria para poder agregar un nuevo departamento
        </x-slot>
        <x-slot name='form'>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Nombre
                </x-jet-label>
                <x-jet-input wire:model.defer='createForm.name' type='text' class="w-full mt-1" />
                <x-jet-input-error for='createForm.name' />
            </div>
        </x-slot>
        <x-slot name='actions'>
            <x-jet-action-message class="mr-3" on='save'>
                Departamento agregado
            </x-jet-action-message>
            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-action-section >
        <x-slot name="title">
            Lista de departamentos
        </x-slot>
        <x-slot name="description">
            Aquí encontrará todas los departamentos agregados
        </x-slot>
        <x-slot name="content">
            <table class="text-gray-600">
                <thead class="border-b border-gray-300">
                    <tr class="text-left">
                        <th class="py-2 w-full">Nombre</th>
                        <th class="py-2">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @foreach ($this->departments as $department)
                    <tr>
                        <td class="py-2">
                            <a href="{{ route('admin.departments.show', $department) }}" class="uppercase underline hover:text-blue-600">
                                {{ $department->name }}
                            </a>
                        </td>
                        <td class="py-2">
                            <div class="flex divide-x divide-gray-300 font-semibold">
                                <a wire:click="edit('{{ $department->id }}')" class="pr-2 hover:text-blue-600 cursor-pointer">Editar</a>
                                <a wire:click="$emit('delete-department', '{{ $department->id }}')" class="pl-2 hover:text-red-600 cursor-pointer">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-jet-action-section>

    <x-jet-dialog-modal wire:model='editForm.open'>
        <x-slot name='title'>
            Editar departamento
        </x-slot>
        <x-slot name='content'>
            <div class="space-y-3">
                <div>
                    <x-jet-label>
                        Nombre
                    </x-jet-label>
                    <x-jet-input wire:model='editForm.name' type="text" class="w-full mt-1"/>
                    <x-jet-input-error for='editForm.name' />
                </div>
            </div>
        </x-slot>
        <x-slot name='footer'>
            <x-jet-danger-button wire:click='update' wire:loading.attr='disabled' wire:target='update'>
                Actualizar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('script')
        <script>
            Livewire.on('delete-department', department_id => {
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
                        Livewire.emitTo('admin.department-component', 'delete', department_id)
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
</div>
