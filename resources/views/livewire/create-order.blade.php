<div class="container py-8 grid grid-cols-5 gap-6">
    {{-- The Master doesn't talk, he acts. --}}
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <x-jet-label value='Nombre de contácto' />
                <x-jet-input wire:model.defer='contact' type='text' placeholder='Ingrese el nombre de la persona que recibirá el producto' class="w-full" />
                <x-jet-input-error for='contact' />
            </div>

            <div>
                <x-jet-label value='Teléfono de contácto' />
                <x-jet-input wire:model.defer='phone' type='text' placeholder='Ingrese un número de teléfono para contácto' class="w-full" />
                <x-jet-input-error for='phone' />
            </div>
        </div>

        <div x-data="{ envio_type: @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envíos</p>

            <label class="bg-white rounded-lg shadow-lg px-6 py-4 flex items-center mb-4">
                <input x-model="envio_type" type="radio" name="envio_type" value="1" class="text-gray-600">
    
                <span class="ml-2 text-gray-700">Recojer en tienda (Calle falsa 1111)</span>
                <span class="font-semibold text-gray-700 ml-auto">
                    Gratis
                </span>
            </label>

            <div class="bg-white rounded-lg shadow-lg ">
                <label class="px-6 py-4 flex items-center">
                    <input x-model="envio_type" type="radio" name="envio_type" value="2" class="text-gray-600">
        
                    <span class="ml-2 text-gray-700">Envío a domicilio</span>
                </label>

                <div class="px-6 pb-6 grid grid-cols-2 gap-6 hidden" :class="{'hidden': envio_type != 2}">
                    {{-- Departments --}}
                    <div>
                        <x-jet-label value='Departamento' />
                        <select class="form-control w-full"  wire:model='departmentId'>
                            <option value="" disabled selected>Seleccione un Departamento</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for='departmentId' />
                    </div>
                    {{-- Cities --}}
                    <div>
                        <x-jet-label value='Ciudad' />
                        <select class="form-control w-full"  wire:model='cityId'>
                            <option value="" disabled selected>Seleccione una Ciudad</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for='cityId' />
                    </div>
                    {{-- Districts --}}
                    <div>
                        <x-jet-label value='Distrito' />
                        <select class="form-control w-full"  wire:model='disctrictId'>
                            <option value="" disabled selected>Seleccione un Distrito</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for='disctrictId' />
                    </div>
                    <div>
                        <x-jet-label value='Direccion' />
                        <x-jet-input wire:model='address' type='text' class="w-full" />
                        <x-jet-input-error for='address' />
                    </div>
                    <div class="col-span-2">
                        <x-jet-label value='Referencia' />
                        <x-jet-input wire:model='reference' type='text' class="w-full" />
                        <x-jet-input-error for='reference' />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <x-jet-button class="mt-6 mb-4" wire:click='store'>
                Continuar con la compra
            </x-jet-button>
            <hr>
            <p class="text-gray-700 text-sm mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum voluptas libero, laudantium provident, reprehenderit iure perferendis ipsa maxime atque enim, aperiam esse veniam culpa repudiandae? Autem voluptas tempora modi. <a class="font-semibold text-orange-500" href="">Politicas de privacidad</a> </p>
        </div>
        
    </div>

    <div class="col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img src="{{ $item->options['image'] }}" class="h-15 w-20 object-cover mr-4" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex">
                                <p class="text-sm">Cant: {{ $item->qty }}</p>
                                @isset ($item->options['color'])
                                    <p class="text-sm mx-2">- Color: {{ __($item->options['color']) }}</p>
                                @endisset
                                @isset ($item->options['size'])
                                    <p class="text-sm">- {{ __($item->options['size']) }}</p>
                                @endisset
                            </div>
                            <p>USD {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="p-2">
                        <p class="text-center text-gray-700 ">
                            No tiene agregado ningún ítem en el carrito
                        </p>
                    </li>
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">

            <div class="text-gray-700">
                <p class="flex justify-between items-center">Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} USD</span>
                </p>
                <p class="flex justify-between items-center">Envio
                    <span class="font-semibold">Gratis</span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex justify-between items-center font-semibold">
                    <span class="text-lg">Total </span>{{ Cart::subtotal() }} USD
                </p>
            </div>
        </div>
    </div>
</div>
