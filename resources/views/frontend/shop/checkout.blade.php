@extends('layouts.frontend')

@section('title', 'Secure Checkout | Nomad Thread')

@section('content')
<section class="checkout-section" style="padding-top: 140px; padding-bottom: 80px; min-height: 85vh; background: var(--bg);">
  <div class="section-inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    
    <div style="margin-bottom: 30px;">
      <a href="{{ route('shop.index') }}" style="color: var(--gold); text-decoration: none; font-size: 14px; font-family: 'Jost', sans-serif;">&larr; Return to Catalog</a>
    </div>

    <h1 style="font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 500; color: var(--cream); margin-bottom: 40px; border-bottom: 1px solid var(--border); padding-bottom: 15px; display: flex; align-items: center; gap: 10px;">
      🔒 <em>Secure Checkout</em>
    </h1>

    <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 50px; align-items: start;">
      
      <!-- LEFT COLUMN: SHIPPING & PAYMENT -->
      <div>
        <form id="checkoutForm" onsubmit="handleCheckoutSubmit(event)">
          @csrf
          
          <!-- Shipping Address Card -->
          <div class="card" style="background: var(--bg-card); border: 1px solid var(--border); padding: 30px; border-radius: 8px; margin-bottom: 30px;">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 20px; color: var(--cream); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <span style="color:var(--gold)">1.</span> Shipping Information
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                  <label style="display: block; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Full Name *</label>
                  <input type="text" name="customer_name" required placeholder="e.g. Priyesh Patel" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px;">
                </div>
                <div>
                  <label style="display: block; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Email Address *</label>
                  <input type="email" name="customer_email" required placeholder="e.g. priyesh@example.com" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px;">
                </div>
              </div>

              <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 15px;">
                <div>
                  <label style="display: block; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Phone Number *</label>
                  <input type="tel" name="customer_phone" required placeholder="e.g. +91 98765 43210" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px;">
                </div>
                <div>
                  <label style="display: block; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Shipping Country *</label>
                  <select id="checkoutCountrySelector" onchange="changeCountryCode(this.value)" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px; cursor: pointer;">
                    @foreach($sharedCountries as $c)
                      <option value="{{ $c->code }}">{{ $c->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div>
                <label style="display: block; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Delivery Address *</label>
                <textarea name="shipping_address" required rows="3" placeholder="Apartment, Suite, Street name, City, Pin code" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px; resize: none;"></textarea>
              </div>
            </div>
          </div>

          <!-- Payment Card -->
          <div class="card" style="background: var(--bg-card); border: 1px solid var(--border); padding: 30px; border-radius: 8px; margin-bottom: 30px;">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 20px; color: var(--cream); margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
              <span style="color:var(--gold)">2.</span> Payment Details
            </h3>
            <p style="font-family: 'Jost', sans-serif; font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 25px;">
              🔒 256-Bit SSL Encrypted Connection
            </p>

            <!-- Static Payment Methods -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 25px;">
              <label class="payment-method-label active" style="border: 1px solid var(--gold); background: rgba(201, 168, 76, 0.05); padding: 12px 6px; border-radius: 6px; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;">
                <input type="radio" name="payment_method" value="Credit Card" checked style="display:none;">
                <span style="font-size: 18px;">💳</span>
                <span style="font-family: 'Jost', sans-serif; font-size: 10px; color: var(--cream); text-transform: uppercase; font-weight: 500;">Card</span>
              </label>
              <label class="payment-method-label" onclick="selectPaymentMethod('UPI', this)" style="border: 1px solid var(--border); padding: 12px 6px; border-radius: 6px; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;">
                <input type="radio" name="payment_method" value="UPI" style="display:none;">
                <span style="font-size: 18px;">📱</span>
                <span style="font-family: 'Jost', sans-serif; font-size: 10px; color: var(--cream); text-transform: uppercase; font-weight: 500;">UPI</span>
              </label>
              <label class="payment-method-label" onclick="selectPaymentMethod('Net Banking', this)" style="border: 1px solid var(--border); padding: 12px 6px; border-radius: 6px; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;">
                <input type="radio" name="payment_method" value="Net Banking" style="display:none;">
                <span style="font-size: 18px;">🏦</span>
                <span style="font-family: 'Jost', sans-serif; font-size: 10px; color: var(--cream); text-transform: uppercase; font-weight: 500;">NetBank</span>
              </label>
              <label class="payment-method-label" onclick="selectPaymentMethod('COD', this)" style="border: 1px solid var(--border); padding: 12px 6px; border-radius: 6px; text-align: center; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;">
                <input type="radio" name="payment_method" value="COD" style="display:none;">
                <span style="font-size: 18px;">📦</span>
                <span style="font-family: 'Jost', sans-serif; font-size: 10px; color: var(--cream); text-transform: uppercase; font-weight: 500;">COD</span>
              </label>
            </div>

            <!-- Credit Card Form -->
            <div id="creditCardDetails">
              <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-family: 'Jost', sans-serif; font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Cardholder Name</label>
                <input type="text" id="cardName" placeholder="Name on card" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px;">
              </div>

              <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-family: 'Jost', sans-serif; font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Card Number</label>
                <div style="position: relative;">
                  <input type="text" id="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19" oninput="formatCardNumber(this)" style="width: 100%; padding: 12px; padding-right: 45px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px; letter-spacing: 2px;">
                  <span id="cardIcon" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 20px;">💳</span>
                </div>
              </div>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                  <label style="display: block; font-family: 'Jost', sans-serif; font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Expiration Date</label>
                  <input type="text" id="cardExpiry" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this)" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px; text-align: center; letter-spacing: 1px;">
                </div>
                <div class="form-group">
                  <label style="display: block; font-family: 'Jost', sans-serif; font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">CVV Security Code</label>
                  <input type="password" id="cardCvv" placeholder="•••" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px; background: var(--bg); border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-size: 13px; border-radius: 4px; text-align: center; letter-spacing: 3px;">
                </div>
              </div>
            </div>

            <!-- Alternative Methods Info -->
            <div id="alternativePaymentDetails" style="display: none; padding: 20px; background: rgba(26,17,11,0.5); border: 1px dashed var(--border); border-radius: 6px; text-align: center; font-family: 'Jost', sans-serif; font-size: 13px; color: var(--text-light);">
              <span id="alternativePaymentText">Selected payment method requires redirection or validation upon submission.</span>
            </div>

          </div>

          <!-- Checkout Security Badges -->
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 15px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 6px; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light);">
              <span>🛡️</span> PCI-DSS Compliant Gateway
            </div>
            <div style="display: flex; align-items: center; gap: 6px; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light);">
              <span>🔒</span> 256-Bit SSL Encryption
            </div>
            <div style="display: flex; align-items: center; gap: 6px; font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light);">
              <span>✅</span> Norton Secured
            </div>
          </div>

        </form>
      </div>

      <!-- RIGHT COLUMN: ORDER SUMMARY -->
      <div class="card" style="background: var(--bg-card); border: 1px solid var(--border); padding: 30px; border-radius: 8px; position: sticky; top: 120px;">
        <h3 style="font-family: 'Playfair Display', serif; font-size: 20px; color: var(--cream); margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
          Order Summary
        </h3>

        <!-- Checkout Items -->
        <div id="checkoutSummaryItems" style="max-height: 250px; overflow-y: auto; margin-bottom: 20px; display: flex; flex-direction: column; gap: 15px; padding-right: 5px;">
          <!-- Items populated via JS -->
        </div>

        <!-- Price Totals -->
        <div style="border-top: 1px solid var(--border); padding-top: 15px; display: flex; flex-direction: column; gap: 10px; font-family: 'Jost', sans-serif; font-size: 13.5px;">
          <div style="display: flex; justify-content: space-between; color: var(--text-light);">
            <span>Subtotal</span>
            <span id="summarySubtotal" style="color: var(--cream);">₹0</span>
          </div>
          <div style="display: flex; justify-content: space-between; color: var(--text-light);">
            <span>VAT / GST (18%)</span>
            <span id="summaryTax" style="color: var(--cream);">₹0</span>
          </div>
          <div style="display: flex; justify-content: space-between; color: var(--text-light);">
            <span>Delivery Courier</span>
            <span id="summaryShipping" style="color: var(--cream);">₹500</span>
          </div>
          <div style="display: flex; justify-content: space-between; color: var(--text-light); font-weight: 600; border-top: 1px solid var(--border); padding-top: 12px; font-size: 16px;">
            <span style="color: var(--cream);">Total</span>
            <span id="summaryTotal" style="color: var(--gold);">₹0</span>
          </div>
        </div>

        <button type="submit" form="checkoutForm" class="btn-checkout" style="width: 100%; border: none; padding: 16px; background: var(--gold); color: var(--bg); font-family: 'Jost', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: all 0.2s; margin-top: 25px; display: block; text-align: center; border-radius: 4px;">
          🔒 Pay Securely — <span id="checkoutButtonTotal">₹0</span>
        </button>
      </div>

    </div>
  </div>
</section>

<!-- 3D SECURE AUTH MODAL (HIGH SECURITY SIMULATION) -->
<div id="securePaymentModal" style="display: none; position: fixed; inset: 0; background: rgba(13, 8, 5, 0.95); z-index: 9999; align-items: center; justify-content: center; font-family: 'Jost', sans-serif;">
  <div style="background: var(--bg-card); border: 1px solid var(--border); padding: 40px; max-width: 480px; width: 90%; text-align: center; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
    
    <!-- Lock Icon Anim -->
    <div style="font-size: 50px; margin-bottom: 25px; animation: pulse 1.5s infinite;">🔒</div>
    
    <h3 style="font-family: 'Playfair Display', serif; font-size: 22px; color: var(--cream); margin-bottom: 12px;" id="secureStatusTitle">
      Securing Connection...
    </h3>
    <p style="color: var(--text-light); font-size: 13.5px; margin-bottom: 30px;" id="secureStatusDesc">
      Establishing a fully encrypted sandbox connection to the central host banking systems.
    </p>

    <!-- Secure Spinner -->
    <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 20px;">
      <div class="secure-dot" style="width: 10px; height: 10px; border-radius: 50%; background: var(--gold); animation: bounce 1.2s infinite 0s;"></div>
      <div class="secure-dot" style="width: 10px; height: 10px; border-radius: 50%; background: var(--gold); animation: bounce 1.2s infinite 0.2s;"></div>
      <div class="secure-dot" style="width: 10px; height: 10px; border-radius: 50%; background: var(--gold); animation: bounce 1.2s infinite 0.4s;"></div>
    </div>
    
    <div style="font-size: 11px; text-transform: uppercase; color: var(--gold); letter-spacing: 2px;">
      PCI-DSS Level 1 Encryption
    </div>
  </div>
</div>

<style>
  @keyframes pulse {
    0% { transform: scale(1); opacity: 0.8; }
    50% { transform: scale(1.1); opacity: 1; color: var(--gold); }
    100% { transform: scale(1); opacity: 0.8; }
  }
  @keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  
  .payment-method-label {
    transition: all 0.2s ease;
  }
  .payment-method-label:hover {
    border-color: var(--gold) !important;
  }
  .payment-method-label.active {
    border-color: var(--gold) !important;
    background: rgba(201, 168, 76, 0.08) !important;
  }
</style>

<script>
  let selectedPaymentMethod = 'Credit Card';

  function selectPaymentMethod(method, el) {
    selectedPaymentMethod = method;
    
    // Manage active states
    document.querySelectorAll('.payment-method-label').forEach(lbl => {
      lbl.classList.remove('active');
      lbl.style.borderColor = 'var(--border)';
      lbl.style.background = 'transparent';
    });
    
    el.classList.add('active');
    el.style.borderColor = 'var(--gold)';
    el.style.background = 'rgba(201, 168, 76, 0.08)';
    
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
      summaryItems.innerHTML = `<div style="text-align:center; padding: 30px; font-size:13px; color:var(--text-light);">No items in cart.</div>`;
      window.location.href = "{{ route('shop.index') }}";
      return;
    }

    checkoutSubtotalINR = items.reduce((s, item) => s + item.price * item.qty, 0);
    checkoutTaxINR = Math.round(checkoutSubtotalINR * 0.18);
    checkoutTotalINR = checkoutSubtotalINR + checkoutTaxINR + checkoutShippingINR;

    // Render items in summary
    summaryItems.innerHTML = items.map(item => `
      <div style="display:flex; justify-content:space-between; align-items:center; font-family:'Jost',sans-serif; font-size:13px;">
        <div style="display:flex; align-items:center; gap:12px;">
          <div style="position:relative; width:45px; height:45px; border-radius:4px; border:1px solid var(--border); overflow:hidden; background:var(--bg3);">
            ${item.image_path 
              ? `<img src="${getAssetUrl(item.image_path)}" style="width:100%; height:100%; object-fit:cover;">`
              : `<div class="product-visual cart-item-mini ${item.shape || 'bag-shape'} color-${item.color}" style="width:100%; height:100%;"></div>`
            }
            <span style="position:absolute; -right:5px; -top:5px; background:var(--gold); color:var(--bg); border-radius:50%; font-size:9px; font-weight:600; width:15px; height:15px; display:flex; align-items:center; justify-content:center;">${item.qty}</span>
          </div>
          <div>
            <div style="color:var(--cream); font-weight:500;">${item.name}</div>
            <div style="color:var(--text-light); font-size:11px; text-transform:capitalize;">Color: ${item.color}</div>
          </div>
        </div>
        <span style="color:var(--cream); font-weight:500;">${formatPrice(item.price * item.qty)}</span>
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
