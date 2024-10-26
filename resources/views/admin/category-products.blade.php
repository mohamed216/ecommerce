@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Products for Category: {{ $category->name }}</h2>

        @if($products->isEmpty())
            <p>No products available for this category.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->status == 'active' ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            {{ $products->links() }}
        @endif

        <a href="{{ route('admin.categories') }}" class="btn btn-secondary mt-3">Back to Categories</a>
    </div>
@endsection
