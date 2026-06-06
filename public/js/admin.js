// Image preview
function handleImgUpload(e, previewId) {
  const files = Array.from(e.target.files);
  const grid = document.getElementById(previewId);
  files.forEach(file => {
    const reader = new FileReader();
    reader.onload = ev => {
      const slot = document.createElement('div');
      slot.className = 'img-preview-item';
      slot.innerHTML = `<img src="${ev.target.result}" alt=""><div class="img-preview-remove" onclick="this.parentNode.remove()"><i class="ti ti-x"></i></div>`;
      const addSlot = grid.querySelector('.img-add-slot');
      if (addSlot) grid.insertBefore(slot, addSlot);
      else grid.appendChild(slot);
    };
    reader.readAsDataURL(file);
  });
}

// Banner preview
function previewBanner(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    const img = document.getElementById('bannerPreviewImg');
    const ph = document.getElementById('bannerPreviewPlaceholder');
    const vid = document.getElementById('bannerPreviewVid');
    if (vid) vid.style.display = 'none';
    if (img) {
      img.src = ev.target.result;
      img.style.display = 'block';
    }
    if (ph) ph.style.display = 'none';
  };
  reader.readAsDataURL(file);
}

function previewVideo(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    const ph = document.getElementById('bannerPreviewPlaceholder');
    const box = document.getElementById('bannerPreviewBox');
    const img = document.getElementById('bannerPreviewImg');
    if (img) img.style.display = 'none';
    
    if (box) {
      let vid = document.getElementById('bannerPreviewVid');
      if (!vid) {
        vid = document.createElement('video');
        vid.id = 'bannerPreviewVid';
        vid.style.width = '100%';
        vid.style.height = '100%';
        vid.style.objectFit = 'cover';
        vid.autoplay = true;
        vid.loop = true;
        vid.muted = true;
        box.appendChild(vid);
      }
      vid.src = ev.target.result;
      vid.style.display = 'block';
    }
    if (ph) ph.style.display = 'none';
  };
  reader.readAsDataURL(file);
}

// Icon picker
function selectIcon(el, icon) {
  document.querySelectorAll('.icon-pick-item').forEach(i => i.classList.remove('selected'));
  el.classList.add('selected');
}

// Color picker
function selectColor(el) {
  document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
  el.classList.add('selected');
}

// Layout picker
function selectLayout(el, type) {
  document.querySelectorAll('.layout-pick').forEach(l => {
    l.style.borderColor = 'transparent';
    l.style.background = 'var(--bg4)';
    l.style.color = 'var(--text3)';
  });
  el.style.borderColor = 'var(--gold)';
  el.style.background = 'rgba(201,168,76,.1)';
  el.style.color = 'var(--gold2)';
}

// Category slug
function updateCatSlug() {
  const name = document.getElementById('catName')?.value || '';
  const slug = name.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
  const slugEl = document.getElementById('catSlug');
  if (slugEl) slugEl.value = slug;
}

// Page slug
function updatePageSlug() {
  const name = document.getElementById('pageNameInput')?.value || '';
  const slug = name.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
  const slugEl = document.getElementById('pageSlugInput');
  if (slugEl) slugEl.value = slug;
  updateSeoPage();
}

// SEO previews - product
function updateSeoProd() {
  const t = document.getElementById('metaTitleProd')?.value || '';
  const d = document.getElementById('metaDescProd')?.value || '';
  const titleEl = document.getElementById('seoProdTitle');
  const descEl = document.getElementById('seoProdDesc');
  const titleCount = document.getElementById('metaTitleCount');
  const descCount = document.getElementById('metaDescCount');
  
  if (titleEl) titleEl.textContent = t || 'Product Name | LeatherCraft India';
  if (descEl) descEl.textContent = d || 'Your meta description will appear here in search results…';
  if (titleCount) titleCount.textContent = `${t.length} / 60 characters`;
  if (descCount) descCount.textContent = `${d.length} / 160 characters`;
}

// SEO previews - page
function updateSeoPage() {
  const t = document.getElementById('metaTitlePage')?.value || '';
  const d = document.getElementById('metaDescPage')?.value || '';
  const slug = document.getElementById('pageSlugInput')?.value || 'page-url';
  
  const titleEl = document.getElementById('seoPageTitle');
  const descEl = document.getElementById('seoPageDesc');
  const urlEl = document.getElementById('seoPageUrl');
  const titleCount = document.getElementById('pageTitleCount');
  const descCount = document.getElementById('pageDescCount');

  if (titleEl) titleEl.textContent = t || 'Page Title | LeatherCraft India';
  if (descEl) descEl.textContent = d || 'Your meta description will appear here…';
  if (urlEl) urlEl.textContent = `https://leathercraft.in/pages/${slug}`;
  if (titleCount) titleCount.textContent = `${t.length} / 60 characters`;
  if (descCount) descCount.textContent = `${d.length} / 160 characters`;
}

// Rich text editor
function execCmd(cmd, val, btn) {
  document.execCommand(cmd, false, val || null);
}
function insertLink() {
  const url = prompt('Enter URL:','https://');
  if (url) document.execCommand('createLink', false, url);
}
function insertImage() {
  const url = prompt('Enter image URL:','https://');
  if (url) document.execCommand('insertImage', false, url);
}
function clearEditor() {
  const ed = document.querySelector('.content-editor');
  if (ed) ed.innerHTML = '';
}

// Word count
document.addEventListener('input', e => {
  if (e.target.classList.contains('content-editor')) {
    const words = e.target.innerText.trim().split(/\s+/).filter(w => w).length;
    const wc = document.getElementById('wordCount');
    if (wc) wc.textContent = `${words} word${words !== 1 ? 's' : ''}`;
  }
});

// Overlay toggle
function toggleOverlay() {
  const checked = document.getElementById('overlayToggle')?.checked;
  const fields = document.getElementById('overlayFields');
  if (fields) fields.style.opacity = checked ? '1' : '0.3';
}

// Banner position hint
const bannerDims = {
  hero: 'Recommended: 1440×600px · JPG, PNG, or WebP',
  cat: 'Recommended: 1200×400px · JPG or PNG',
  mid: 'Recommended: 1200×500px · JPG or PNG',
  sidebar: 'Recommended: 300×600px · JPG or PNG',
  popup: 'Recommended: 600×400px · PNG with transparency OK',
  mobile: 'Recommended: 768×400px · JPG or PNG',
};
function updateBannerDimHint(sel) {
  const el = document.getElementById('bannerDimHint');
  if (el) el.textContent = bannerDims[sel.value] || '';
}

// Drag-over effect for upload drops
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.upload-drop').forEach(drop => {
    drop.addEventListener('dragover', e => { e.preventDefault(); drop.classList.add('drag-over'); });
    drop.addEventListener('dragleave', () => drop.classList.remove('drag-over'));
    drop.addEventListener('drop', e => { e.preventDefault(); drop.classList.remove('drag-over'); });
  });
});
