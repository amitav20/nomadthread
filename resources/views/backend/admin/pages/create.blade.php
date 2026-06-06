@extends('layouts.admin')

@section('title', 'Add Page | LeatherCraft')
@section('page_title', 'Add Page')
@section('page_breadcrumb', 'Website / Add Page')

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

<form action="{{ route('backend.pages.store') }}" method="POST" enctype="multipart/form-data" onsubmit="document.getElementById('pageContentInput').value = document.querySelector('.content-editor').innerHTML;">
  @csrf
  <input type="hidden" name="content" id="pageContentInput">

  <div class="page-header">
    <div><div class="page-heading">Add New Page</div><div class="page-subheading">Create a static page like About Us, Contact, Policies, etc.</div></div>
    <div class="page-actions">
      <a href="{{ route('backend.pages.index') }}" class="btn btn-outline"><i class="ti ti-x"></i> Cancel</a>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Publish Page</button>
    </div>
  </div>
  
  <div class="form-layout">
    <div>
      <!-- Page Content -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-file-text" style="margin-right:8px;color:var(--gold)"></i>Page Content</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Page Title <span>*</span></label>
            <input type="text" name="title" class="form-input" id="pageNameInput" placeholder="e.g. About Us — LeatherCraft India" value="{{ old('title') }}" oninput="updatePageSlug()" required>
          </div>
          <div class="form-group">
            <label class="form-label">URL Slug</label>
            <div style="display:flex;gap:0;">
              <div style="padding:10px 12px;background:var(--bg4);border:1px solid var(--border);border-right:none;border-radius:8px 0 0 8px;font-size:12px;color:var(--text3);white-space:nowrap;">leathercraft.in/pages/</div>
              <input type="text" name="slug" class="form-input" style="border-radius:0 8px 8px 0;" id="pageSlugInput" placeholder="about-us" value="{{ old('slug') }}" required>
            </div>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Page Type</label>
            <select name="page_type" class="form-input">
              <option value="Custom Page" {{ old('page_type') == 'Custom Page' ? 'selected' : '' }}>Custom Page</option>
              <option value="About Us" {{ old('page_type') == 'About Us' ? 'selected' : '' }}>About Us</option>
              <option value="Contact Us" {{ old('page_type') == 'Contact Us' ? 'selected' : '' }}>Contact Us</option>
              <option value="Privacy Policy" {{ old('page_type') == 'Privacy Policy' ? 'selected' : '' }}>Privacy Policy</option>
              <option value="Return & Refund Policy" {{ old('page_type') == 'Return & Refund Policy' ? 'selected' : '' }}>Return & Refund Policy</option>
              <option value="Shipping Policy" {{ old('page_type') == 'Shipping Policy' ? 'selected' : '' }}>Shipping Policy</option>
              <option value="Terms & Conditions" {{ old('page_type') == 'Terms & Conditions' ? 'selected' : '' }}>Terms & Conditions</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Rich Text Editor -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-pencil" style="margin-right:8px;color:var(--gold)"></i>Page Content Editor</div></div>
        <!-- Toolbar -->
        <div class="page-editor-toolbar">
          <button type="button" class="editor-btn active" title="Bold" onclick="execCmd('bold',this)"><b>B</b></button>
          <button type="button" class="editor-btn" title="Italic" onclick="execCmd('italic',this)"><i>I</i></button>
          <button type="button" class="editor-btn" title="Underline" onclick="execCmd('underline',this)"><u>U</u></button>
          <div class="editor-sep"></div>
          <button type="button" class="editor-btn" title="H1" onclick="execCmd('formatBlock','H2',this)" style="font-size:11px;font-weight:700;">H1</button>
          <button type="button" class="editor-btn" title="H2" onclick="execCmd('formatBlock','H3',this)" style="font-size:11px;font-weight:700;">H2</button>
          <button type="button" class="editor-btn" title="H3" onclick="execCmd('formatBlock','H4',this)" style="font-size:11px;font-weight:700;">H3</button>
          <div class="editor-sep"></div>
          <button type="button" class="editor-btn" title="Bullet List" onclick="execCmd('insertUnorderedList',null,this)"><i class="ti ti-list"></i></button>
          <button type="button" class="editor-btn" title="Numbered List" onclick="execCmd('insertOrderedList',null,this)"><i class="ti ti-list-numbers"></i></button>
          <button type="button" class="editor-btn" title="Quote" onclick="execCmd('formatBlock','BLOCKQUOTE',this)"><i class="ti ti-quote"></i></button>
          <div class="editor-sep"></div>
          <button type="button" class="editor-btn" title="Left" onclick="execCmd('justifyLeft',null,this)"><i class="ti ti-align-left"></i></button>
          <button type="button" class="editor-btn" title="Center" onclick="execCmd('justifyCenter',null,this)"><i class="ti ti-align-center"></i></button>
          <button type="button" class="editor-btn" title="Right" onclick="execCmd('justifyRight',null,this)"><i class="ti ti-align-right"></i></button>
          <div class="editor-sep"></div>
          <button type="button" class="editor-btn" title="Link" onclick="insertLink()"><i class="ti ti-link"></i></button>
          <button type="button" class="editor-btn" title="Image URL" onclick="insertImage()"><i class="ti ti-photo"></i></button>
          <button type="button" class="editor-btn" title="Divider" onclick="execCmd('insertHorizontalRule',null,this)"><i class="ti ti-minus"></i></button>
          <div class="editor-sep"></div>
          <button type="button" class="editor-btn" title="Undo" onclick="document.execCommand('undo')"><i class="ti ti-arrow-back-up"></i></button>
          <button type="button" class="editor-btn" title="Redo" onclick="document.execCommand('redo')"><i class="ti ti-arrow-forward-up"></i></button>
        </div>
        <div class="content-editor" contenteditable="true" data-placeholder="Start writing your page content here… Use the toolbar above to format text, add headings, lists, and links." style="min-height:280px;">{!! old('content') !!}</div>
        <div style="padding:10px 16px;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
          <span style="font-size:12px;color:var(--text3);" id="wordCount">0 words</span>
          <div style="display:flex;gap:8px;">
            <button type="button" class="btn btn-outline btn-sm" onclick="clearEditor()"><i class="ti ti-eraser"></i> Clear</button>
          </div>
        </div>
      </div>

      <!-- Page Images -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-photo" style="margin-right:8px;color:var(--gold)"></i>Page Media</div></div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Featured / OG Image</label>
            <div class="upload-drop" style="position:relative;">
              <input type="file" name="featured_image" accept="image/*" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
              <div class="upload-drop-icon ti ti-cloud-upload"></div>
              <p>Upload featured page header image</p>
              <span>Recommended: 1200×630px</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <!-- Publish -->
      <div class="card">
        <div class="card-head"><div class="card-title">Publish Settings</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
              <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
              <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Visibility</label>
            <select name="visibility" class="form-input">
              <option value="Public" {{ old('visibility') == 'Public' ? 'selected' : '' }}>Public</option>
              <option value="Private" {{ old('visibility') == 'Private' ? 'selected' : '' }}>Private</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Schedule Publish</label>
            <input type="datetime-local" name="schedule_publish" class="form-input" value="{{ old('schedule_publish') }}">
          </div>
          <div class="divider"></div>
          <div class="form-group">
            <div class="toggle-group">
              <div class="toggle-info"><p>Show in Navigation</p><span>Add to site menu</span></div>
              <label class="toggle"><input type="checkbox" name="show_in_navigation" value="1" checked><span class="toggle-slider"></span></label>
            </div>
            <div class="toggle-group">
              <div class="toggle-info"><p>Show in Footer</p><span>Add to footer links</span></div>
              <label class="toggle"><input type="checkbox" name="show_in_footer" value="1"><span class="toggle-slider"></span></label>
            </div>
            <div class="toggle-group">
              <div class="toggle-info"><p>Index by Search Engines</p><span>Allow Google to crawl this page</span></div>
              <label class="toggle"><input type="checkbox" name="index_by_search_engines" value="1" checked><span class="toggle-slider"></span></label>
            </div>
          </div>
          <div class="divider"></div>
          <button type="submit" class="btn btn-gold btn-block btn-lg"><i class="ti ti-device-floppy"></i> Publish Page</button>
        </div>
      </div>

      <!-- SEO -->
      <div class="card">
        <div class="card-head"><div class="card-title"><i class="ti ti-world" style="margin-right:8px;color:var(--gold)"></i>SEO Settings</div></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Meta Title</label>
            <input type="text" name="meta_title" class="form-input" id="metaTitlePage" placeholder="Page Title | LeatherCraft" value="{{ old('meta_title') }}" oninput="updateSeoPage()">
            <div class="form-hint" id="pageTitleCount">0 / 60 characters</div>
          </div>
          <div class="form-group">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" class="form-input" style="min-height:75px;" id="metaDescPage" placeholder="Brief page description for search engines…" oninput="updateSeoPage()">{{ old('meta_description') }}</textarea>
            <div class="form-hint" id="pageDescCount">0 / 160 characters</div>
          </div>
          <div class="form-group">
            <label class="form-label">Focus Keyword</label>
            <input type="text" name="focus_keyword" class="form-input" placeholder="e.g. leather bags india" value="{{ old('focus_keyword') }}">
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Search Preview</label>
            <div class="seo-preview">
              <div class="seo-url" id="seoPageUrl">https://leathercraft.in/pages/about-us</div>
              <div class="seo-title" id="seoPageTitle">Page Title | LeatherCraft India</div>
              <div class="seo-desc" id="seoPageDesc">Your meta description will appear here…</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Page Template -->
      <div class="card">
        <div class="card-head"><div class="card-title">Page Template</div></div>
        <div class="card-body">
          <div style="display:flex;flex-direction:column;gap:8px;">
            <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid var(--border);border-radius:8px;cursor:pointer;">
              <input type="radio" name="template" value="Default Page" checked style="accent-color:var(--gold);">
              <div><div style="font-size:13px;color:var(--text);font-weight:500;">Default Page</div><div style="font-size:12px;color:var(--text3);">Full-width content area</div></div>
            </label>
            <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid var(--border);border-radius:8px;cursor:pointer;">
              <input type="radio" name="template" value="With Sidebar" style="accent-color:var(--gold);">
              <div><div style="font-size:13px;color:var(--text);font-weight:500;">With Sidebar</div><div style="font-size:12px;color:var(--text3);">Content + right sidebar</div></div>
            </label>
            <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid var(--border);border-radius:8px;cursor:pointer;">
              <input type="radio" name="template" value="Contact Page" style="accent-color:var(--gold);">
              <div><div style="font-size:13px;color:var(--text);font-weight:500;">Contact Page</div><div style="font-size:12px;color:var(--text3);">Includes contact form + map</div></div>
            </label>
            <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid var(--border);border-radius:8px;cursor:pointer;">
              <input type="radio" name="template" value="Policy Page" style="accent-color:var(--gold);">
              <div><div style="font-size:13px;color:var(--text);font-weight:500;">Policy Page</div><div style="font-size:12px;color:var(--text3);">Narrow text, TOC sidebar</div></div>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
