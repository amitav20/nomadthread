@extends('layouts.admin')

@section('title', 'All Products | LeatherCraft')
@section('page_title', 'All Products')
@section('page_breadcrumb', 'Catalogue / Products')

@section('content')
<div class="page-header">
  <div><div class="page-heading">All Products</div><div class="page-subheading">{{ count($products) }} products in your catalogue</div></div>
  <div class="page-actions">
    <button class="btn btn-outline" onclick="alert('CSV import flow simulated!')"><i class="ti ti-file-import"></i> Import CSV</button>
    <a href="{{ route('backend.products.create') }}" class="btn btn-gold"><i class="ti ti-plus"></i> Add Product</a>
  </div>
</div>
<div class="filter-bar">
  <div class="search-box"><i class="ti ti-search" style="color:var(--text3)"></i><input type="text" placeholder="Search products…"></div>
  <select class="form-input" style="width:150px"><option>All Categories</option><option>Bags & Totes</option><option>Wallets</option><option>Belts</option></select>
  <select class="form-input" style="width:130px"><option>All Status</option><option>Active</option><option>Draft</option><option>Out of Stock</option></select>
  <select class="form-input" style="width:150px"><option>Sort: Newest</option><option>Sort: Price ↑</option><option>Sort: Price ↓</option><option>Sort: Best Seller</option></select>
</div>
<div class="card">
  <div class="tab-row">
    <div class="tab-item active">All ({{ count($products) }})</div>
    <div class="tab-item">Active ({{ $products->where('stock_quantity', '>', 0)->count() }})</div>
    <div class="tab-item">Draft (0)</div>
    <div class="tab-item">Out of Stock ({{ $products->where('stock_quantity', '<=', 0)->count() }})</div>
  </div>
  <div class="table-wrap"><table>
    <thead><tr><th class="check-col"><input type="checkbox"></th><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Sales</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($products as $p)
        <tr>
          <td><input type="checkbox"></td>
          <td>
            <div class="product-info">
              <div class="product-thumb" style="display:flex; align-items:center; justify-content:center;">
                @if($p->images && $p->images->count() > 0)
                  @php
                    $primaryImg = $p->images->firstWhere('is_primary', true) ?? $p->images->first();
                  @endphp
                  <img src="{{ asset(ltrim($primaryImg->image_path, '/')) }}" alt="{{ $p->name }}">
                @else
                  <div class="product-visual {{ $p->shape }}" style="transform: scale(0.35); width: 80px; height: 80px; flex-shrink: 0; background-color: transparent;"></div>
                @endif
              </div>
              <div>
                <div class="product-name">{{ $p->name }}</div>
                <div class="product-sku">{{ $p->sku }}</div>
              </div>
            </div>
          </td>
          <td>{{ $p->category->name ?? 'Uncategorized' }}</td>
          <td>₹{{ number_format($p->price, 0, '.', ',') }}</td>
          <td>{{ $p->stock_quantity }}</td>
          <td>{{ $p->id * 14 + 18 }}</td>
          <td>
            @if($p->stock_quantity <= 0)
              <span class="badge badge-red">Out of Stock</span>
            @elseif($p->stock_quantity <= $p->low_stock_alert)
              <span class="badge badge-amber">Low Stock</span>
            @else
              <span class="badge badge-green">Active</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;align-items:center;">
              <a href="{{ route('backend.products.edit', $p->id) }}" class="btn btn-outline btn-sm" title="Edit"><i class="ti ti-edit"></i></a>
              <form action="{{ route('backend.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')" style="display:inline-block;margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="ti ti-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center; padding: 20px;">No products found.</td></tr>
      @endforelse
    </tbody>
  </table></div>
  <div class="pagination"><span style="font-size:13px;color:var(--text3);">Showing 1–{{ count($products) }} of {{ count($products) }}</span><div style="display:flex;gap:6px;"><button class="btn btn-outline btn-sm"><i class="ti ti-chevron-left"></i></button><button class="btn btn-outline btn-sm" style="background:rgba(201,168,76,.1);color:var(--gold2);border-color:var(--gold-dim);">1</button><button class="btn btn-outline btn-sm"><i class="ti ti-chevron-right"></i></button></div></div>
</div>
@endsection
