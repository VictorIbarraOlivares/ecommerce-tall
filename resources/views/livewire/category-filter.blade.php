<div>
    {{-- In work, do what you enjoy. --}}
    <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="px-6 py-2 flex justify-between items-center">
            <h1 class="font-semibold text-gray-700 uppercase">{{ $category->name }}</h1>

            <div class="grid grid-cols-2 border border-gray-300 divide-x divide-gray-300 rounded shadow-sm text-gray-500">
                <i wire:click='$set("view", "grid")' class="{{ $view == 'grid' ? 'text-orange-500' : '' }} fas fa-border-all p-3 cursor-pointer"></i>
                <i wire:click='$set("view", "list")' class="{{ $view == 'list' ? 'text-orange-500' : '' }} fas fa-th-list p-3 cursor-pointer"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <aside>
            <h2 class="font-semibold text-center mb-2">Subcategorías</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->subcategories as $subcategoryTwo)
                    <li class="py-2 text-sm">
                        <a wire:click='$set("subcategory", "{{ $subcategoryTwo->name }}")' class="hover:text-orange-500 capitalize cursor-pointer {{ $subcategory == $subcategoryTwo->name ? 'text-orange-500 font-semibold' : '' }}" >{{ $subcategoryTwo->name }}</a>
                    </li>
                @endforeach
            </ul>
            <h2 class="font-semibold text-center mb-2 mt-4">Marcas</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->brands as $brandTwo)
                    <li class="py-2 text-sm">
                        <a wire:click='$set("brand", "{{ $brandTwo->name }}")' class="hover:text-orange-500 capitalize cursor-pointer {{ $brand == $brandTwo->name ? 'text-orange-500 font-semibold' : '' }}">{{ $brandTwo->name }}</a>
                    </li>
                @endforeach
            </ul>

            <x-jet-button wire:click='clean' class="mt-4 bg-orange-700 hover:bg-orange-600 active:bg-orange-900">
                Eliminar filtros
            </x-jet-button>
        </aside>

        <div class="md:col-span-2 lg:col-span-4">
            @if ($view == 'grid')
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <li class="bg-white rounded-lg shadow ">
                            <article>
                                <figure>
                                    <img class="h-48 w-full object-cover object-center" src="{{ Storage::url($product->images->first()->url) }}">
                                </figure>
                                <div class="py-4 px-6">
                                    <h1 class="text-lg font-semibold ">
                                        <a href="{{ route('products.show',  $product) }}">{{ Str::limit($product->name, 20, '...') }}</a>
                                    </h1>
                                    <p class="font-bold text-trueGray-700">US$ {{ $product->price }}</p>
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>
            @else
                <ul>
                   @foreach ($products as $product)
                        <x-product-list :product="$product" />
                   @endforeach 
                </ul>
            @endif

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
