@extends('layouts.admin')

@section('title', 'All Categories | LeatherCraft')
@section('page_title', 'All Categories')
@section('page_breadcrumb', 'Catalogue / Categories')

@section('content')
<div class="page-header">
  <div><div class="page-heading">All Categories</div><div class="page-subheading">Organise your leather product range</div></div>
  <div class="page-actions"><a href="{{ route('backend.categories.create') }}" class="btn btn-gold"><i class="ti ti-plus"></i> Add Category</a></div>
</div>
<div class="card" style="margin-bottom:20px;">
  <div class="cat-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; padding: 20px;">
    @forelse($categories as $cat)
      <div class="cat-card" style="background: var(--bg3); border: 1px solid var(--border); padding: 20px; border-radius: 8px; text-align: center;">
        <div class="cat-icon" style="font-size: 32px; margin-bottom: 8px;">{{ $cat->icon ?? '📁' }}</div>
        <div class="cat-name" style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">{{ $cat->name }}</div>
        <div class="cat-count" style="font-size: 11px; color: var(--text3);">{{ $cat->products_count }} products</div>
      </div>
    @empty
      <div style="padding: 20px; text-align: center; grid-column: 1/-1;">No categories found.</div>
    @endforelse
    <a href="{{ route('backend.categories.create') }}" class="cat-card" style="border:1px dashed var(--border2);background:transparent;text-decoration:none; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 8px; padding: 20px; text-align: center;">
      <div class="cat-icon" style="background:var(--bg4); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 8px;">
        <i class="ti ti-plus" style="font-size:22px;color:var(--text3);"></i>
      </div>
      <div class="cat-name" style="color:var(--text3); font-weight: 500; font-size: 14px;">New Category</div>
      <div class="cat-count" style="color:var(--text3); font-size: 11px;">Add one</div>
    </a>
  </div>
</div>
<div class="card">
  <div class="card-head"><div class="card-title">Category Management</div></div>
  <div class="table-wrap"><table>
    <thead><tr><th>Category</th><th>Slug</th><th>Products</th><th>Revenue (Est)</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($categories as $cat)
        <tr>
          <td style="font-weight: 500;">{{ $cat->name }}</td>
          <td style="font-family:monospace;font-size:12px;color:var(--text3)">{{ $cat->slug }}</td>
          <td>{{ $cat->products_count }}</td>
          <td>₹{{ number_format($cat->products_count * 12500, 0, '.', ',') }}</td>
          <td><span class="badge @if($cat->status == 'active') badge-green @else badge-red @endif">{{ ucfirst($cat->status) }}</span></td>
          <td>
            <div style="display:flex;gap:6px;align-items:center;">
              <a href="{{ route('backend.categories.edit', $cat->id) }}" class="btn btn-outline btn-sm" title="Edit"><i class="ti ti-edit"></i></a>
              <form action="{{ route('backend.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')" style="display:inline-block;margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="ti ti-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; padding: 20px;">No categories found.</td></tr>
      @endforelse
    </tbody>
  </table></div>
</div>
@endsection
