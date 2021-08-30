<x-app-layout>
    <div class="container py-8">
        <ul>
            @forelse ($products as $product)
                <x-product-list :product="$product" />
            @empty
                <li class="bg-white shadow-2xl rounded-lg">
                    <div class="p-4">
                        <p class="text-lg font-semibold text-gray-700">No hay productos con el nombre "{{ $name }}"</p>
                    </div>
                </li>
            @endforelse
        </ul>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>