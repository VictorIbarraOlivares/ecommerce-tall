{{-- Close your eyes. Count to one. That is how long forever feels. --}}
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
           {{ $department->name }}
        </h2>
    </x-slot>

    <div class="container py-12">
        {{-- The whole world belongs to you. --}}
        <x-jet-form-section submit='save' class="mb-6">
            <x-slot name='title'>
                Agregar una nueva ciudad
            </x-slot>
            <x-slot name='description'>
                Completar informacion necesaria para poder agregar una nueva ciudad
            </x-slot>
            <x-slot name='form'>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label>
                        Nombre
                    </x-jet-label>
                    <x-jet-input wire:model.defer='createForm.name' type='text' class="w-full mt-1" />
                    <x-jet-input-error for='createForm.name' />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label>
                        Costo
                    </x-jet-label>
                    <x-jet-input wire:model.defer='createForm.cost' type='number' class="w-full mt-1" />
                    <x-jet-input-error for='createForm.cost' />
                </div>
            </x-slot>
            <x-slot name='actions'>
                <x-jet-action-message class="mr-3" on='save'>
                    Ciudad agregada
                </x-jet-action-message>
                <x-jet-button>
                    Agregar
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    
        <x-jet-action-section >
            <x-slot name="title">
                Lista de ciudades
            </x-slot>
            <x-slot name="description">
                Aquí encontrará todas las ciudades agregadas
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
                        @foreach ($this->cities as $city)
                        <tr>
                            <td class="py-2">
                                {{-- href="{{ route('admin.departments.show', $city) }}" --}}
                                <a  class="uppercase underline hover:text-blue-600">
                                    {{ $city->name }}
                                </a>
                            </td>
                            <td class="py-2">
                                <div class="flex divide-x divide-gray-300 font-semibold">
                                    <a wire:click="edit('{{ $city->id }}')" class="pr-2 hover:text-blue-600 cursor-pointer">Editar</a>
                                    <a wire:click="$emit('delete-department', '{{ $city->id }}')" class="pl-2 hover:text-red-600 cursor-pointer">Eliminar</a>
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
                Editar ciudad
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
                    <div>
                        <x-jet-label>
                            Costo
                        </x-jet-label>
                        <x-jet-input wire:model='editForm.cost' type="text" class="w-full mt-1"/>
                        <x-jet-input-error for='editForm.cost' />
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
</div>
