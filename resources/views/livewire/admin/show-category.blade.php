<div class="container py-12">
    {{-- The Master doesn't talk, he acts. --}}
    <x-jet-form-section submit="save" class="mb-6">
        <x-slot name="title">
            Crear nueva subcategoría
        </x-slot>
        <x-slot name="description">
            Complete la información necesaria para poder crear una nueva subcategoría
        </x-slot>
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Nombre
                </x-jet-label>
                <x-jet-input wire:model='createForm.name' type="text" class="w-full mt-1"/>
                <x-jet-input-error for='createForm.name' />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Slug
                </x-jet-label>
                <x-jet-input wire:model='createForm.slug' type="text" disabled class="w-full mt-1 bg-gray-100"/>
                <x-jet-input-error for='createForm.slug' />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center">
                    <p>¿Esta subcategoría necesita especificar color?</p>
                    <div class="ml-auto">
                        <label>
                            <input wire:model.defer='createForm.color' type="radio" name="color" value="1">
                            Si
                        </label>
                        <label>
                            <input wire:model.defer='createForm.color' type="radio" name="color" value="0">
                            No
                        </label>
                    </div>
                </div>
                <x-jet-input-error for='createForm.color' />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center">
                    <p>¿Esta subcategoría necesita especificar talla?</p>
                    <div class="ml-auto">
                        <label>
                            <input wire:model.defer='createForm.size' type="radio" name="size" value="1">
                            Si
                        </label>
                        <label>
                            <input wire:model.defer='createForm.size' type="radio" name="size" value="0">
                            No
                        </label>
                    </div>
                </div>
                <x-jet-input-error for='createForm.size' />
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                Subcategoría creada
            </x-jet-action-message>
            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-action-section >
        <x-slot name="title">
            Lista de subcategorías
        </x-slot>
        <x-slot name="description">
            Aquí encontrará todas las subcategorías agregadas
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
                    @foreach ($subcategories as $subcategory)
                    <tr>
                        <td class="py-2">
                            <span class="uppercase">
                                {{ $subcategory->name }}
                            </span>
                        </td>
                        <td class="py-2">
                            <div class="flex divide-x divide-gray-300 font-semibold">
                                <a wire:click="edit('{{ $subcategory->id }}')" class="pr-2 hover:text-blue-600 cursor-pointer">Editar</a>
                                <a wire:click="$emit('delete-subcategory', '{{ $subcategory->id }}')" class="pl-2 hover:text-red-600 cursor-pointer">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-jet-action-section>
</div>
