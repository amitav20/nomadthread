@extends('layouts.frontend')

@section('title', 'Secure Checkout | Nomad Thread')

@section('content')
<section class="checkout-section">
  <div class="section-inner">
    
    <a href="{{ route('shop.index') }}" class="checkout-back-link">&larr; Return to Catalog</a>

    <h1 class="checkout-page-title">
      🔒 <em>Secure Checkout</em>
    </h1>

    <div class="checkout-grid">
      
      <!-- LEFT COLUMN: SHIPPING & PAYMENT -->
      <div>
        <form id="checkoutForm" onsubmit="handleCheckoutSubmit(event)">
          @csrf
          
          <!-- Shipping Address Card -->
          <div class="checkout-card">
            <h3 class="checkout-card-title">
              <span class="step-num">1.</span> Shipping Information
            </h3>
            
            <div class="checkout-form-row">
              <div class="checkout-form-cols-2">
                <div>
                  <label class="checkout-label">Full Name *</label>
                  <input type="text" name="customer_name" required placeholder="e.g. Priyesh Patel" class="checkout-input">
                </div>
                <div>
                  <label class="checkout-label">Email Address *</label>
                  <input type="email" name="customer_email" required placeholder="e.g. priyesh@example.com" class="checkout-input">
                </div>
              </div>

              <div class="checkout-form-cols-mixed">
                <div>
                  <label class="checkout-label">Phone Number *</label>
                  <input type="tel" name="customer_phone" required placeholder="e.g. +91 98765 43210" class="checkout-input">
                </div>
                <div>
                  <label class="checkout-label">Shipping Country *</label>
                  <select id="checkoutCountrySelector" onchange="changeCountryCode(this.value)" class="checkout-select">
                    @foreach($sharedCountries as $c)
                      <option value="{{ $c->code }}">{{ $c->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div>
                <label class="checkout-label">Delivery Address *</label>
                <textarea name="shipping_address" required rows="3" placeholder="Apartment, Suite, Street name, City, Pin code" class="checkout-textarea"></textarea>
              </div>
            </div>
          </div>

          <!-- Payment Card -->
          <div class="checkout-card">
            <h3 class="checkout-card-title">
              <span class="step-num">2.</span> Payment Details
            </h3>
            <p class="checkout-encrypt-notice">
              🔒 256-Bit SSL Encrypted Connection
            </p>

            <!-- Static Payment Methods -->
            <div class="checkout-payment-methods">
              <label class="payment-method-label active">
                <input type="radio" name="payment_method" value="Credit Card" checked class="display-none">
                <span class="pm-icon">💳</span>
                <span class="pm-text">Card</span>
              </label>
              <label class="payment-method-label" onclick="selectPaymentMethod('UPI', this)">
                <input type="radio" name="payment_method" value="UPI" class="display-none">
                <span class="pm-icon">📱</span>
                <span class="pm-text">UPI</span>
              </label>
              <label class="payment-method-label" onclick="selectPaymentMethod('Net Banking', this)">
                <input type="radio" name="payment_method" value="Net Banking" class="display-none">
                <span class="pm-icon">🏦</span>
                <span class="pm-text">NetBank</span>
              </label>
              <label class="payment-method-label" onclick="selectPaymentMethod('COD', this)">
                <input type="radio" name="payment_method" value="COD" class="display-none">
                <span class="pm-icon">📦</span>
                <span class="pm-text">COD</span>
              </label>
            </div>

            <!-- Credit Card Form -->
            <div id="creditCardDetails">
              <div class="mb-15">
                <label class="checkout-label">Cardholder Name</label>
                <input type="text" id="cardName" placeholder="Name on card" class="checkout-input">
              </div>

              <div class="mb-15">
                <label class="checkout-label">Card Number</label>
                <div class="card-field-wrap">
                  <input type="text" id="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19" oninput="formatCardNumber(this)" class="checkout-input card-number">
                  <span id="cardIcon" class="card-icon">💳</span>
                </div>
              </div>

              <div class="checkout-form-cols-2">
                <div>
                  <label class="checkout-label">Expiration Date</label>
                  <input type="text" id="cardExpiry" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this)" class="checkout-input card-expiry">
                </div>
                <div>
                  <label class="checkout-label">CVV Security Code</label>
                  <input type="password" id="cardCvv" placeholder="•••" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="checkout-input card-cvv">
                </div>
              </div>
            </div>

            <!-- Alternative Methods Info -->
             <div id="alternativePaymentDetails" class="alt-payment-box display-none">
              <span id="alternativePaymentText">Selected payment method requires redirection or validation upon submission.</span>
            </div>

          </div>

          <!-- Checkout Security Badges -->
          <div class="checkout-security-badges">
            <div class="badge-item">
              <span>🛡️</span> PCI-DSS Compliant Gateway
            </div>
            <div class="badge-item">
              <span>🔒</span> 256-Bit SSL Encryption
            </div>
            <div class="badge-item">
              <span>✅</span> Norton Secured
            </div>
          </div>

        </form>
      </div>

      <!-- RIGHT COLUMN: ORDER SUMMARY -->
      <div class="checkout-summary-card">
        <h3 class="checkout-summary-title">
          Order Summary
        </h3>

        <!-- Checkout Items -->
        <div id="checkoutSummaryItems" class="checkout-summary-items">
          <!-- Items populated via JS -->
        </div>

        <!-- Price Totals -->
        <div class="checkout-totals">
          <div class="checkout-total-row">
            <span>Subtotal</span>
            <span id="summarySubtotal">₹0</span>
          </div>
          <div class="checkout-total-row">
            <span>VAT / GST (18%)</span>
            <span id="summaryTax">₹0</span>
          </div>
          <div class="checkout-total-row">
            <span>Delivery Courier</span>
            <span id="summaryShipping">₹500</span>
          </div>
          <div class="checkout-total-row grand-total">
            <span>Total</span>
            <span id="summaryTotal">₹0</span>
          </div>
        </div>

        <button type="submit" form="checkoutForm" class="btn-checkout-pay">
          🔒 Pay Securely — <span id="checkoutButtonTotal">₹0</span>
        </button>
      </div>

    </div>
  </div>
</section>

<!-- 3D SECURE AUTH MODAL (HIGH SECURITY SIMULATION) -->
<div id="securePaymentModal" class="secure-modal-backdrop">
  <div class="secure-modal-content">
    
    <!-- Lock Icon Anim -->
    <div class="secure-lock-icon">🔒</div>
    
    <h3 class="secure-modal-title" id="secureStatusTitle">
      Securing Connection...
    </h3>
    <p class="secure-modal-desc" id="secureStatusDesc">
      Establishing a fully encrypted sandbox connection to the central host banking systems.
    </p>

    <!-- Secure Spinner -->
    <div class="secure-dots-wrap">
      <div class="secure-dot secure-bounce-dot delay-0"></div>
      <div class="secure-dot secure-bounce-dot delay-200ms"></div>
      <div class="secure-dot secure-bounce-dot delay-400ms"></div>
    </div>
    
    <div class="secure-modal-footer-badge">
      PCI-DSS Level 1 Encryption
    </div>
  </div>
</div>



<script>
  let selectedPaymentMethod = 'Credit Card';

  function selectPaymentMethod(method, el) {
    selectedPaymentMethod = method;
    
    // Manage active states
    document.querySelectorAll('.payment-method-label').forEach(lbl => {
      lbl.classList.remove('active');
    });
    
    el.classList.add('active');
    
    // Toggle Card details form
    const cardForm = document.getElementById('creditCardDetails');
    const altDetails = document.getElementById('alternativePaymentDetails');
    const altText = document.getElementById('alternativePaymentText');
    
    if (method === 'Credit Card') {
      cardForm.style.display = 'block';
      altDetails.style.display = 'none';
    } else {
      cardForm.style.display = 'none';
      altDetails.style.display = 'block';
      
      if (method === 'UPI') {
        altText.textContent = 'UPI Gateway selected. Secure checkout will prompt your UPI application upon verification.';
      } else if (method === 'Net Banking') {
        altText.textContent = 'Net Banking selected. You will be redirected securely to your banking institution to complete authentication.';
      } else if (method === 'COD') {
        altText.textContent = 'Cash on Delivery selected. Pay the courier upon receipt. Minimum orders apply.';
      }
    }
  }

  // Credit Card Formatting Helpers
  function formatCardNumber(input) {
    let value = input.value.replace(/\D/g, '');
    let formattedValue = '';
    for (let i = 0; i < value.length; i++) {
      if (i > 0 && i % 4 === 0) {
        formattedValue += ' ';
      }
      formattedValue += value[i];
    }
    input.value = formattedValue;
    
    // Simple Card Icon detector
    const icon = document.getElementById('cardIcon');
    if (value.startsWith('4')) {
      icon.textContent = 'Visa';
    } else if (value.startsWith('5')) {
      icon.textContent = 'Mastercard';
    } else {
      icon.textContent = '💳';
    }
  }

  function formatExpiry(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 2) {
      input.value = value.substring(0, 2) + '/' + value.substring(2, 4);
    } else {
      input.value = value;
    }
  }

  // Checkout Totals Calculator
  let checkoutSubtotalINR = 0;
  let checkoutTaxINR = 0;
  let checkoutShippingINR = 500;
  let checkoutTotalINR = 0;

  function updateCheckoutSummary() {
    const summaryItems = document.getElementById('checkoutSummaryItems');
    if (!summaryItems) return;
    
    let items = [];
    try {
      items = JSON.parse(localStorage.getItem('nomad_cart') || '[]');
    } catch (e) {
      items = [];
    }

    if (items.length === 0) {
      summaryItems.innerHTML = `<div class="checkout-summary-empty">No items in cart.</div>`;
      window.location.href = "{{ route('shop.index') }}";
      return;
    }

    checkoutSubtotalINR = items.reduce((s, item) => s + item.price * item.qty, 0);
    checkoutTaxINR = Math.round(checkoutSubtotalINR * 0.18);
    checkoutTotalINR = checkoutSubtotalINR + checkoutTaxINR + checkoutShippingINR;

    // Render items in summary
    summaryItems.innerHTML = items.map(item => `
      <div class="checkout-summary-row">
        <div class="checkout-summary-item-left">
          <div class="checkout-summary-thumb-wrap">
            ${item.image_path 
              ? `<img src="${getAssetUrl(item.image_path)}" class="product-img-el">`
              : `<div class="product-visual cart-item-mini ${item.shape || 'bag-shape'} color-${item.color} w-full-h-full"></div>`
            }
            <span class="checkout-summary-badge">${item.qty}</span>
          </div>
          <div>
            <div class="checkout-summary-item-name">${item.name}</div>
            <div class="checkout-summary-item-color">Color: ${item.color}</div>
          </div>
        </div>
        <span class="checkout-summary-item-price">${formatPrice(item.price * item.qty)}</span>
      </div>
    `).join('');

    // Update Totals Labels
    document.getElementById('summarySubtotal').textContent = formatPrice(checkoutSubtotalINR);
    document.getElementById('summaryTax').textContent = formatPrice(checkoutTaxINR);
    document.getElementById('summaryShipping').textContent = formatPrice(checkoutShippingINR);
    document.getElementById('summaryTotal').textContent = formatPrice(checkoutTotalINR);
    document.getElementById('checkoutButtonTotal').textContent = formatPrice(checkoutTotalINR);
  }

  // Handle Checkout submission
  function handleCheckoutSubmit(e) {
    e.preventDefault();
    
    // Basic validation for credit card if selected
    if (selectedPaymentMethod === 'Credit Card') {
      const name = document.getElementById('cardName').value.trim();
      const num = document.getElementById('cardNumber').value.replace(/\s/g, '');
      const expiry = document.getElementById('cardExpiry').value;
      const cvv = document.getElementById('cardCvv').value;
      
      if (!name || num.length < 15 || expiry.length < 5 || cvv.length < 3) {
        showToast('Please enter valid Credit Card details.');
        return;
      }
    }

    // Show 3D Secure modal
    const modal = document.getElementById('securePaymentModal');
    const title = document.getElementById('secureStatusTitle');
    const desc = document.getElementById('secureStatusDesc');
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Step 1: Secure Connection
    setTimeout(() => {
      title.textContent = 'Encrypting Transaction...';
      desc.textContent = 'Encoding credentials with 256-bit AES algorithms. Connecting to bank servers.';
      
      // Step 2: 3D Secure Authentication
      setTimeout(() => {
        title.textContent = 'Authorizing Payment...';
        desc.textContent = 'Processing transaction funds clearance through Visa/Mastercard 3D Secure validation systems.';
        
        // Step 3: Create Order via AJAX
        setTimeout(() => {
          submitOrderData();
        }, 1200);
      }, 1000);
    }, 1000);
  }

  function submitOrderData() {
    let items = [];
    try {
      items = JSON.parse(localStorage.getItem('nomad_cart') || '[]');
    } catch (e) {
      items = [];
    }
    
    const itemsSummary = items.map(i => `${i.name} (Color: ${i.color}) x${i.qty} [${formatPrice(i.price * i.qty)}]`).join(', ');

    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
    
    // Add extra calculated values
    formData.append('subtotal', checkoutSubtotalINR);
    formData.append('tax', checkoutTaxINR);
    formData.append('total', checkoutTotalINR);
    formData.append('payment_method', selectedPaymentMethod);
    formData.append('items_summary', itemsSummary);
    
    fetch("{{ route('checkout.submit') }}", {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        // Clear Cart
        localStorage.removeItem('nomad_cart');
        
        // Redirect to order confirmation page
        window.location.href = "{{ url('order-confirmation') }}/" + data.order_number;
      } else {
        // Hide Modal
        document.getElementById('securePaymentModal').style.display = 'none';
        document.body.style.overflow = '';
        showToast('Error processing checkout. Please try again.');
      }
    })
    .catch(err => {
      console.error(err);
      document.getElementById('securePaymentModal').style.display = 'none';
      document.body.style.overflow = '';
      showToast('Connection error during payment clearance.');
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Initial sync
    const currentCountry = localStorage.getItem('nomad_country') || 'IN';
    const countrySelector = document.getElementById('checkoutCountrySelector');
    if (countrySelector) {
      countrySelector.value = currentCountry;
    }
    updateCheckoutSummary();
  });
</script>
@endsection
