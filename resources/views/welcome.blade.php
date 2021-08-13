<x-app-layout>
    <div class="container py-8">
        @foreach ($categories as $category)
            <section class="mb-6 ">
                <div class="flex items-center mb-2">
                    <h1 class="text-lg uppercase font-semibold text-gray-700">
                        {{ $category->name }}
                    </h1>
                    <a href="{{ route("categories.show", $category) }}" class="text-orange-500 ml-2 font-semibold hover:text-orange-400 hover:underline">Ver más</a>
                </div>

                @livewire('category-products', ['category' => $category])
            </section>
        @endforeach
    </div>

    @push('script')
        <script>
            Livewire.on('glider', function(id) {
                new Glider(document.querySelector(`.glider-${id}`), {
                    // Mobile-first defaults
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    draggable: true,
                    dots: `.glider-${id}~ .dots`,
                    arrows: {
                        prev: `.glider-${id}~ .glider-prev`,
                        next: `.glider-${id}~ .glider-next`
                    },
                    responsive: [{
                        // screens greater than >= 640px
                        breakpoint: 640,
                        settings: {
                            // Set to `auto` and provide item width to adjust to viewport
                            slidesToShow: 2.5,
                            slidesToScroll: 2,
                            duration: 0.25
                        }
                    }, {
                        // screens greater than >= 768px
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3,
                            duration: 0.25
                        }
                    }, {
                        // screens greater than >= 1024px
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4.5,
                            slidesToScroll: 4,
                            duration: 0.25
                        }
                    }, {
                        // screens greater than >= 1280px
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 5.5,
                            slidesToScroll: 5,
                            duration: 0.25
                        }
                    }]
                });
            })
        </script>
    @endpush
</x-app-layout>
