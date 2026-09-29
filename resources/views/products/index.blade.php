<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-x1">Products</h2>
    </x-slot>

    <div class="py-6 max-w-7x1 mx-auto px-4">
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-3">
                <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Product</a>
            <table id="products" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8 /css/jquery.dataTables.min.css"><script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $('#products').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/api/products-table',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'price' },
                { data: 'created_at' },
            ],
        });
    </script>
</x-app-layout>

'/api/products-table'