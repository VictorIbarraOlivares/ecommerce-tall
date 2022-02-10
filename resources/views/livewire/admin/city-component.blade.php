<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
           Distrito {{ $city->name }}
        </h2>
    </x-slot>

    <div class="container py-12">
        {{-- The whole world belongs to you. --}}
        <x-jet-form-section submit='save' class="mb-6">
            <x-slot name='title'>
                Agregar un nuevo distrito
            </x-slot>
            <x-slot name='description'>
                Completar informacion necesaria para poder agregar un nuevo distrito
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
                    Distrito agregado
                </x-jet-action-message>
                <x-jet-button>
                    Agregar
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    
        <x-jet-action-section >
            <x-slot name="title">
                Lista de distritos
            </x-slot>
            <x-slot name="description">
                Aquí encontrará todos los distritos agregados
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
                        @foreach ($this->districts as $district)
                        <tr>
                            <td class="py-2">
                                {{-- href="{{ route('admin.cities.show', $city) }}" --}}
                                <a  class="uppercase underline hover:text-blue-600">
                                    {{ $district->name }}
                                </a>
                            </td>
                            <td class="py-2">
                                <div class="flex divide-x divide-gray-300 font-semibold">
                                    <a wire:click="edit('{{ $district->id }}')" class="pr-2 hover:text-blue-600 cursor-pointer">Editar</a>
                                    <a wire:click="$emit('delete-district', '{{ $district->id }}')" class="pl-2 hover:text-red-600 cursor-pointer">Eliminar</a>
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
                Editar distrito
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
    </div>

    @push('script')
        <script>
            Livewire.on('delete-district', district_id => {
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
                        Livewire.emitTo('admin.city-component', 'delete', district_id)
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
