@extends('layout')
@section('content')

<div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">
    <h1 class="text-xl font-bold mb-4">Upload CSV File</h1>

    <!-- Upload form -->
    <form method="post" action="{{ route('upload') }}" class="flex items-center space-x-4 mb-6" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" x-ref="fileInput" class="border p-2 rounded w-full">
        @error('file')
        <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Upload File</button>
    </form>

    <!-- Upload history table -->
    <table class="w-full table-auto border-collapse" id="uploadHistoryTable">
        <thead>
            <tr class="bg-gray-200 text-left text-sm">
                <th class="px-4 py-2">Time</th>
                <th class="px-4 py-2">File Name</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="border-b text-sm">
                <td class="px-4 py-2">{{ $product->created_at->format('d-m-Y, h:i A') .' ('.$product->created_at->diffForHumans().')' }}</td>
                <td class="px-4 py-2">{{ $product->filename }}</td>
                <td class="px-4 py-2 capitalize">{{ $product->status }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="px-4 py-2 text-center">
                    {{ $products->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection