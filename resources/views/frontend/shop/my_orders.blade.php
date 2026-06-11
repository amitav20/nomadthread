@extends('layouts.frontend')

@section('title', 'My Orders | Nomad Thread')

@section('content')
<section class="orders-section" style="padding-top: 140px; padding-bottom: 80px; min-height: 85vh; background: var(--bg);">
  <div class="section-inner" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
    
    <span style="font-family: 'Jost', sans-serif; font-size: 11px; text-transform: uppercase; letter-spacing: 3px; color: var(--gold); display: block; margin-bottom: 10px;">
      Customer Account Dashboard
    </span>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 40px; color: var(--cream); margin-bottom: 30px; font-weight: 500;">
      Your <em>Order History</em>
    </h1>

    @if(session('success'))
      <div style="background: rgba(39, 174, 96, 0.1); border: 1px solid var(--green); color: var(--green); padding: 15px; border-radius: 4px; margin-bottom: 30px; font-family: 'Jost', sans-serif; font-size: 14px;">
        {{ session('success') }}
      </div>
    @endif

    <div class="checkout-grid" style="display: grid; grid-template-columns: 1fr; gap: 30px;">
      
      <!-- Orders List Card -->
      <div class="card" style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; padding: 30px; font-family: 'Jost', sans-serif;">
        @if($orders->isEmpty())
          <div style="text-align: center; padding: 60px 20px;">
            <div style="font-size: 48px; margin-bottom: 20px;">🎒</div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 22px; color: var(--cream); margin-bottom: 10px;">No Orders Found</h3>
            <p style="font-family: 'Cormorant Garamond', serif; font-size: 18px; color: var(--text-light); max-width: 450px; margin: 0 auto 30px;">
              You haven't placed any orders yet. Visit our shop catalog to explore our handcrafted leather goods.
            </p>
            <a href="{{ route('shop.index') }}" class="btn-checkout" style="text-decoration:none; display: inline-block; padding: 12px 28px; background: var(--gold); color: var(--bg); font-family: 'Jost', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; border-radius: 4px;">
              Go to Shop
            </a>
          </div>
        @else
          <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
              <thead>
                <tr style="border-bottom: 2px solid var(--border); color: var(--cream); padding-bottom: 12px;">
                  <th style="padding: 12px 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;">Order #</th>
                  <th style="padding: 12px 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;">Date</th>
                  <th style="padding: 12px 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;">Items Summary</th>
                  <th style="padding: 12px 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;">Total Value</th>
                  <th style="padding: 12px 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;">Payment</th>
                  <th style="padding: 12px 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 12px;">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                  <tr style="border-bottom: 1px solid var(--border); color: var(--text-light); transition: background 0.2s;" onmouseover="this.style.background='rgba(201,168,76,0.02)'" onmouseout="this.style.background='none'">
                    <td style="padding: 18px 10px; font-weight: 600; color: var(--gold);">{{ $order->order_number }}</td>
                    <td style="padding: 18px 10px; white-space: nowrap;">{{ $order->created_at->format('M d, Y') }}</td>
                    <td style="padding: 18px 10px; max-width: 300px; line-height: 1.4;">
                      @php
                        $items = explode(', ', $order->notes);
                      @endphp
                      @foreach($items as $item)
                        @if(!empty(trim($item)))
                          <div style="font-size: 13px; color: var(--cream);">✦ {{ trim($item) }}</div>
                        @endif
                      @endforeach
                    </td>
                    <td style="padding: 18px 10px; font-weight: 600; color: var(--cream);" class="conf-price" data-price="{{ $order->total }}">
                      ₹{{ number_format($order->total) }}
                    </td>
                    <td style="padding: 18px 10px;">
                      <span style="font-size: 12px; font-weight: 500; color: var(--green);">{{ $order->payment_status }}</span><br>
                      <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-light);">{{ $order->payment_method }}</span>
                    </td>
                    <td style="padding: 18px 10px;">
                      <span style="font-size: 11px; font-weight: 600; text-transform: uppercase; padding: 4px 8px; border-radius: 12px; 
                        background: {{ $order->status === 'Completed' ? 'rgba(39, 174, 96, 0.15)' : 'rgba(201, 168, 76, 0.15)' }};
                        color: {{ $order->status === 'Completed' ? 'var(--green)' : 'var(--gold)' }};">
                        {{ $order->status }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>

    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Dynamic price formatting as per country/currency switching
    document.querySelectorAll('.conf-price').forEach(el => {
      const basePrice = parseInt(el.getAttribute('data-price'));
      if (!isNaN(basePrice)) {
        el.textContent = formatPrice(basePrice);
      }
    });
  });
</script>
@endsection
