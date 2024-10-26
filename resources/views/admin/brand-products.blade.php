@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Products for Brand: {{ $brand->name }}</h2>

        @if($products->isEmpty())
            <p>No products available for this brand.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>

                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>SAR {{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->status == 'active' ? 'Active' : 'Inactive' }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('admin.brands') }}" class="btn btn-secondary">Back to Brands</a>
    </div>
@endsection
