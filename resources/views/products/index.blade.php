@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    {{-- Search and Filter Form --}}
    <form method="GET" action="{{ route('products.index') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Products Table --}}
    @if($products->count())
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    @php
                        function sortUrl($field) {
                            $currentSort = request('sort_by', 'name');
                            $currentOrder = request('order', 'asc');
                            $toggleOrder = ($currentSort === $field && $currentOrder === 'asc') ? 'desc' : 'asc';
                            return route('products.index', array_merge(request()->except(['sort_by', 'order']), ['sort_by' => $field, 'order' => $toggleOrder]));
                        }
                        function sortIcon($field) {
                            return request('sort_by') === $field ? (request('order') === 'asc' ? '▲' : '▼') : '';
                        }
                    @endphp

                    <th>
                        <a href="{{ sortUrl('name') }}" class="text-white text-decoration-none">
                            Name {{ sortIcon('name') }}
                        </a>
                    </th>
                    <th>
                        <a href="{{ sortUrl('category') }}" class="text-white text-decoration-none">
                            Category {{ sortIcon('category') }}
                        </a>
                    </th>
                    <th>
                        <a href="{{ sortUrl('price') }}" class="text-white text-decoration-none">
                            Price {{ sortIcon('price') }}
                        </a>
                    </th>
                    <th>
                        <a href="{{ sortUrl('quantity') }}" class="text-white text-decoration-none">
                            Quantity {{ sortIcon('quantity') }}
                        </a>
                    </th>
                    <th>
                        <a href="{{ sortUrl('supplier') }}" class="text-white text-decoration-none">
                            Supplier {{ sortIcon('supplier') }}
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>₱{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->supplier }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No products found.</p>
    @endif

    {{-- Auto-submit Search/Filter Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('input[name="search"]');
            const categorySelect = document.querySelector('select[name="category"]');

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(this.dataset.timer);
                    this.dataset.timer = setTimeout(() => {
                        this.form.submit();
                    }, 600);
                });
            }

            if (categorySelect) {
                categorySelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });
    </script>
@endsection
