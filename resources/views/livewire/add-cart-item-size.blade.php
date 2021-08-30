<div x-data>
    {{-- The whole world belongs to you. --}}
    <div>
        <p class="text-xl text-gray-700">Talla</p>
        <select wire:model='sizeId' class="capitalize form-control w-full">
            <option value="" disabled selected>Seleccione una talla</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-2">
        <p class="text-xl text-gray-700">Color</p>
        <select wire:model='colorId'  class="capitalize form-control w-full">
            <option value="" disabled selected>Seleccione un color</option>
            @foreach ($colors as $color)
                <option class="capitalize" value="{{ $color->id }}">{{ __($color->name) }}</option>
            @endforeach
        </select>
    </div>

    <p class="text-gray-700 mb-4 mt-4">
        <span class="font-semibold text-lg">Stock disponible: </span>
        @if ($quantity)
            {{ $quantity }}
        @else
            {{ $product->stock }}
        @endif
    </p>

    <div class="flex">
        <div class="mr-4">
            <x-jet-secondary-button disabled 
                x-bind:disabled="$wire.qty <= 1"
                wire:loading.attr='disabled'
                wire:target='decrement'
                wire:click='decrement'>
                -
            </x-jet-secondary-button>
            <span class="mx-2 text-gray-700">{{ $qty }}</span>
            <x-jet-secondary-button disabled 
                x-bind:disabled="$wire.qty >= $wire.quantity"
                wire:loading.attr='disabled'
                wire:target='increment'
                wire:click='increment'>
                +
            </x-jet-secondary-button>
        </div>
        <div class="flex-1">
            <x-button x-bind:disabled="$wire.qty > $wire.quantity" wire:click='addItem' wire:loading.attr='disabled' wire:target='addItem' x-bind:disabled="!$wire.quantity" class="w-full" color="orange">
                Agregar al carrito de compras
            </x-button>
        </div>
    </div>
</div>
