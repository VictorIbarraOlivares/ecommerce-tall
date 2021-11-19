<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    {{-- Stop trying to control. --}}
    <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>
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