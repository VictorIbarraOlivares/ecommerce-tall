<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6 flex  items-center">
            <div class="relative">
                <div class="{{ ($order->status >= App\Models\Order::RECIBIDO && $order->status != App\Models\Order::ANULADO ) ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-check text-white"></i>
                </div>

                <div class="absolute -left-1.5 mt-0.5">
                    <p>Recibido</p>
                </div>
            </div>

            <div class="{{ ($order->status >= App\Models\Order::ENVIADO && $order->status != App\Models\Order::ANULADO ) ? 'bg-blue-400' : 'bg-gray-400'}} h-1 flex-1 mx-2"></div>

            <div class="relative">
                <div class="{{ ($order->status >= App\Models\Order::ENVIADO && $order->status != App\Models\Order::ANULADO ) ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-truck text-white"></i>
                </div>

                <div class="absolute -left-1 mt-0.5">
                    <p>Enviado</p>
                </div>
            </div>
            <div class="{{ ($order->status >= App\Models\Order::ENTREGADO && $order->status != App\Models\Order::ANULADO ) ? 'bg-blue-400' : 'bg-gray-400'}} h-1 flex-1 mx-2"></div>
            <div class="relative ">
                <div class="{{ ($order->status >= App\Models\Order::ENTREGADO && $order->status != App\Models\Order::ANULADO ) ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-check text-white"></i>
                </div>

                <div class="absolute -left-2 mt-0.5">
                    <p>Entregado</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
            <p class="text-gray-700 uppercase">
                <span class="font-bold">N??mero de orden:</span> Orden-{{ $order->id }}
            </p>
            <form wire:submit.prevent='update'> 
                <div class="flex space-x-3 mt-2">
                    <x-jet-label>
                        <input wire:model='status' type="radio" name="status" value="2" class="mr-2">
                        RECIBIDO
                    </x-jet-label>
                    <x-jet-label>
                        <input wire:model='status' type="radio" name="status" value="3" class="mr-2">
                        ENVIADO
                    </x-jet-label>
                    <x-jet-label>
                        <input wire:model='status' type="radio" name="status" value="4" class="mr-2">
                        ENTREGADO
                    </x-jet-label>
                    <x-jet-label>
                        <input wire:model='status' type="radio" name="status" value="5" class="mr-2">
                        ANULADO
                    </x-jet-label>
                </div>

                <div class="flex mt-2">
                    <x-jet-button class="ml-auto">
                        ACTUALIZAR
                    </x-jet-button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <div class="">
                    <p class="text-lg font-semibold uppercase">Env??o</p>
                    @if ($order->envio_type == 1)
                        <p class="text-sm">Los productos deben ser recogidos en la tienda</p>
                        <p class="text-sm">Calle falsa 1111</p>
                    @else
                        <p class="text-sm">Los productos ser??n enviados a:</p>
                        <p class="text-sm">{{ $envio->address }}</p>
                        <p>{{ $envio->department }} - {{ $envio->city }} - {{ $envio->district }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-lg font-semibold uppercase">Datos de contacto</p>
                    <p class="text-sm">Persona que recibir?? el producto: {{ $order->contact }}</p>
                    <p class="text-sm">Tel??fono de contacto: {{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6 text-gray-700">
            <p class="text-xl font-semibold mb-4">Resumen</p>

            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cant</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="dibide-y divide-gray-300">
                    @foreach (json_decode($order->content) as $item)
                        <tr>
                            <td>
                                <div class="flex">
                                    <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                                    <article>
                                        <h1 class="font-bold">{{ $item->name }}</h1>
                                        <div class="flex text-xs">
                                            @isset($item->options->color)
                                                Color: {{ __($item->options->color) }}
                                            @endisset 
                                            @isset($item->options->size)
                                                - {{ $item->options->size }}
                                            @endisset
                                        </div>
                                    </article>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ number_format($item->price, 0, '', '.') }} CLP
                            </td>
                            <td class="text-center">
                                {{ $item->qty }}
                            </td>
                            <td class="text-center">
                                {{ number_format($item->price * $item->qty, 0, '', '.') }} CLP 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
