<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    {{-- Stop trying to control. --}}
    <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>
    <div class="grid grid-cols-2 gap-6">
        <div>
            <x-jet-label value="Categorias"/>
            <select class="w-full form-control" wire:model='categoryId'>
                <option value="" selected disabled>Seleccione una categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-jet-label value="Subcategorias"/>
            <select class="w-full form-control" wire:model='subCategoryId'>
                <option value="" selected disabled>Seleccione una subcategoria</option>
                @foreach ($subCategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
