@extends('layout')
@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">
    <h1 class="text-2xl font-bold mb-6">Products</h1>


    <!-- Product Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left text-sm text-gray-700">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Unique Key</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Style</th>
                    <th class="px-4 py-2">Size</th>
                    <th class="px-4 py-2">Color</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                <tr class="border-b text-sm hover:bg-gray-50">
                    <td class="px-4 py-2">{{ ($products->currentpage()-1) * $products->perpage() + $key + 1 }}</td>
                    <td class="px-4 py-2">{{ $product->unique_key }}</td>
                    <td class="px-4 py-2">{{ $product->product_title }}</td>
                    <td class="px-4 py-2">{{ $product->product_description }}</td>
                    <td class="px-4 py-2">{{ $product->style }}</td>
                    <td class="px-4 py-2">{{ $product->size }}</td>
                    <td class="px-4 py-2">{{ $product->color_name }}</td>
                    <td class="px-4 py-2">RM {{ number_format($product->piece_price, 2) }}</td>
                    <td class="px-4 py-2">{{ $product->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-4 text-center text-gray-500">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links('pagination::tailwind') }}
    </div>
</div>
@endsection