@extends('layouts.frontend')

@section('title', 'My Orders | Nomad Thread')

@section('content')
<section class="orders-section">
  <div class="section-inner">
    
    <span class="orders-tag">
      Customer Account Dashboard
    </span>
    <h1 class="orders-title">
      Your <em>Order History</em>
    </h1>

    @if(session('success'))
      <div class="alert-success-custom">
        {{ session('success') }}
      </div>
    @endif

    <div class="orders-grid">
      
      <!-- Orders List Card -->
      <div class="orders-card">
        @if($orders->isEmpty())
          <div class="orders-empty">
            <div class="orders-empty-icon">🎒</div>
            <h3 class="orders-empty-h3">No Orders Found</h3>
            <p class="orders-empty-p">
              You haven't placed any orders yet. Visit our shop catalog to explore our handcrafted leather goods.
            </p>
            <a href="{{ route('shop.index') }}" class="btn-checkout">
              Go to Shop
            </a>
          </div>
        @else
          <div class="table-responsive">
            <table class="orders-table">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Items Summary</th>
                  <th>Total Value</th>
                  <th>Payment</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                  <tr>
                    <td class="order-num">{{ $order->order_number }}</td>
                    <td class="order-date">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="order-summary">
                      @php
                        $items = explode(', ', $order->notes);
                      @endphp
                      @foreach($items as $item)
                        @if(!empty(trim($item)))
                          <div class="order-summary-item">✦ {{ trim($item) }}</div>
                        @endif
                      @endforeach
                    </td>
                    <td class="order-value conf-price" data-price="{{ $order->total }}">
                      ₹{{ number_format($order->total) }}
                    </td>
                    <td class="order-payment">
                      <span class="pay-status">{{ $order->payment_status }}</span><br>
                      <span class="pay-method">{{ $order->payment_method }}</span>
                    </td>
                    <td class="order-status">
                      <span class="{{ $order->status === 'Completed' ? 'status-completed' : 'status-pending' }}">
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
