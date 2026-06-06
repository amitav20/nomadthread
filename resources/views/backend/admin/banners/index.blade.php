@extends('layouts.admin')

@section('title', 'Banners & Media | LeatherCraft')
@section('page_title', 'Banners & Media')
@section('page_breadcrumb', 'Marketing / Banners')

@section('content')
@if(session('success'))
  <div style="background:rgba(39,174,96,.15); border:1px solid var(--green); color:var(--green); padding:16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:13.5px;">
    <strong>Success!</strong> {{ session('success') }}
  </div>
@endif
<div class="page-header">
  <div><div class="page-heading">Banners & Media</div><div class="page-subheading">Manage all homepage and promotional banners</div></div>
  <div class="page-actions"><a href="{{ route('backend.banners.create') }}" class="btn btn-gold"><i class="ti ti-plus"></i> Upload Banner</a></div>
</div>
<div class="card">
  <div class="card-head"><div class="card-title">Active Banners</div></div>
  <div class="table-wrap"><table>
    <thead><tr><th>Preview</th><th>Banner Details</th><th>Position</th><th>Sort Order</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($banners as $banner)
        <tr>
          <td>
            <div style="width:80px;height:40px;background:linear-gradient(135deg,var(--bg4),var(--bg3));border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:20px;border:1px solid var(--border); overflow: hidden;">
              @if(!empty($banner->image))
                <img src="{{ $banner->image }}" style="width: 100%; height: 100%; object-fit: cover;">
              @elseif(!empty($banner->video))
                <video src="{{ $banner->video }}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>
              @else
                🖼
              @endif
            </div>
          </td>
          <td>
            <div style="font-weight: 500; color: var(--text);">{{ $banner->title }}</div>
            <div style="font-size: 11px; color: var(--text3);">{{ $banner->subheadline }}</div>
          </td>
          <td>{{ $banner->position ?? 'Homepage Hero' }}</td>
          <td>{{ $banner->sort_order }}</td>
          <td><span class="badge @if($banner->status == 'active') badge-green @else badge-red @endif">{{ ucfirst($banner->status) }}</span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('backend.banners.edit', $banner->id) }}" class="btn btn-outline btn-sm"><i class="ti ti-edit"></i></a>
              <form action="{{ route('backend.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; padding: 20px;">No banners found.</td></tr>
      @endforelse
    </tbody>
  </table></div>
</div>
@endsection
