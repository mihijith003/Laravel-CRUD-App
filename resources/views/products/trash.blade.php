<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Trash</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-3">
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 underline">Back to products</a>
            </div>

            @if ($products->isEmpty())
                <p class="text-gray-600">Trash is empty.</p>
            @else
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">ID</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Description</th>
                            <th class="py-2">Price</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b">
                                <td class="py-2">{{ $product->id }}</td>
                                <td class="py-2">{{ $product->name }}</td>
                                <td class="py-2">{{ $product->description }}</td>
                                <td class="py-2">{{ $product->price }}</td>
                                <td class="py-2">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Permanently delete this product? This cannot be undone.');">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Delete Permanently</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
