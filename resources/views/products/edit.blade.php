<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Product</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name', $product->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="4"
                              class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="price" value="Price" />
                    <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full"
                                  :value="old('price', $product->price)" required />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>Update Product</x-primary-button>
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 underline">Back to products</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
