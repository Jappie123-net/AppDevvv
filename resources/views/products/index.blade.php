@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Product List</h2>
        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
            @endif
        @endauth
    </div>

    {{-- Search and Filter Form --}}
    <form method="GET" action="{{ route('products.index') }}" class="row mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="supplier" class="form-select">
                <option value="">All Suppliers</option>
                @foreach ($suppliers as $sup)
                    <option value="{{ $sup }}" {{ request('supplier') == $sup ? 'selected' : '' }}>
                        {{ $sup }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- <div class="col-md-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div> -->
    </form>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Products Table --}}
    @if($products->count())
        <table class="table table-striped table-bordered align-middle">
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

                    <th><a href="{{ sortUrl('name') }}" class="text-white text-decoration-none">Name {{ sortIcon('name') }}</a></th>
                    <th><a href="{{ sortUrl('category_id') }}" class="text-white text-decoration-none">Category {{ sortIcon('category_id') }}</a></th>
                    <th><a href="{{ sortUrl('price') }}" class="text-white text-decoration-none">Price {{ sortIcon('price') }}</a></th>
                    <th><a href="{{ sortUrl('quantity') }}" class="text-white text-decoration-none">Quantity {{ sortIcon('quantity') }}</a></th>
                    <th><a href="{{ sortUrl('supplier_id') }}" class="text-white text-decoration-none">Supplier {{ sortIcon('supplier_id') }}</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>
                        @if ($product->quantity < 5)
                            <span class="badge bg-danger">Low ({{ $product->quantity }})</span>
                        @elseif ($product->quantity <= 10)
                            <span class="badge bg-warning text-dark">Medium ({{ $product->quantity }})</span>
                        @else
                            <span class="badge bg-success">{{ $product->quantity }}</span>
                        @endif

                        @auth
                            @if (auth()->user()->role === 'admin')
                                <form action="{{ route('products.sell', $product) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    <input type="number" name="quantity" min="1" max="{{ $product->quantity }}" style="width: 60px;" required>
                                    <button class="btn btn-sm btn-outline-info">Sell</button>
                                </form>

                                <form action="{{ route('products.addQuantity', $product) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <input type="number" name="quantity" min="1" style="width: 60px;" required>
                                    <button class="btn btn-sm btn-outline-success">Add</button>
                                </form>
                            @endif
                        @endauth
                    </td>
                    <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                    <td>
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline mb-1" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No products found.</p>
    @endif

    {{-- Auto-submit Filter Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('input[name="search"]');
            const categorySelect = document.querySelector('select[name="category"]');
            const supplierSelect = document.querySelector('select[name="supplier"]');

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

            if (supplierSelect) {
                supplierSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });
    </script>
@endsection
