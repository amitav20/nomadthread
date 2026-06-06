@extends('layouts.admin')

@section('title', 'Pages | LeatherCraft')
@section('page_title', 'Pages')
@section('page_breadcrumb', 'Website / Pages')

@section('content')
@if(session('success'))
  <div style="background:rgba(39,174,96,.15); border:1px solid var(--green); color:var(--green); padding:16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:13.5px;">
    <strong>Success!</strong> {{ session('success') }}
  </div>
@endif
<div class="page-header">
  <div><div class="page-heading">Pages</div><div class="page-subheading">Manage all static website pages</div></div>
  <div class="page-actions"><a href="{{ route('backend.pages.create') }}" class="btn btn-gold"><i class="ti ti-plus"></i> Add Page</a></div>
</div>
<div class="card">
  <div class="card-head"><div class="card-title">All Pages</div></div>
  <div class="table-wrap"><table>
    <thead><tr><th>Page Title</th><th>Slug</th><th>Template</th><th>Last Updated</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($pages as $page)
        <tr>
          <td style="font-weight: 500; color: var(--text);">{{ $page->title }}</td>
          <td style="font-family:monospace;font-size:12px;color:var(--text3)">/pages/{{ $page->slug }}</td>
          <td>{{ $page->template ?? 'Default' }}</td>
          <td>{{ $page->updated_at ? $page->updated_at->format('d M Y') : 'Recent' }}</td>
          <td><span class="badge @if($page->status == 'Published') badge-green @else badge-gray @endif">{{ $page->status }}</span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('backend.pages.edit', $page->id) }}" class="btn btn-outline btn-sm"><i class="ti ti-edit"></i></a>
              <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-outline btn-sm"><i class="ti ti-eye"></i></a>
              <form action="{{ route('backend.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; padding: 20px;">No pages found.</td></tr>
      @endforelse
    </tbody>
  </table></div>
  <div class="pagination">
    <span style="font-size:13px;color:var(--text3);">Showing 1–{{ count($pages) }} of {{ count($pages) }} pages</span>
    <a href="{{ route('backend.pages.create') }}" class="btn btn-gold btn-sm"><i class="ti ti-plus"></i> Add Page</a>
  </div>
</div>
@endsection
