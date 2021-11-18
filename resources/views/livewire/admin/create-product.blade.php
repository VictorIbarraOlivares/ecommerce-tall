<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    {{-- Stop trying to control. --}}
    <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>
    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <x-jet-label value="Categorias"/>
            <select class="w-full form-control" wire:model='categoryId'>
                <option value="" selected disabled>Seleccione una categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for='categoryId' />
        </div>
        <div>
            <x-jet-label value="Subcategorias"/>
            <select class="w-full form-control" wire:model='subCategoryId'>
                <option value="" selected disabled>Seleccione una subcategoria</option>
                @foreach ($subCategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for='subCategoryId' />
        </div>
    </div>
    <div class="mb-4">
        <x-jet-label value="Nombre" />
        <x-jet-input wire:model='name' type="text" class="w-full" placeholder="Ingrese el nombre del producto" />
        <x-jet-input-error for='name' />
    </div>

    <div class="mb-4">
        <x-jet-label value="Slug" />
        <x-jet-input wire:model='slug' type="text" disabled class="w-full bg-gray-200" placeholder="Ingrese el slug del producto" />
        <x-jet-input-error for='slug' />
    </div>
    
    <div class="mb-4">
        <div wire:ignore>
            <x-jet-label value="Descripcion" />
            <textarea x-data
                wire:model='description'
                x-init="ClassicEditor.create( $refs.miEdit )
                    .then(function(edit){
                        edit.model.document.on('change:data', () => {
                            @this.set('description', edit.getData())
                        })
                    })
                    .catch( error => {
                        console.error( error );
                    } );" 
                x-ref="miEdit" class="w-full form-control" rows="8">
            </textarea>
        </div>
        <x-jet-input-error for='description' />
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <x-jet-label value="Marca"/>
            <select class="w-full form-control" wire:model='brandId'>
                <option value="" selected disabled>Seleccione una marca</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for='brandId' />
        </div>
        <div>
            <x-jet-label value="Precio"/>
            <x-jet-input wire:model='price' type="number" class="w-full" placeholder="Ingrese el precio del producto" />
            <x-jet-input-error for='price' />
        </div>
    </div>

    @if ($subCategoryId && !$this->subcategory->color && !$this->subcategory->size)
        <div class="mb-4">
            <x-jet-label value="Cantidad"/>
            <x-jet-input wire:model='quantity' type="number" class="w-full" placeholder="Ingrese la cantidad del producto" />
            <x-jet-input-error for='quantity' />
        </div>
    @endif

    <div class="flex mt-4">
        <x-jet-button wire:click='save' wire:loading.attr='disabled' wire:target='save' class="ml-auto">
            Crear producto
        </x-jet-button>
    </div>
</div>
