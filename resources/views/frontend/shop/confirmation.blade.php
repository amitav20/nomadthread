@extends('layouts.frontend')

@section('title', 'Order Confirmed | Nomad Thread')

@section('content')
<section class="confirmation-section" style="padding-top: 140px; padding-bottom: 80px; min-height: 85vh; background: var(--bg);">
  <div class="section-inner" style="max-width: 800px; margin: 0 auto; padding: 0 20px; text-align: center;">
    
    <!-- Animated Check Circle -->
    <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(39, 174, 96, 0.1); border: 2px solid var(--green); display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 36px; color: var(--green); animation: pulseGreen 2s infinite;">
      ✓
    </div>

    <span style="font-family: 'Jost', sans-serif; font-size: 11px; text-transform: uppercase; letter-spacing: 3px; color: var(--gold); display: block; margin-bottom: 10px;">
      Transaction Completed Successfully
    </span>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 40px; color: var(--cream); margin-bottom: 15px; font-weight: 500;">
      Thank you for your <em>Order</em>
    </h1>
    <p style="font-family: 'Cormorant Garamond', serif; font-size: 19px; color: var(--text-light); line-height: 1.6; max-width: 550px; margin: 0 auto 40px;">
      We have received your payment. Our master leathercraft artisans are now preparing your handcrafted goods. A confirmation receipt has been sent to your email.
    </p>

    <!-- Receipt Card -->
    <div class="card" style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; text-align: left; padding: 30px; margin-bottom: 40px; font-family: 'Jost', sans-serif;">
      <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 15px; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
          <div style="font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Order Reference</div>
          <div style="font-size: 18px; font-weight: 600; color: var(--gold); margin-top: 3px;">{{ $order->order_number }}</div>
        </div>
        <div style="text-align: right;">
          <div style="font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Order Date</div>
          <div style="font-size: 14px; color: var(--cream); margin-top: 3px;">{{ $order->created_at->format('F d, Y h:i A') }}</div>
        </div>
      </div>

      <!-- Customer Details -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
        <div>
          <h4 style="font-family: 'Playfair Display', serif; font-size: 15px; color: var(--cream); margin-bottom: 10px;">Shipping Details</h4>
          <p style="font-size: 13.5px; color: var(--text-light); line-height: 1.5; margin: 0;">
            <strong style="color:var(--cream);">{{ $order->customer_name }}</strong><br>
            {{ $order->shipping_address }}<br>
            Phone: {{ $order->customer_phone }}
          </p>
        </div>
        <div>
          <h4 style="font-family: 'Playfair Display', serif; font-size: 15px; color: var(--cream); margin-bottom: 10px;">Payment Summary</h4>
          <p style="font-size: 13.5px; color: var(--text-light); line-height: 1.5; margin: 0;">
            Method: <strong style="color:var(--cream);">{{ $order->payment_method }}</strong><br>
            Status: <span style="color: var(--green); font-weight: 600;">Paid</span><br>
            Delivery: Standard Carrier
          </p>
        </div>
      </div>

      <!-- Items Ordered -->
      <h4 style="font-family: 'Playfair Display', serif; font-size: 15px; color: var(--cream); margin-bottom: 15px;">Items Ordered</h4>
      <div style="display: flex; flex-direction: column; gap: 12px; border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 20px;">
        @php
          $items = explode(', ', $order->notes);
        @endphp
        @foreach($items as $item)
          @if(!empty(trim($item)))
            <div style="display: flex; justify-content: space-between; font-size: 13.5px; color: var(--text-light);">
              <span>✦ {{ trim($item) }}</span>
            </div>
          @endif
        @endforeach
      </div>

      <!-- Totals -->
      <div style="display: flex; flex-direction: column; gap: 8px; max-width: 320px; margin-left: auto; font-size: 13.5px; color: var(--text-light);">
        <div style="display: flex; justify-content: space-between;">
          <span>Subtotal</span>
          <span class="conf-price" data-price="{{ $order->subtotal }}" style="color: var(--cream);">₹{{ number_format($order->subtotal) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <span>Tax / GST</span>
          <span class="conf-price" data-price="{{ $order->tax }}" style="color: var(--cream);">₹{{ number_format($order->tax) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <span>Shipping</span>
          <span class="conf-price" data-price="500" style="color: var(--cream);">₹500</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 16px; border-top: 1px solid var(--border); padding-top: 10px; margin-top: 5px;">
          <span style="color: var(--cream);">Grand Total</span>
          <span class="conf-price" data-price="{{ $order->total }}" style="color: var(--gold);">₹{{ number_format($order->total) }}</span>
        </div>
      </div>

    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 15px; justify-content: center;">
      <a href="{{ route('shop.index') }}" class="btn-checkout" style="text-decoration:none; display: inline-block; padding: 14px 28px; background: var(--gold); color: var(--bg); font-family: 'Jost', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; border-radius: 4px;">
        Continue Shopping
      </a>
      <a href="{{ route('home') }}" class="btn-checkout" style="text-decoration:none; display: inline-block; padding: 14px 28px; background: transparent; border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; border-radius: 4px;" onmouseover="this.style.borderColor='var(--gold)'; this.style.color='var(--gold)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--cream)';">
        Return Home
      </a>
    </div>

  </div>
</section>

<style>
  @keyframes pulseGreen {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.4); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(39, 174, 96, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(39, 174, 96, 0); }
  }
</style>

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
