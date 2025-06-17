<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Category</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $product->category ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Quantity</label>
    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Supplier</label>
    <input type="text" name="supplier" class="form-control" value="{{ old('supplier', $product->supplier ?? '') }}">
</div>
