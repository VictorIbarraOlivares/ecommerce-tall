@props(['product'])
<li class="bg-white rounded-lg shadow mb-4">
    <article class="md:flex">
        <figure>
            <img class="h-48 w-full md:w-56 object-cover object-center" src="{{ Storage::url($product->images->first()->url) }}">
        </figure>
        <div class="flex-1 py-4 px-6 flex flex-col">
            <div class="lg:flex justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h1>
                    <p class="font-bold text-gray-700">USD {{ $product->price }}</p>
                </div>
                <div>
                    <div class="flex items-center">
                        <ul class="flex text-sm">
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $product->rating >= 1 ? 'yellow' : 'gray' }}-400"></i>
                            </li>
            
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $product->rating >= 2 ? 'yellow' : 'gray' }}-400"></i>
                            </li>
            
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $product->rating >= 3 ? 'yellow' : 'gray' }}-400"></i>
                            </li>
            
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $product->rating >= 4 ? 'yellow' : 'gray' }}-400"></i>
                            </li>
            
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $product->rating == 5 ? 'yellow' : 'gray' }}-400"></i>
                            </li>
                        </ul>
                        <span class="text-gray-700 text-sm">(24)</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 md:mt-auto mb-2">
                <x-danger-link href="{{ route('products.show', $product) }}">
                    más información
                </x-danger-link>
            </div>
        </div>
    </article>
</li>