@extends('layouts.admin')

@section('title', 'Edit Product | LeatherCraft')
@section('page_title', 'Edit Product')
@section('page_breadcrumb', 'Catalogue / Edit Product')

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

<form action="{{ route('backend.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  
  <div class="page-header">
    <div><div class="page-heading">Edit Product: {{ $product->name }}</div><div class="page-subheading">Update leather product specifications and catalogue values</div></div>
    <div class="page-actions">
      <a href="{{ route('backend.products.index') }}" class="btn btn-outline"><i class="ti ti-x"></i> Cancel</a>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Update Product</button>
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
            <input type="text" name="name" class="form-input" placeholder="e.g. Milano Full-Grain Leather Tote Bag" value="{{ old('name', $product->name) }}" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">SKU / Product Code <span>*</span></label>
              <input type="text" name="sku" class="form-input" placeholder="e.g. LTH-001" value="{{ old('sku', $product->sku) }}" required>
              <div class="form-hint">Unique identifier for inventory</div>
            </div>
            <div class="form-group">
              <label class="form-label">Product Type / Subtitle</label>
              <input type="text" name="type" class="form-input" placeholder="e.g. Tote Bag, Slim Wallet" value="{{ old('type', $product->type) }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Full Description</label>
            <textarea name="description" class="form-input" style="min-height:130px;" placeholder="Describe the product in detail — materials, craftsmanship, features, care instructions…">{{ old('description', $product->description) }}</textarea>
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
              <input type="number" name="price" class="form-input" placeholder="0" min="0" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Sale / Old Price (₹)</label>
              <input type="number" name="old_price" class="form-input" placeholder="0" min="0" value="{{ old('old_price', $product->old_price) }}">
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
              <input type="number" name="stock_quantity" class="form-input" placeholder="0" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Low Stock Alert</label>
              <input type="number" name="low_stock_alert" class="form-input" placeholder="10" min="0" value="{{ old('low_stock_alert', $product->low_stock_alert) }}">
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
            <input type="text" name="colors" class="form-input" placeholder="e.g. tan,espresso,black,wine" value="{{ old('colors', is_array($product->colors) ? implode(',', $product->colors) : $product->colors) }}">
            <div class="form-hint">Supported design colors: tan, espresso, cognac, black, olive, wine, camel, slate</div>
          </div>
          <div class="form-group">
            <label class="form-label">Available Sizes (comma separated)</label>
            <input type="text" name="sizes" class="form-input" placeholder="e.g. Small, Medium, Large" value="{{ old('sizes', is_array($product->sizes) ? implode(',', $product->sizes) : $product->sizes) }}">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Visual Shape Style</label>
              <select name="shape" class="form-input">
                <option value="bag-shape" {{ old('shape', $product->shape) == 'bag-shape' ? 'selected' : '' }}>Bag Silhouette</option>
                <option value="wallet-shape" {{ old('shape', $product->shape) == 'wallet-shape' ? 'selected' : '' }}>Wallet Silhouette</option>
                <option value="tote-shape" {{ old('shape', $product->shape) == 'tote-shape' ? 'selected' : '' }}>Tote Silhouette</option>
                <option value="belt-shape" {{ old('shape', $product->shape) == 'belt-shape' ? 'selected' : '' }}>Belt Silhouette</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Badge Label</label>
              <select name="badge" class="form-input">
                <option value="" {{ old('badge', $product->badge) == '' ? 'selected' : '' }}>None</option>
                <option value="new" {{ old('badge', $product->badge) == 'new' ? 'selected' : '' }}>New</option>
                <option value="sale" {{ old('badge', $product->badge) == 'sale' ? 'selected' : '' }}>Sale</option>
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
              <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active (Visible on website)</option>
              <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Draft (Hidden)</option>
            </select>
          </div>
          <button type="submit" class="btn btn-gold btn-block btn-lg"><i class="ti ti-device-floppy"></i> Update Product</button>
        </div>
      </div>

      <!-- Category -->
      <div class="card">
        <div class="card-head"><div class="card-title">Product Category</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Category <span>*</span></label>
            <select name="category_id" class="form-input" required>
              <option value="">— Select Category —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <!-- Product Images -->
      <div class="card" style="margin-top:20px;">
        <div class="card-head"><div class="card-title"><i class="ti ti-photo" style="margin-right:8px;color:var(--gold)"></i>Product Images</div></div>
        <div class="card-body">
          @if($product->images->isNotEmpty())
            <div style="margin-bottom: 20px;">
              <label class="form-label" style="margin-bottom: 12px; display: block;">Existing Images</label>
              <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($product->images as $img)
                  <div style="display: flex; gap: 16px; align-items: flex-start; padding: 12px; background: var(--bg3); border: 1px solid var(--border); border-radius: 8px;">
                    <div style="width: 80px; height: 80px; border-radius: 6px; overflow: hidden; background: var(--bg4); border: 1px solid var(--border); flex-shrink: 0;">
                      <img src="{{ $img->image_path }}" alt="{{ $img->alt_text }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 8px;">
                      <div class="form-group" style="margin: 0;">
                        <input type="text" name="alt_texts[{{ $img->id }}]" class="form-input" placeholder="Alt text (SEO)" value="{{ old('alt_texts.'.$img->id, $img->alt_text) }}" style="padding: 6px 10px; font-size: 12px;">
                      </div>
                      <div style="display: flex; gap: 12px; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                          <span style="font-size: 11px; color: var(--text3);">Order:</span>
                          <input type="number" name="sort_orders[{{ $img->id }}]" class="form-input" value="{{ old('sort_orders.'.$img->id, $img->sort_order) }}" style="width: 50px; padding: 4px 6px; font-size: 12px; text-align: center;">
                        </div>
                        <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; cursor: pointer; color: var(--text2);">
                          <input type="radio" name="is_primary_id" value="{{ $img->id }}" {{ $img->is_primary ? 'checked' : '' }}>
                          Primary
                        </label>
                        <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; cursor: pointer; color: var(--red);">
                          <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                          Delete
                        </label>
                      </div>
                      <div style="font-size: 10px; color: var(--text3);">
                        {{ strtoupper($img->mime_type) }} &bull; {{ round($img->file_size / 1024) }} KB &bull; {{ $img->width }}x{{ $img->height }}px
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <div class="form-group" style="margin-top: 16px;">
            <label class="form-label">Upload New Images</label>
            <input type="file" name="images[]" class="form-input" multiple accept="image/*" style="padding: 10px 14px;">
            <div class="form-hint" style="margin-top:8px;">Select one or more images. Allowed types: JPEG, PNG, JPG, GIF, WebP. Max size: 5MB per image.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
