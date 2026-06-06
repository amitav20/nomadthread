@extends('layouts.admin')

@section('title', 'Edit Banner | LeatherCraft')
@section('page_title', 'Edit Banner')
@section('page_breadcrumb', 'Marketing / Edit Banner')

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

<form action="{{ route('backend.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  
  <div class="page-header">
    <div><div class="page-heading">Edit Banner: {{ $banner->title }}</div><div class="page-subheading">Update banner promotional content and background media</div></div>
    <div class="page-actions">
      <a href="{{ route('backend.banners.index') }}" class="btn btn-outline"><i class="ti ti-x"></i> Cancel</a>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Update Banner</button>
    </div>
  </div>

  <div class="form-layout">
    <div>
      <!-- Upload -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-photo" style="margin-right:8px;color:var(--gold)"></i>Banner Media</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Banner Position <span>*</span></label>
            <select name="position" class="form-input" onchange="updateBannerDimHint(this)" required>
              <option value="Homepage Hero" {{ $banner->position == 'Homepage Hero' ? 'selected' : '' }}>Homepage Hero (Full Width Image/Video)</option>
              <option value="Shop Hero" {{ $banner->position == 'Shop Hero' ? 'selected' : '' }}>Shop Page Header</option>
              <option value="Discussions Hero" {{ $banner->position == 'Discussions Hero' ? 'selected' : '' }}>Discussions Forum Header</option>
              <option value="Category Header" {{ $banner->position == 'Category Header' ? 'selected' : '' }}>Category Page Header</option>
              <option value="Custom Page" {{ $banner->position == 'Custom Page' ? 'selected' : '' }}>Custom Page / About Us Hero</option>
            </select>
            <div class="form-hint" id="bannerDimHint">Recommended: 1440×600px · JPG, PNG, or WebP</div>
          </div>
          <div class="form-group">
            <label class="form-label">Upload New Image (Replaces current image)</label>
            <div class="upload-drop" id="bannerDrop" style="position:relative;">
              <input type="file" name="image" accept="image/*" onchange="previewBanner(event)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
              <div class="upload-drop-icon ti ti-cloud-upload"></div>
              <p>Click or drag banner image here to replace</p>
              <span id="bannerSizeHint">Full-width hero: 1440×600px recommended</span>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Upload New Video (Replaces current video)</label>
            <div class="upload-drop" style="position:relative; padding:20px;">
              <input type="file" name="video" accept="video/*" onchange="previewVideo(event)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
              <div class="upload-drop-icon ti ti-video" style="font-size:24px;color:var(--text3);display:block;margin-bottom:6px;"></div>
              <p style="font-size:13px;">Click or drag banner video loop here to replace</p>
              <span>Recommended: MP4, WebM (under 20MB)</span>
            </div>
          </div>
          
          @if(!empty($banner->video))
            <div class="form-group">
              <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--red); cursor:pointer;">
                <input type="checkbox" name="delete_video" value="1">
                Delete current video background
              </label>
            </div>
          @endif

          <div class="form-group">
            <label class="form-label">Current / New Banner Preview</label>
            <div class="banner-preview" id="bannerPreviewBox">
              @if(!empty($banner->image))
                <img id="bannerPreviewImg" class="banner-preview-img" src="{{ $banner->image }}" style="display:block;" alt="">
              @else
                <img id="bannerPreviewImg" class="banner-preview-img" src="" alt="">
              @endif
              
              @if(!empty($banner->video))
                <video id="bannerPreviewVid" src="{{ $banner->video }}" style="width: 100%; height: 100%; object-fit: cover; display:block;" autoplay loop muted></video>
              @endif
              
              <div class="banner-preview-placeholder" id="bannerPreviewPlaceholder" style="display: {{ empty($banner->image) && empty($banner->video) ? 'block' : 'none' }};">
                <i class="ti ti-photo"></i>
                <p>Preview will appear here</p>
              </div>
            </div>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Mobile Version (optional image)</label>
            <div class="upload-drop" style="position:relative; padding:18px 12px;">
              <input type="file" name="image_mobile" accept="image/*" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
              <div class="ti ti-device-mobile" style="font-size:24px;color:var(--text3);display:block;margin-bottom:6px;"></div>
              @if(!empty($banner->image_mobile))
                <p style="font-size:13px; color:var(--green)">Currently: Has mobile image (click to replace)</p>
              @else
                <p style="font-size:13px;">Upload a mobile-optimised image</p>
              @endif
              <span>Recommended: 768×400px</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Overlay Text -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-text-size" style="margin-right:8px;color:var(--gold)"></i>Banner Text Overlay</div></div>
        <div class="card-body">
          <div class="form-group">
            <div class="toggle-group" style="margin-bottom:14px;">
              <div class="toggle-info"><p>Enable Text Overlay</p><span>Show headline and CTA on banner</span></div>
              <label class="toggle"><input type="checkbox" name="enable_overlay" value="1" {{ $banner->enable_overlay ? 'checked' : '' }} id="overlayToggle" onchange="toggleOverlay()"><span class="toggle-slider"></span></label>
            </div>
          </div>
          <div id="overlayFields" style="opacity: {{ $banner->enable_overlay ? '1' : '0.3' }};">
            <div class="form-group">
              <label class="form-label">Headline</label>
              <input type="text" name="headline" class="form-input" placeholder="e.g. Handcrafted for a Lifetime" value="{{ old('headline', $banner->headline) }}">
            </div>
            <div class="form-group">
              <label class="form-label">Sub-headline</label>
              <input type="text" name="subheadline" class="form-input" placeholder="e.g. Premium leather bags, wallets & accessories" value="{{ old('subheadline', $banner->subheadline) }}">
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">CTA Button Text</label>
                <input type="text" name="cta_text" class="form-input" placeholder="e.g. Shop Now" value="{{ old('cta_text', $banner->cta_text) }}">
              </div>
              <div class="form-group">
                <label class="form-label">CTA Link</label>
                <input type="text" name="cta_link" class="form-input" placeholder="/shop" value="{{ old('cta_link', $banner->cta_link) }}">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Text Position</label>
                <select name="text_position" class="form-input">
                  <option value="Centre" {{ old('text_position', $banner->text_position) == 'Centre' ? 'selected' : '' }}>Centre</option>
                  <option value="Left Aligned" {{ old('text_position', $banner->text_position) == 'Left Aligned' ? 'selected' : '' }}>Left Aligned</option>
                  <option value="Right Aligned" {{ old('text_position', $banner->text_position) == 'Right Aligned' ? 'selected' : '' }}>Right Aligned</option>
                  <option value="Bottom Left" {{ old('text_position', $banner->text_position) == 'Bottom Left' ? 'selected' : '' }}>Bottom Left</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Text Colour</label>
                <select name="text_color" class="form-input">
                  <option value="White" {{ old('text_color', $banner->text_color) == 'White' ? 'selected' : '' }}>White</option>
                  <option value="Gold / Cream" {{ old('text_color', $banner->text_color) == 'Gold / Cream' ? 'selected' : '' }}>Gold / Cream</option>
                  <option value="Dark / Black" {{ old('text_color', $banner->text_color) == 'Dark / Black' ? 'selected' : '' }}>Dark / Black</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <!-- Settings -->
      <div class="card">
        <div class="card-head"><div class="card-title">Banner Settings</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Banner Title (Internal) <span>*</span></label>
            <input type="text" name="title" class="form-input" placeholder="e.g. Summer Sale 2026 Hero" value="{{ old('title', $banner->title) }}" required>
            <div class="form-hint">For admin reference only</div>
          </div>
          <div class="form-group">
            <label class="form-label">Alt Text</label>
            <input type="text" name="alt_text" class="form-input" placeholder="Describe the banner image for accessibility" value="{{ old('alt_text', $banner->alt_text) }}">
          </div>
          <div class="form-group">
            <label class="form-label">Click URL</label>
            <input type="text" name="click_url" class="form-input" placeholder="https://leathercraft.in/sale" value="{{ old('click_url', $banner->click_url) }}">
            <div class="form-hint">Where clicking the banner takes the user</div>
          </div>
          <div class="form-group">
            <label class="form-label">Open Link In</label>
            <select name="open_in" class="form-input">
              <option value="same_tab" {{ old('open_in', $banner->open_in) == 'same_tab' ? 'selected' : '' }}>Same Tab</option>
              <option value="new_tab" {{ old('open_in', $banner->open_in) == 'new_tab' ? 'selected' : '' }}>New Tab</option>
            </select>
          </div>
          <div class="divider"></div>
          <div class="form-group">
            <label class="form-label">Display Status</label>
            <select name="status" class="form-input">
              <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Active (Show Now)</option>
              <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Hidden</option>
            </select>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Show From</label>
              <input type="date" name="show_from" class="form-input" value="{{ old('show_from', $banner->show_from) }}">
            </div>
            <div class="form-group">
              <label class="form-label">Hide After</label>
              <input type="date" name="hide_after" class="form-input" value="{{ old('hide_after', $banner->hide_after) }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $banner->sort_order) }}" min="1">
            <div class="form-hint">Lower number shows first (for slider)</div>
          </div>
          <div class="divider"></div>
          <button type="submit" class="btn btn-gold btn-block"><i class="ti ti-device-floppy"></i> Update Banner</button>
        </div>
      </div>

      <!-- Targeting Settings -->
      <div class="card">
        <div class="card-head"><div class="card-title">Targeting Settings</div></div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Target Audience</label>
            <select name="target_audience" class="form-input">
              <option value="All Visitors" {{ old('target_audience', $banner->target_audience) == 'All Visitors' ? 'selected' : '' }}>All Visitors</option>
              <option value="New Visitors Only" {{ old('target_audience', $banner->target_audience) == 'New Visitors Only' ? 'selected' : '' }}>New Visitors Only</option>
              <option value="Returning Customers" {{ old('target_audience', $banner->target_audience) == 'Returning Customers' ? 'selected' : '' }}>Returning Customers</option>
              <option value="Logged-in Users" {{ old('target_audience', $banner->target_audience) == 'Logged-in Users' ? 'selected' : '' }}>Logged-in Users</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
