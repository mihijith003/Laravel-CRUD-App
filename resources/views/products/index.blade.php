<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Products</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-3">
                @can('create-products')
                <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Product</a>
                @endcan
                <a href="{{ route('products.trash') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">View Trash</a>
                
            </div>
            <table id="products" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $('#products').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/api/products-table',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'description', defaultContent: '' },
                { data: 'price' },
                { data: 'actions', orderable: false, searchable: false },
            ],
        });
    </script>
</x-app-layout>
