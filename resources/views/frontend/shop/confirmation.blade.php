@extends('layouts.frontend')

@section('title', 'Order Confirmed | Nomad Thread')

@section('content')
<section class="confirmation-section">
  <div class="section-inner">
    
    <!-- Animated Check Circle -->
    <div class="confirmation-check-circle">
      ✓
    </div>

    <span class="confirmation-tag">
      Transaction Completed Successfully
    </span>
    <h1 class="confirmation-title">
      Thank you for your <em>Order</em>
    </h1>
    <p class="confirmation-desc">
      We have received your payment. Our master leathercraft artisans are now preparing your handcrafted goods. A confirmation receipt has been sent to your email.
    </p>

    <!-- Receipt Card -->
    <div class="confirmation-card">
      <div class="confirmation-card-header">
        <div class="confirmation-ref-group">
          <div class="confirmation-ref-label">Order Reference</div>
          <div class="confirmation-ref-value">{{ $order->order_number }}</div>
        </div>
        <div class="confirmation-date-group">
          <div class="confirmation-date-label">Order Date</div>
          <div class="confirmation-date-value">{{ $order->created_at->format('F d, Y h:i A') }}</div>
        </div>
      </div>

      <!-- Customer Details -->
      <div class="confirmation-details-grid">
        <div>
          <h4 class="confirmation-card-h4">Shipping Details</h4>
          <p class="confirmation-card-text">
            <strong>{{ $order->customer_name }}</strong><br>
            {{ $order->shipping_address }}<br>
            Phone: {{ $order->customer_phone }}
          </p>
        </div>
        <div>
          <h4 class="confirmation-card-h4">Payment Summary</h4>
          <p class="confirmation-card-text">
            Method: <strong>{{ $order->payment_method }}</strong><br>
            Status: <span class="paid-status">Paid</span><br>
            Delivery: Standard Carrier
          </p>
        </div>
      </div>

      <!-- Items Ordered -->
      <h4 class="confirmation-card-h4">Items Ordered</h4>
      <div class="confirmation-items-list">
        @php
          $items = explode(', ', $order->notes);
        @endphp
        @foreach($items as $item)
          @if(!empty(trim($item)))
            <div class="confirmation-item-row">
              <span>✦ {{ trim($item) }}</span>
            </div>
          @endif
        @endforeach
      </div>

      <!-- Totals -->
      <div class="confirmation-totals-list">
        <div class="confirmation-total-row">
          <span>Subtotal</span>
          <span class="conf-price" data-price="{{ $order->subtotal }}">₹{{ number_format($order->subtotal) }}</span>
        </div>
        <div class="confirmation-total-row">
          <span>Tax / GST</span>
          <span class="conf-price" data-price="{{ $order->tax }}">₹{{ number_format($order->tax) }}</span>
        </div>
        <div class="confirmation-total-row">
          <span>Shipping</span>
          <span class="conf-price" data-price="500">₹500</span>
        </div>
        <div class="confirmation-grand-total">
          <span>Grand Total</span>
          <span class="conf-price" data-price="{{ $order->total }}">₹{{ number_format($order->total) }}</span>
        </div>
      </div>

    </div>

    <!-- Action Buttons -->
    <div class="confirmation-actions">
      <a href="{{ route('shop.index') }}" class="btn-checkout">
        Continue Shopping
      </a>
      <a href="{{ route('home') }}" class="confirmation-btn-home">
        Return Home
      </a>
    </div>

  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Convert receipt pricing according to current selected country
    document.querySelectorAll('.conf-price').forEach(el => {
      const basePrice = parseInt(el.getAttribute('data-price'));
      if (!isNaN(basePrice)) {
        el.textContent = formatPrice(basePrice);
      }
    });
  });
</script>
@endsection
