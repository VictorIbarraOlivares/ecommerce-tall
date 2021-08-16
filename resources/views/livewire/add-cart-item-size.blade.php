<div>
    {{-- The whole world belongs to you. --}}
    <div>
        <p class="text-xl text-gray-700">Talla</p>
        <select wire:model='sizeId' class="form-control w-full">
            <option value="" disabled selected>Seleccione una talla</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-2">
        <p class="text-xl text-gray-700">Color</p>
        <select  class="form-control w-full">
            <option value="" disabled selected>Seleccione un color</option>
            @foreach ($colors as $color)
                <option class="capitalize" value="{{ $color->id }}">{{ $color->name }}</option>
            @endforeach
        </select>
    </div>
</div>
