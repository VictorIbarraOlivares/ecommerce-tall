<x-app-layout>
    <div class="container py-12">
        <section class="grid grid-cols-5 gap-6 text-white">
            <a href="{{ route('orders.index') . "?status=" . App\Models\Order::PENDIENTE }}" class="bg-red-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $amountOfOrders[App\Models\Order::PENDIENTE] }}</p>
                <p class="uppercase text-center">Pendiente</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-business-time"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=" . App\Models\Order::RECIBIDO }}" class="bg-gray-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $amountOfOrders[App\Models\Order::RECIBIDO] }}</p>
                <p class="uppercase text-center">Recibido</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-credit-card"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=" . App\Models\Order::ENVIADO }}" class="bg-yellow-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $amountOfOrders[App\Models\Order::ENVIADO] }}</p>
                <p class="uppercase text-center">Enviado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-truck"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=" . App\Models\Order::ENTREGADO }}" class="bg-pink-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $amountOfOrders[App\Models\Order::ENTREGADO] }}</p>
                <p class="uppercase text-center">Entregado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-check-circle"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=" . App\Models\Order::ANULADO }}" class="bg-green-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $amountOfOrders[App\Models\Order::ANULADO] }}</p>
                <p class="uppercase text-center">Anulado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-times-circle"></i>
                </p>
            </a>
        </section>

        <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <h1 class="text-2xl mb-4">Pedidos recientes</h1>
            <ul>
                @foreach ($orders as $order)
                    <li>
                        <a href="{{ route('orders.show', $order) }}" class="flex items-center py-2 px-4 hover:bg-gray-100">
                            <span class="w-12 text-center">
                                @switch($order->status)
                                    @case(App\Models\Order::PENDIENTE)
                                        <i class="fas fa-business-time text-red-500 opacity-50"></i>
                                        @break
                                    @case(App\Models\Order::RECIBIDO)
                                        <i class="fas fa-credit-card text-gray-500 opacity-50"></i>
                                        @break
                                    @case(App\Models\Order::ENVIADO)
                                        <i class="fas fa-truck text-yellow-500 opacity-50"></i>
                                        @break
                                    @case(App\Models\Order::ENTREGADO)
                                        <i class="fas fa-check-circle text-pink-500 opacity-50"></i>
                                        @break
                                    @case(App\Models\Order::ANULADO)
                                        <i class="fas fa-times-circle text-green-500 opacity-50"></i>
                                        @break
                                    @default
                                        
                                @endswitch
                            </span>

                            <span>
                                Order: {{ $order->id }}
                                <br>
                                {{ $order->created_at->format('d/m/y') }}
                            </span>

                            <div class="ml-auto">
                                <span class="font-bold">
                                    @switch($order->status)
                                        @case(App\Models\Order::PENDIENTE)
                                            Pendiente
                                            @break
                                        @case(App\Models\Order::RECIBIDO)
                                            Recibido
                                            @break
                                        @case(App\Models\Order::ENVIADO)
                                            Enviado
                                            @break
                                        @case(App\Models\Order::ENTREGADO)
                                            Entregado
                                            @break
                                        @case(App\Models\Order::ANULADO)
                                            Anulado
                                            @break
                                        @default
                                            
                                    @endswitch
                                </span>
                                <br>
                                <span class="text-sm">
                                    {{ $order->total }} CLP
                                </span>
                            </div>

                            <span class="fas fa-angle-right ml-6">

                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
</x-app-layout>