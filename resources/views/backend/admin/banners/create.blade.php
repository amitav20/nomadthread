@extends('layouts.admin')

@section('title', 'Upload Banner | LeatherCraft')
@section('page_title', 'Upload Banner')
@section('page_breadcrumb', 'Marketing / Upload Banner')

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

<form action="{{ route('backend.banners.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  
  <div class="page-header">
    <div><div class="page-heading">Upload Banner / Media</div><div class="page-subheading">Add a new promotional banner or video background to your website</div></div>
    <div class="page-actions">
      <a href="{{ route('backend.banners.index') }}" class="btn btn-outline"><i class="ti ti-x"></i> Cancel</a>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Save Banner</button>
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
              <option value="Homepage Hero">Homepage Hero (Full Width Image/Video)</option>
              <option value="Shop Hero">Shop Page Header</option>
              <option value="Discussions Hero">Discussions Forum Header</option>
              <option value="Category Header">Category Page Header</option>
              <option value="Custom Page">Custom Page / About Us Hero</option>
            </select>
            <div class="form-hint" id="bannerDimHint">Recommended: 1440×600px · JPG, PNG, or WebP</div>
          </div>
          <div class="form-group">
            <label class="form-label">Upload Image</label>
            <div class="upload-drop" id="bannerDrop" style="position:relative;">
              <input type="file" name="image" accept="image/*" onchange="previewBanner(event)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
              <div class="upload-drop-icon ti ti-cloud-upload"></div>
              <p>Click or drag banner image here</p>
              <span id="bannerSizeHint">Full-width hero: 1440×600px recommended</span>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Upload Video (Alternative to Image)</label>
            <div class="upload-drop" style="position:relative; padding:20px;">
              <input type="file" name="video" accept="video/*" onchange="previewVideo(event)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
              <div class="upload-drop-icon ti ti-video" style="font-size:24px;color:var(--text3);display:block;margin-bottom:6px;"></div>
              <p style="font-size:13px;">Click or drag banner video loop here</p>
              <span>Recommended: MP4, WebM (under 20MB)</span>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Banner Preview</label>
            <div class="banner-preview" id="bannerPreviewBox">
              <img id="bannerPreviewImg" class="banner-preview-img" src="" alt="">
              <div class="banner-preview-placeholder" id="bannerPreviewPlaceholder">
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
              <p style="font-size:13px;">Upload a mobile-optimised image</p>
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
              <label class="toggle"><input type="checkbox" name="enable_overlay" value="1" checked id="overlayToggle" onchange="toggleOverlay()"><span class="toggle-slider"></span></label>
            </div>
          </div>
          <div id="overlayFields">
            <div class="form-group">
              <label class="form-label">Headline</label>
              <input type="text" name="headline" class="form-input" placeholder="e.g. Handcrafted for a Lifetime" value="{{ old('headline') }}">
            </div>
            <div class="form-group">
              <label class="form-label">Sub-headline</label>
              <input type="text" name="subheadline" class="form-input" placeholder="e.g. Premium leather bags, wallets & accessories" value="{{ old('subheadline') }}">
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">CTA Button Text</label>
                <input type="text" name="cta_text" class="form-input" placeholder="e.g. Shop Now" value="{{ old('cta_text') }}">
              </div>
              <div class="form-group">
                <label class="form-label">CTA Link</label>
                <input type="text" name="cta_link" class="form-input" placeholder="/shop" value="{{ old('cta_link') }}">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Text Position</label>
                <select name="text_position" class="form-input">
                  <option value="Centre" {{ old('text_position') == 'Centre' ? 'selected' : '' }}>Centre</option>
                  <option value="Left Aligned" {{ old('text_position') == 'Left Aligned' ? 'selected' : '' }}>Left Aligned</option>
                  <option value="Right Aligned" {{ old('text_position') == 'Right Aligned' ? 'selected' : '' }}>Right Aligned</option>
                  <option value="Bottom Left" {{ old('text_position') == 'Bottom Left' ? 'selected' : '' }}>Bottom Left</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Text Colour</label>
                <select name="text_color" class="form-input">
                  <option value="White" {{ old('text_color') == 'White' ? 'selected' : '' }}>White</option>
                  <option value="Gold / Cream" {{ old('text_color') == 'Gold / Cream' ? 'selected' : '' }}>Gold / Cream</option>
                  <option value="Dark / Black" {{ old('text_color') == 'Dark / Black' ? 'selected' : '' }}>Dark / Black</option>
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
            <input type="text" name="title" class="form-input" placeholder="e.g. Summer Sale 2026 Hero" value="{{ old('title') }}" required>
            <div class="form-hint">For admin reference only</div>
          </div>
          <div class="form-group">
            <label class="form-label">Alt Text</label>
            <input type="text" name="alt_text" class="form-input" placeholder="Describe the banner image for accessibility" value="{{ old('alt_text') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Click URL</label>
            <input type="text" name="click_url" class="form-input" placeholder="https://leathercraft.in/sale" value="{{ old('click_url') }}">
            <div class="form-hint">Where clicking the banner takes the user</div>
          </div>
          <div class="form-group">
            <label class="form-label">Open Link In</label>
            <select name="open_in" class="form-input">
              <option value="same_tab" {{ old('open_in') == 'same_tab' ? 'selected' : '' }}>Same Tab</option>
              <option value="new_tab" {{ old('open_in') == 'new_tab' ? 'selected' : '' }}>New Tab</option>
            </select>
          </div>
          <div class="divider"></div>
          <div class="form-group">
            <label class="form-label">Display Status</label>
            <select name="status" class="form-input">
              <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Show Now)</option>
              <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Hidden</option>
            </select>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Show From</label>
              <input type="date" name="show_from" class="form-input" value="{{ old('show_from') }}">
            </div>
            <div class="form-group">
              <label class="form-label">Hide After</label>
              <input type="date" name="hide_after" class="form-input" value="{{ old('hide_after') }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 1) }}" min="1">
            <div class="form-hint">Lower number shows first (for slider)</div>
          </div>
          <div class="divider"></div>
          <button type="submit" class="btn btn-gold btn-block"><i class="ti ti-device-floppy"></i> Save Banner</button>
        </div>
      </div>

      <!-- Show on Pages -->
      <div class="card">
        <div class="card-head"><div class="card-title">Targeting Settings</div></div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Target Audience</label>
            <select name="target_audience" class="form-input">
              <option value="All Visitors">All Visitors</option>
              <option value="New Visitors Only">New Visitors Only</option>
              <option value="Returning Customers">Returning Customers</option>
              <option value="Logged-in Users">Logged-in Users</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
