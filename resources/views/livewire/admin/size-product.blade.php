<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="bg-white shadow-lg rounded-lg p-6 mt-12">
        <div>
            <x-jet-label>
                Talla
            </x-jet-label>
            <x-jet-input wire:model='name' type="text" placeholder="ingrese una talla" class="w-full form-control" />
            <x-jet-input-error for="name" />
        </div>

        <div class="flex justify-end items-center mt-4">
            <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save'>
                Agregar
            </x-jet-button>
        </div>
    </div>

    <ul class="mt-12 space-y-4">
        @foreach ($product_sizes as $product_size)
            <li class="bg-white shadow-lg rounded-lg p-6" wire:key='size-{{ $product_size->id }}'>
                <div class="flex items-center">
                    <span class="text-xl font-medium">{{ $product_size->name }}</span>

                    <div class="ml-auto">
                        <x-jet-button wire:click='editSize({{ $product_size->id }})' wire:loading.attr='disabled' wire:target='editSize({{ $product_size->id }})' >
                            <i class="fas fa-edit"></i>
                        </x-jet-button>
                        <x-jet-danger-button wire:click="$emit('delete-size', {{ $product_size->id  }})">
                            <i class="fas fa-trash"></i>
                        </x-jet-danger-button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <x-jet-dialog-modal wire:model='open_modal'>
        <x-slot name='title'>
            Editar talla
        </x-slot>
        <x-slot name='content'>
            <x-jet-label>
                Talla
            </x-jet-label>
            <x-jet-input wire:model='name_edit' type="text" class="w-full" />
            <x-jet-input-error for='name_edit' />
        </x-slot>
        <x-slot name='footer'>
            <x-jet-secondary-button wire:click="$set('open_modal', false)" >
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click='updateSize'
                wire:loading.attr='disabled'
                wire:target='updateSize' 
                >
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('script')
        <script>
            Livewire.on('delete-size', product_size_id => {
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
                        Livewire.emit('deleteSize', product_size_id);
                        Swal.fire(
                        'Eliminado!',
                        '',
                        'success'
                        )
                    }
                })
            })
        </script>
    @endpush
</div>
