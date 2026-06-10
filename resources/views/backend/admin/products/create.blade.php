@extends('layouts.admin')

@section('title', 'Add Product | LeatherCraft')
@section('page_title', 'Add Product')
@section('page_breadcrumb', 'Catalogue / Add Product')

@section('content')
@if ($errors->any())
  <div style="background:rgba(192,57,43,.1); border:1px solid var(--red); color:var(--red2); padding:16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:13.5px;">
    <strong>Whoops! Something went wrong:</strong>
    <ul style="margin-top:6px; padding-left:20px;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('backend.products.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  
  <div class="page-header">
    <div><div class="page-heading">Add New Product</div><div class="page-subheading">Fill in all details to list a new leather product</div></div>
    <div class="page-actions">
      <a href="{{ route('backend.products.index') }}" class="btn btn-outline"><i class="ti ti-x"></i> Cancel</a>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Publish Product</button>
    </div>
  </div>

  <div class="form-layout">
    <!-- LEFT COLUMN -->
    <div>
      <!-- Basic Info -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-info-circle" style="margin-right:8px;color:var(--gold)"></i>Basic Information</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Product Name <span>*</span></label>
            <input type="text" name="name" class="form-input" placeholder="e.g. Milano Full-Grain Leather Tote Bag" value="{{ old('name') }}" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">SKU / Product Code <span>*</span></label>
              <input type="text" name="sku" class="form-input" placeholder="e.g. LTH-001" value="{{ old('sku') }}" required>
              <div class="form-hint">Unique identifier for inventory</div>
            </div>
            <div class="form-group">
              <label class="form-label">Product Type / Subtitle</label>
              <input type="text" name="type" class="form-input" placeholder="e.g. Tote Bag, Slim Wallet" value="{{ old('type') }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Full Description</label>
            <textarea name="description" class="form-input" style="min-height:130px;" placeholder="Describe the product in detail — materials, craftsmanship, features, care instructions…">{{ old('description') }}</textarea>
          </div>
        </div>
      </div>

      <!-- Pricing -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-currency-rupee" style="margin-right:8px;color:var(--gold)"></i>Pricing</div></div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Regular Price (₹) <span>*</span></label>
              <input type="number" name="price" class="form-input" placeholder="0" min="0" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Sale / Old Price (₹)</label>
              <input type="number" name="old_price" class="form-input" placeholder="0" min="0" value="{{ old('old_price') }}">
            </div>
          </div>
        </div>
      </div>

      <!-- Inventory -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-stack" style="margin-right:8px;color:var(--gold)"></i>Inventory</div></div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Stock Quantity <span>*</span></label>
              <input type="number" name="stock_quantity" class="form-input" placeholder="0" min="0" value="{{ old('stock_quantity', 15) }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Low Stock Alert</label>
              <input type="number" name="low_stock_alert" class="form-input" placeholder="10" min="0" value="{{ old('low_stock_alert', 5) }}">
            </div>
          </div>
        </div>
      </div>

      <!-- Variants -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-adjustments" style="margin-right:8px;color:var(--gold)"></i>Variants & Visuals</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Available Colors (comma separated)</label>
            <input type="text" name="colors" class="form-input" placeholder="e.g. tan,espresso,black,wine" value="{{ old('colors', 'tan,espresso,black') }}">
            <div class="form-hint">Supported design colors: tan, espresso, cognac, black, olive, wine, camel, slate</div>
          </div>
          <div class="form-group">
            <label class="form-label">Available Sizes (comma separated)</label>
            <input type="text" name="sizes" class="form-input" placeholder="e.g. Small, Medium, Large" value="{{ old('sizes', 'N/A') }}">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Visual Shape Style</label>
              <select name="shape" class="form-input">
                <option value="bag-shape" {{ old('shape') == 'bag-shape' ? 'selected' : '' }}>Bag Silhouette</option>
                <option value="wallet-shape" {{ old('shape') == 'wallet-shape' ? 'selected' : '' }}>Wallet Silhouette</option>
                <option value="tote-shape" {{ old('shape') == 'tote-shape' ? 'selected' : '' }}>Tote Silhouette</option>
                <option value="belt-shape" {{ old('shape') == 'belt-shape' ? 'selected' : '' }}>Belt Silhouette</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Badge Label</label>
              <select name="badge" class="form-input">
                <option value="" {{ old('badge') == '' ? 'selected' : '' }}>None</option>
                <option value="new" {{ old('badge') == 'new' ? 'selected' : '' }}>New</option>
                <option value="sale" {{ old('badge') == 'sale' ? 'selected' : '' }}>Sale</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div>
      <!-- Publish -->
      <div class="card">
        <div class="card-head"><div class="card-title">Publish</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Product Status</label>
            <select name="status" class="form-input">
              <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Visible on website)</option>
              <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Draft (Hidden)</option>
            </select>
          </div>
          <button type="submit" class="btn btn-gold btn-block btn-lg"><i class="ti ti-device-floppy"></i> Publish Product</button>
        </div>
      </div>

      <!-- Category -->
      <div class="card">
        <div class="card-head"><div class="card-title">Product Category</div></div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Category <span>*</span></label>
            <select name="category_id" class="form-input" required>
              <option value="">— Select Category —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <!-- Target Audience -->
      <div class="card" style="margin-top: 20px;">
        <div class="card-head"><div class="card-title">Target Audience</div></div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Gender Selection</label>
            <select name="gender" class="form-input">
              <option value="unisex" {{ old('gender', 'unisex') == 'unisex' ? 'selected' : '' }}>Unisex (Both)</option>
              <option value="men" {{ old('gender') == 'men' ? 'selected' : '' }}>Men (M)</option>
              <option value="women" {{ old('gender') == 'women' ? 'selected' : '' }}>Women (F)</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Product Images -->
      <div class="card" style="margin-top:20px;">
        <div class="card-head"><div class="card-title"><i class="ti ti-photo" style="margin-right:8px;color:var(--gold)"></i>Product Images</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Upload Images</label>
            <input type="file" name="images[]" class="form-input" multiple accept="image/*" style="padding: 10px 14px;">
            <div class="form-hint" style="margin-top:8px;">Select one or more images. Allowed types: JPEG, PNG, JPG, GIF, WebP. Max size: 5MB per image. The first image will be set as primary.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
