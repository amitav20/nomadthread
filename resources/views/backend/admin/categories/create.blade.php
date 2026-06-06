@extends('layouts.admin')

@section('title', 'Add Category | LeatherCraft')
@section('page_title', 'Add Category')
@section('page_breadcrumb', 'Catalogue / Add Category')

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

<form action="{{ route('backend.categories.store') }}" method="POST">
  @csrf
  
  <div class="page-header">
    <div><div class="page-heading">Add New Category</div><div class="page-subheading">Create a new product category for your leather store</div></div>
    <div class="page-actions">
      <a href="{{ route('backend.categories.index') }}" class="btn btn-outline"><i class="ti ti-x"></i> Cancel</a>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Save Category</button>
    </div>
  </div>

  <div class="form-layout">
    <div>
      <!-- Basic Info -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-tag" style="margin-right:8px;color:var(--gold)"></i>Category Details</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Category Name <span>*</span></label>
            <input type="text" name="name" class="form-input" placeholder="e.g. Bags & Totes" id="catName" value="{{ old('name') }}" oninput="updateCatSlug()" required>
          </div>
          <div class="form-group">
            <label class="form-label">URL Slug <span>*</span></label>
            <div style="display:flex;gap:0;">
              <div style="padding:10px 12px;background:var(--bg4);border:1px solid var(--border);border-right:none;border-radius:8px 0 0 8px;font-size:12px;color:var(--text3);white-space:nowrap;">leathercraft.in/</div>
              <input type="text" name="slug" class="form-input" style="border-radius:0 8px 8px 0;" id="catSlug" value="{{ old('slug') }}" placeholder="bags-totes" required>
            </div>
            <div class="form-hint">Auto-generated from name. Edit if needed.</div>
          </div>
          <div class="form-group">
            <label class="form-label">Short Description</label>
            <textarea name="description" class="form-input" style="min-height:90px;" placeholder="Brief description shown on the category page header…">{{ old('description') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Category Icon (emoji)</label>
            <input type="text" name="icon" id="catIcon" class="form-input" placeholder="👜" value="{{ old('icon', '👜') }}" style="font-size:22px;text-align:center;">
            <div class="form-hint">Used in sidebar and category cards</div>
            <div style="margin-top:10px;">
              <div class="icon-picker" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <div class="icon-pick-item selected" style="padding: 6px; border: 1px solid var(--border); cursor: pointer;" onclick="selectIcon(this,'👜')">👜</div>
                <div class="icon-pick-item" style="padding: 6px; border: 1px solid var(--border); cursor: pointer;" onclick="selectIcon(this,'👛')">👛</div>
                <div class="icon-pick-item" style="padding: 6px; border: 1px solid var(--border); cursor: pointer;" onclick="selectIcon(this,'💼')">💼</div>
                <div class="icon-pick-item" style="padding: 6px; border: 1px solid var(--border); cursor: pointer;" onclick="selectIcon(this,'🎒')">🎒</div>
                <div class="icon-pick-item" style="padding: 6px; border: 1px solid var(--border); cursor: pointer;" onclick="selectIcon(this,'👝')">👝</div>
                <div class="icon-pick-item" style="padding: 6px; border: 1px solid var(--border); cursor: pointer;" onclick="selectIcon(this,'🪙')">🪙</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <!-- Display Settings -->
      <div class="card">
        <div class="card-head"><div class="card-title">Display Settings</div></div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
              <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Visible)</option>
              <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Hidden</option>
            </select>
          </div>
          <div class="divider" style="margin: 20px 0;"></div>
          
          <!-- Accent Color -->
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Category Theme Color</label>
            <input type="text" name="accent_color" class="form-input" value="{{ old('accent_color', '#c9a84c') }}" placeholder="#c9a84c">
          </div>
          
          <button type="submit" class="btn btn-gold btn-block" style="margin-top: 20px;"><i class="ti ti-device-floppy"></i> Save Category</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  function updateCatSlug() {
    const name = document.getElementById('catName').value;
    const slug = name.toLowerCase()
      .replace(/[^a-z0-9 -]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
    document.getElementById('catSlug').value = slug;
  }

  function selectIcon(element, icon) {
    document.querySelectorAll('.icon-pick-item').forEach(item => item.classList.remove('selected'));
    element.classList.add('selected');
    document.getElementById('catIcon').value = icon;
  }
</script>
@endsection
