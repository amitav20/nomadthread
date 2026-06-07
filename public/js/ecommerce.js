// ─── DATA ───────────────────────────────────────────────
let products = [];

const cartItems = [];
let currentModalProduct = null;
let currentModalColor = null;

// ─── RENDER PRODUCTS ──────────────────────────────────
function getColorClass(colorName) {
  const map = { tan:'color-tan', espresso:'color-espresso', cognac:'color-cognac', black:'color-black', olive:'color-olive', wine:'color-wine', camel:'color-camel', slate:'color-slate' };
  return map[colorName] || 'color-tan';
}
function formatPrice(p) { return '₹' + p.toLocaleString('en-IN'); }

function renderProducts(filter = 'all') {
  const grid = document.getElementById('productGrid');
  if (!grid) return; // Exit if not on the store index page
  const filtered = filter === 'all' ? products : products.filter(p => p.category_slug === filter || (filter === 'new' && p.badge === 'new'));
  
  const getProductUrl = (sku) => {
    const template = window.routes?.productShow || '/product/PLACEHOLDER';
    return template.replace('PLACEHOLDER', sku);
  };

  grid.innerHTML = filtered.map(p => {
    const firstColor = p.colors[0] || 'tan';
    return `
    <div class="product-card" data-id="${p.id}">
      <div class="product-img-wrap">
        ${p.badge ? `<div class="product-badge ${p.badge === 'new' ? 'badge-new' : 'badge-sale'}">${p.badge === 'new' ? 'New' : 'Sale'}</div>` : ''}
        <button class="product-wishlist" onclick="toggleWishlist(this)" title="Wishlist">♡</button>
        <div class="product-thumb">
          <a href="${getProductUrl(p.sku)}" style="display:block; width:100%; height:100%">
            ${p.images && p.images.length > 0 
              ? `<img src="${p.images[0].image_path}" alt="${p.images[0].alt_text || p.name}" style="width:100%; height:100%; object-fit:cover;" id="thumb-${p.id}">`
              : `<div class="product-visual ${p.shape || 'bag-shape'} ${getColorClass(firstColor)}" data-product="${p.id}" id="thumb-${p.id}"></div>`
            }
          </a>
        </div>
        <div class="product-add-overlay">
          <button class="add-cart-btn" onclick="addToCart(${p.id}, '${firstColor}')">Add to Cart</button>
          <button class="quick-view-btn" onclick="openModal(${p.id})">Quick View</button>
        </div>
      </div>
      <div class="product-info">
        <div class="color-swatches">
          ${p.colors.map((c,i) => `<div class="swatch swatch-${c.trim()} ${i===0?'active':''}" onclick="changeColor(${p.id}, '${c.trim()}', this)" title="${c.trim().charAt(0).toUpperCase()+c.trim().slice(1)}"></div>`).join('')}
        </div>
        <div class="product-name">
          <a href="${getProductUrl(p.sku)}" style="color:inherit; text-decoration:none">${p.name}</a>
        </div>
        <div class="product-type">${p.type}</div>
        <div class="product-price">
          <span class="price-current">${formatPrice(p.price)}</span>
          ${p.oldPrice ? `<span class="price-old">${formatPrice(p.oldPrice)}</span><span class="price-save">Save ${Math.round((1-p.price/p.oldPrice)*100)}%</span>` : ''}
        </div>
      </div>
    </div>
  `;
  }).join('');
}

function filterProducts(cat, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderProducts(cat);
}

function changeColor(productId, colorName, swatchEl) {
  const card = swatchEl.closest('.product-card');
  card.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
  swatchEl.classList.add('active');
  const thumb = document.getElementById(`thumb-${productId}`);
  if (thumb && thumb.tagName === 'DIV') {
    thumb.className = thumb.className.replace(/color-\w+/, getColorClass(colorName));
  }
}

function toggleWishlist(btn) {
  btn.classList.toggle('active');
  btn.textContent = btn.classList.contains('active') ? '♥' : '♡';
  showToast(btn.classList.contains('active') ? 'Added to wishlist' : 'Removed from wishlist');
}

// ─── CART ──────────────────────────────────────────────
function addToCart(productId, colorOverride) {
  const p = products.find(x => x.id === productId);
  if (!p) return;
  const color = colorOverride || p.colors[0];
  const existing = cartItems.find(i => i.id === productId && i.color === color);
  if (existing) { existing.qty++; }
  else { 
    const imgPath = (p.images && p.images.length > 0) ? p.images[0].image_path : null;
    cartItems.push({ 
      id: productId, 
      name: p.name, 
      price: p.price, 
      color, 
      shape: p.shape, 
      image_path: imgPath,
      qty: 1 
    }); 
  }
  updateCartUI();
  showToast(`${p.name} added to cart`);
}

function updateCartUI() {
  const total = cartItems.reduce((s, i) => s + i.price * i.qty, 0);
  const count = cartItems.reduce((s, i) => s + i.qty, 0);
  
  const badge = document.getElementById('cartBadge');
  if (badge) badge.textContent = count;
  
  const totalEl = document.getElementById('cartTotal');
  if (totalEl) totalEl.textContent = formatPrice(total);
  
  const container = document.getElementById('cartItems');
  if (!container) return;
  
  if (cartItems.length === 0) {
    container.innerHTML = `<div style="text-align:center; padding: 60px 20px; font-family:'Cormorant Garamond',serif; font-size:18px; color:var(--text-light)">Your cart is empty.<br><br>Add some beautiful leather goods!</div>`;
    return;
  }
  container.innerHTML = cartItems.map((item, idx) => `
    <div class="cart-item">
      <div class="cart-item-visual">
        ${item.image_path 
          ? `<img src="${item.image_path}" style="width:40px; height:40px; border-radius:6px; object-fit:cover; border:1px solid var(--border);" alt="${item.name}">`
          : `<div class="product-visual cart-item-mini ${item.shape || 'bag-shape'} ${getColorClass(item.color)}"></div>`
        }
      </div>
      <div>
        <div class="cart-item-name">${item.name}</div>
        <div class="cart-item-color">${item.color}</div>
        <div class="cart-qty">
          <button class="qty-btn" onclick="changeQty(${idx}, -1)">−</button>
          <span class="qty-num">${item.qty}</span>
          <button class="qty-btn" onclick="changeQty(${idx}, 1)">+</button>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">
        <span class="cart-item-price">${formatPrice(item.price * item.qty)}</span>
        <button class="remove-item" onclick="removeFromCart(${idx})">✕</button>
      </div>
    </div>
  `).join('');
}

function changeQty(idx, delta) {
  cartItems[idx].qty += delta;
  if (cartItems[idx].qty <= 0) cartItems.splice(idx, 1);
  updateCartUI();
}
function removeFromCart(idx) { cartItems.splice(idx, 1); updateCartUI(); }
function openCart() {
  document.getElementById('cartDrawer').classList.add('open');
  document.getElementById('drawerOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeCart() {
  document.getElementById('cartDrawer').classList.remove('open');
  document.getElementById('drawerOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ─── MODAL ─────────────────────────────────────────────
let modalCurrentImageIndex = 0;
let modalImageUrls = [];

function openModal(productId) {
  const p = products.find(x => x.id === productId);
  if (!p) return;
  currentModalProduct = p;
  currentModalColor = p.colors[0];
  document.getElementById('modalType').textContent = p.type;
  document.getElementById('modalName').textContent = p.name;
  document.getElementById('modalPrice').textContent = formatPrice(p.price);
  document.getElementById('modalDesc').textContent = p.description || p.desc || 'Premium full-grain leather, hand-stitched by skilled artisans using traditional techniques. Each piece develops a unique patina over time.';
  document.getElementById('modalAddPrice').textContent = formatPrice(p.price);
  
  const mainContainer = document.getElementById('modalMainContainer');
  const thumbsContainer = document.getElementById('modalProductThumbs');
  
  modalCurrentImageIndex = 0;
  modalImageUrls = [];

  if (p.images && p.images.length > 0) {
    modalImageUrls = p.images.map(img => img.image_path);
    
    // Render main image
    let html = `<img src="${modalImageUrls[0]}" class="modal-img-visual" id="modalVisual" style="max-width:100%; max-height:280px; object-fit:contain; border-radius:8px; transition: opacity 0.3s ease;">`;
    
    // Render arrows if more than 1 image
    if (modalImageUrls.length > 1) {
      html += `
        <!-- Left Arrow -->
        <button onclick="navigateModalImage(-1)" class="modal-nav-arrow" style="position: absolute; left: 0px; top: 50%; transform: translateY(-50%); background: rgba(26, 17, 11, 0.65); border: 1px solid var(--border); color: var(--cream); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; z-index: 10; font-size: 14px;" onmouseover="this.style.background='var(--gold)'; this.style.color='var(--bg)'" onmouseout="this.style.background='rgba(26, 17, 11, 0.65)'; this.style.color='var(--cream)'">
          &#10094;
        </button>
        <!-- Right Arrow -->
        <button onclick="navigateModalImage(1)" class="modal-nav-arrow" style="position: absolute; right: 0px; top: 50%; transform: translateY(-50%); background: rgba(26, 17, 11, 0.65); border: 1px solid var(--border); color: var(--cream); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; z-index: 10; font-size: 14px;" onmouseover="this.style.background='var(--gold)'; this.style.color='var(--bg)'" onmouseout="this.style.background='rgba(26, 17, 11, 0.65)'; this.style.color='var(--cream)'">
          &#10095;
        </button>
      `;
    }
    mainContainer.innerHTML = html;
    
    // Render thumbnails
    if (modalImageUrls.length > 1) {
      thumbsContainer.innerHTML = p.images.map((img, index) => `
        <div onclick="changeModalImage('${img.image_path}', ${index}, this)" class="modal-thumb-item ${index === 0 ? 'active' : ''}" style="width: 50px; height: 50px; border: 1px solid ${index === 0 ? 'var(--gold)' : 'var(--border)'}; cursor: pointer; background: var(--bg-card); display: flex; align-items: center; justify-content: center; overflow: hidden; transition: all 0.2s; border-radius: 4px;">
          <img src="${img.image_path}" alt="${img.alt_text || p.name}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      `).join('');
    } else {
      thumbsContainer.innerHTML = '';
    }
  } else {
    mainContainer.innerHTML = `<div class="product-visual modal-img-visual ${p.shape || ''} ${getColorClass(p.colors[0])}" id="modalVisual"></div>`;
    thumbsContainer.innerHTML = '';
  }

  const colorsDiv = document.getElementById('modalColors');
  colorsDiv.innerHTML = p.colors.map((c, i) => `
    <div class="color-opt ${i===0?'active':''}" onclick="selectModalColor('${c}', this, ${p.id})">
      <div class="color-opt-swatch swatch-${c}"></div>
      <span class="color-opt-name">${c.charAt(0).toUpperCase()+c.slice(1)}</span>
    </div>
  `).join('');
  document.getElementById('modalAddBtn').onclick = () => { addToCart(p.id, currentModalColor); closeModalDirect(); };
  document.getElementById('modalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function selectModalColor(colorName, el, productId) {
  currentModalColor = colorName;
  el.closest('.color-options').querySelectorAll('.color-opt').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  const vis = document.getElementById('modalVisual');
  const p = products.find(x => x.id === productId);
  if (vis && vis.tagName === 'DIV') {
    vis.className = `product-visual modal-img-visual ${p.shape || ''} ${getColorClass(colorName)}`;
  }
}

function changeModalImage(src, index, el) {
  modalCurrentImageIndex = index;
  const mainImg = document.getElementById('modalVisual');
  if (mainImg && mainImg.tagName === 'IMG') {
    mainImg.style.opacity = 0;
    setTimeout(() => {
      mainImg.src = src;
      mainImg.style.opacity = 1;
    }, 150);
  }
  
  document.querySelectorAll('.modal-thumb-item').forEach(item => {
    item.style.borderColor = 'var(--border)';
    item.classList.remove('active');
  });
  el.style.borderColor = 'var(--gold)';
  el.classList.add('active');
}

function navigateModalImage(direction) {
  if (!modalImageUrls || modalImageUrls.length <= 1) return;
  
  modalCurrentImageIndex += direction;
  if (modalCurrentImageIndex < 0) {
    modalCurrentImageIndex = modalImageUrls.length - 1;
  } else if (modalCurrentImageIndex >= modalImageUrls.length) {
    modalCurrentImageIndex = 0;
  }
  
  const nextSrc = modalImageUrls[modalCurrentImageIndex];
  const mainImg = document.getElementById('modalVisual');
  if (mainImg && mainImg.tagName === 'IMG') {
    mainImg.style.opacity = 0;
    setTimeout(() => {
      mainImg.src = nextSrc;
      mainImg.style.opacity = 1;
    }, 150);
  }
  
  // Update thumbnail highlights
  const thumbs = document.querySelectorAll('.modal-thumb-item');
  thumbs.forEach((item, idx) => {
    if (idx === modalCurrentImageIndex) {
      item.style.borderColor = 'var(--gold)';
      item.classList.add('active');
    } else {
      item.style.borderColor = 'var(--border)';
      item.classList.remove('active');
    }
  });
}

function closeModal(e) { if (e.target === document.getElementById('modalOverlay')) closeModalDirect(); }
function closeModalDirect() {
  document.getElementById('modalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ─── TOAST ─────────────────────────────────────────────
function showToast(msg) {
  const t = document.getElementById('toast');
  if (!t) return;
  document.getElementById('toastMsg').textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2800);
}

// ─── NEWSLETTER ────────────────────────────────────────
function handleNewsletter(e) {
  e.preventDefault();
  showToast('Welcome to the Nomad Thread Circle!');
  e.target.reset();
}

// ─── CURSOR ────────────────────────────────────────────
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mouseX = 0, mouseY = 0, ringX = 0, ringY = 0;

if (cursor && ring) {
  document.addEventListener('mousemove', e => { 
    mouseX = e.clientX; 
    mouseY = e.clientY; 
    cursor.style.left = mouseX+'px'; 
    cursor.style.top = mouseY+'px'; 
  });
  
  function animateRing() {
    ringX += (mouseX - ringX) * 0.18;
    ringY += (mouseY - ringY) * 0.18;
    ring.style.left = ringX+'px';
    ring.style.top = ringY+'px';
    requestAnimationFrame(animateRing);
  }
  animateRing();
  
  // Re-bind listener for cursor expansions
  function bindCursorExpands() {
    document.querySelectorAll('a, button, [class*="btn"], .cat-card, .product-card, .blog-card, .swatch, .forum-search-input, .comment-textarea').forEach(el => {
      el.removeEventListener('mouseenter', expandRing);
      el.removeEventListener('mouseleave', shrinkRing);
      el.addEventListener('mouseenter', expandRing);
      el.addEventListener('mouseleave', shrinkRing);
    });
  }
  
  function expandRing() { ring.classList.add('expand'); }
  function shrinkRing() { ring.classList.remove('expand'); }
  
  // Expose cursor binding function globally
  window.bindCursorExpands = bindCursorExpands;
  bindCursorExpands();
}

// ─── SCROLL ────────────────────────────────────────────
const scrollTop = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
  if (scrollTop) {
    scrollTop.classList.toggle('visible', window.scrollY > 600);
  }
  // Reveal animations
  document.querySelectorAll('.reveal').forEach(el => {
    if (el.getBoundingClientRect().top < window.innerHeight - 80) el.classList.add('visible');
  });
});

// ─── INIT ──────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
  try {
    const apiUrl = window.routes?.apiProducts || '/api/products';
    const res = await fetch(apiUrl);
    const json = await res.json();
    products = json.data || [];
  } catch (err) {
    console.error('Failed to fetch products:', err);
  }
  const activeFilterBtn = document.querySelector('.filter-bar .filter-btn.active');
  const activeFilter = activeFilterBtn ? activeFilterBtn.getAttribute('data-category') : 'all';
  const grid = document.getElementById('productGrid');
  if (grid && grid.children.length === 0) {
    renderProducts(activeFilter);
  }
  updateCartUI();
  if (window.bindCursorExpands) window.bindCursorExpands();
  setTimeout(() => window.dispatchEvent(new Event('scroll')), 100);
});
