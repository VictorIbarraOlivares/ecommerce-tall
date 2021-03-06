<div>
    <header class="bg-white shadow ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h1>

                <x-jet-danger-button wire:click="$emit('delete-product')">
                    Eliminar
                </x-jet-danger-button>
            </div>
        </div>
    </header>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
        {{-- Stop trying to control. --}}
        <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>
        <div class="mb-4" wire:ignore>
            <form action="{{ route('admin.products.files', $product) }}" method="POST" class="dropzone" id="my-awesome-dropzone">
                @csrf
            </form>
        </div>

        @if ($product->images->count())
            <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
                <h1 class="text-xl text-center font-semibold mb-2">Imagenes del producto</h1>

                <ul class="flex flex-wrap">
                    @foreach ($product->images as $image)
                        <li class="relative" wire:key='image-{{ $image->id }}'>
                            <img class="w-32 h-20 object-cover" src="{{ Storage::url($image->url) }}" >
                            <x-jet-danger-button wire:click='deleteImage({{ $image->id }})' wire:loading.attr='disabled' wire:target='deleteImage({{ $image->id }})' class="absolute right-2 top-2">
                                x
                            </x-jet-danger-button>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @livewire('admin.status-product', ['product' => $product], key('status-product-'.$product->id))
        
        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="grid grid-cols-2 gap-6 mb-4">
                <div>
                    <x-jet-label value="Categorias"/>
                    <select class="w-full form-control" wire:model='category_id'>
                        <option value="" selected disabled>Seleccione una categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='category_id' />
                </div>
                <div>
                    <x-jet-label value="Subcategorias"/>
                    <select class="w-full form-control" wire:model='product.subcategory_id'>
                        <option value="" selected disabled>Seleccione una subcategoria</option>
                        @foreach ($subCategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='product.subcategory_id' />
                </div>
            </div>
        
            <div class="mb-4">
                <x-jet-label value="Nombre" />
                <x-jet-input wire:model='product.name' type="text" class="w-full" placeholder="Ingrese el nombre del producto" />
                <x-jet-input-error for='product.name' />
            </div>
        
            <div class="mb-4">
                <x-jet-label value="Slug" />
                <x-jet-input wire:model='product.slug' type="text" disabled class="w-full bg-gray-200" placeholder="Ingrese el slug del producto" />
                <x-jet-input-error for='product.slug' />
            </div>
            
            <div class="mb-4">
                <div wire:ignore>
                    <x-jet-label value="Descripcion" />
                    <textarea x-data
                        wire:model='product.description'
                        x-init="ClassicEditor.create( $refs.miEdit )
                            .then(function(edit){
                                edit.model.document.on('change:data', () => {
                                    @this.set('product.description', edit.getData())
                                })
                            })
                            .catch( error => {
                                console.error( error );
                            } );" 
                        x-ref="miEdit" class="w-full form-control" rows="8">
                    </textarea>
                </div>
                <x-jet-input-error for='product.description' />
            </div>
        
            <div class="grid grid-cols-2 gap-6 mb-4">
                <div>
                    <x-jet-label value="Marca"/>
                    <select class="w-full form-control" wire:model='product.brand_id'>
                        <option value="" selected disabled>Seleccione una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='product.brand_id' />
                </div>
                <div>
                    <x-jet-label value="Precio"/>
                    <x-jet-input wire:model='product.price' type="number" class="w-full" placeholder="Ingrese el precio del producto" />
                    <x-jet-input-error for='product.price' />
                </div>
            </div>
        
            @if ($this->subcategory && !$this->subcategory->color && !$this->subcategory->size)
                <div class="mb-4">
                    <x-jet-label value="Cantidad"/>
                    <x-jet-input wire:model='product.quantity' type="number" class="w-full" placeholder="Ingrese la cantidad del producto" />
                    <x-jet-input-error for='product.quantity' />
                </div>
            @endif
        
            <div class="flex mt-4 justify-end items-center">
                <x-jet-action-message class="mr-3" on="saved">
                    Actualizado
                </x-jet-action-message>

                <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save' >
                    Actualizar producto
                </x-jet-button>
            </div>
        </div>

        @if ($this->subcategory)
            @if ($this->subcategory->size)
                @livewire('admin.size-product', ['product' => $product], key('size-product-'.$product->id))
            @elseif ($this->subcategory->color)
                @livewire('admin.color-product', ['product' => $product], key('color-product-'.$product->id))
            @endif
        @endif
    </div>

    @push('script')
        <script>
            Dropzone.options.myAwesomeDropzone = { // camelized version of the `id`
                // headers: {
                //     'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                // },
                acceptedFiles: 'image/*',
                dictDefaultMessage: 'Arrastre una imagen al recuadro',
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                complete (file) {
                    this.removeFile(file);
                },
                queuecomplete() {
                    Livewire.emit('refreshProduct');
                },
                // accept: function(file, done) {
                //     if (file.name == "justinbieber.jpg") {
                //     done("Naha, you don't.");
                //     }
                //     else { done(); }
                // }
            };
            Livewire.on('delete-size-product', product_size_id => {
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
                        Livewire.emitTo('admin.size-product','deleteSize', product_size_id);
                        Swal.fire(
                        'Eliminado!',
                        '',
                        'success'
                        )
                    }
                })
            })
            Livewire.on('delete-color-product', pivot => {
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
                        Livewire.emitTo('admin.color-product','deleteColor', pivot);
                        Swal.fire(
                        'Eliminado!',
                        '',
                        'success'
                        )
                    }
                })
            })
            Livewire.on('delete-color-size', pivot => {
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
                        Livewire.emitTo('admin.color-size','deleteColor', pivot);
                        Swal.fire(
                        'Eliminado!',
                        '',
                        'success'
                        )
                    }
                })
            })

            Livewire.on('delete-product', () => {
                Swal.fire({
                    title: 'Eliminar?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.edit-product','delete');
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