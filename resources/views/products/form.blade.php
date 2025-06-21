<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
        <option value="">-- Select Category --</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
</div>


<div class="mb-3">
    <label class="form-label">Supplier</label>
    <select name="supplier_id" class="form-select" required>
        <option value="">-- Select Supplier --</option>
        @foreach ($suppliers as $sup)
            <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id ?? '') == $sup->id ? 'selected' : '' }}>
                {{ $sup->name }}
            </option>
        @endforeach
    </select>
</div>
