@extends('layouts.admin')

@section('title', 'Settings | LeatherCraft')
@section('page_title', 'Settings')
@section('page_breadcrumb', 'Config / Settings')

@section('content')
@if(session('success'))
  <div style="background:rgba(39,174,96,.15); border:1px solid var(--green); color:var(--green); padding:16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:13.5px;">
    <strong>Success!</strong> {{ session('success') }}
  </div>
@endif

<form action="{{ route('backend.settings.update') }}" method="POST">
  @csrf

  <div class="page-header">
    <div>
      <div class="page-heading">Settings</div>
      <div class="page-subheading">Configure your store design, branding and preferences</div>
    </div>
    <div class="page-actions">
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Save Changes</button>
    </div>
  </div>

  <div class="settings-grid">
    <div class="settings-nav">
      <div class="settings-nav-item active" onclick="switchSettingsTab('store-info', this)">Store Info</div>
      <div class="settings-nav-item" onclick="switchSettingsTab('branding', this)">Branding & Layout</div>
      <div class="settings-nav-item" onclick="switchSettingsTab('social-links', this)">Social Links</div>
      <div class="settings-nav-item" onclick="switchSettingsTab('homepage-story', this)">Homepage Story</div>
    </div>

    <!-- TABS CONTAINER -->
    <div class="card" style="flex:1;">
      <!-- STORE INFO TAB -->
      <div class="settings-tab-content" id="tab-store-info">
        <div class="card-head"><div class="card-title">Store Information</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Store Name</label>
            <input type="text" name="store_name" class="form-input" value="{{ old('store_name', $settings['store_name'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Store URL</label>
            <input type="text" name="store_url" class="form-input" value="{{ old('store_url', $settings['store_url'] ?? '') }}">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Support Email</label>
              <input type="email" name="support_email" class="form-input" value="{{ old('support_email', $settings['support_email'] ?? '') }}">
            </div>
            <div class="form-group">
              <label class="form-label">Support Phone</label>
              <input type="tel" name="support_phone" class="form-input" value="{{ old('support_phone', $settings['support_phone'] ?? '') }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Store Address</label>
            <textarea name="store_address" class="form-input" style="min-height:80px;">{{ old('store_address', $settings['store_address'] ?? '') }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Currency</label>
              <select name="currency" class="form-input">
                <option value="INR (₹)" {{ ($settings['currency'] ?? '') == 'INR (₹)' ? 'selected' : '' }}>INR (₹)</option>
                <option value="USD ($)" {{ ($settings['currency'] ?? '') == 'USD ($)' ? 'selected' : '' }}>USD ($)</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Timezone</label>
              <select name="timezone" class="form-input">
                <option value="Asia/Kolkata (IST)" {{ ($settings['timezone'] ?? '') == 'Asia/Kolkata (IST)' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                <option value="UTC" {{ ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- BRANDING TAB -->
      <div class="settings-tab-content" id="tab-branding" style="display:none;">
        <div class="card-head"><div class="card-title">Branding & Layout</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Logo Header Text</label>
            <input type="text" name="logo_text" class="form-input" value="{{ old('logo_text', $settings['logo_text'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Top Bar Announcement Text (HTML Allowed)</label>
            <textarea name="top_bar_text" class="form-input" style="min-height:75px;">{{ old('top_bar_text', $settings['top_bar_text'] ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Footer Tagline Text</label>
            <textarea name="footer_tagline" class="form-input" style="min-height:75px;">{{ old('footer_tagline', $settings['footer_tagline'] ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Footer Copyright Line</label>
            <input type="text" name="copyright_text" class="form-input" value="{{ old('copyright_text', $settings['copyright_text'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Homepage Marquee Strip Text (Separated by •)</label>
            <input type="text" name="marquee_text" class="form-input" value="{{ old('marquee_text', $settings['marquee_text'] ?? '') }}">
          </div>
        </div>
      </div>

      <!-- SOCIAL LINKS TAB -->
      <div class="settings-tab-content" id="tab-social-links" style="display:none;">
        <div class="card-head"><div class="card-title">Social Links</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Facebook Link</label>
            <input type="text" name="facebook_link" class="form-input" value="{{ old('facebook_link', $settings['facebook_link'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">LinkedIn Link</label>
            <input type="text" name="linkedin_link" class="form-input" value="{{ old('linkedin_link', $settings['linkedin_link'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Instagram Link</label>
            <input type="text" name="instagram_link" class="form-input" value="{{ old('instagram_link', $settings['instagram_link'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">YouTube Link</label>
            <input type="text" name="youtube_link" class="form-input" value="{{ old('youtube_link', $settings['youtube_link'] ?? '') }}">
          </div>
        </div>
      </div>

      <!-- HOMEPAGE STORY TAB -->
      <div class="settings-tab-content" id="tab-homepage-story" style="display:none;">
        <div class="card-head"><div class="card-title">Homepage Craft Story Section</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Story Headline Title</label>
            <input type="text" name="story_title" class="form-input" value="{{ old('story_title', $settings['story_title'] ?? '') }}">
          </div>
          <div class="form-group">
            <label class="form-label">Story Body Description</label>
            <textarea name="story_sub" class="form-input" style="min-height:120px;">{{ old('story_sub', $settings['story_sub'] ?? '') }}</textarea>
          </div>
        </div>
      </div>

      <!-- FOOTER BUTTON -->
      <div style="padding: 20px 24px; border-top: 1px solid var(--border); display:flex; justify-content:flex-end;">
        <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Save Changes</button>
      </div>
    </div>
  </div>
</form>

<script>
  function switchSettingsTab(tabId, el) {
    // Hide all tab contents
    document.querySelectorAll('.settings-tab-content').forEach(tab => {
      tab.style.display = 'none';
    });
    // Remove active class from nav items
    document.querySelectorAll('.settings-nav-item').forEach(item => {
      item.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById('tab-' + tabId).style.display = 'block';
    // Add active class to clicked nav item
    el.classList.add('active');
  }
</script>
@endsection
