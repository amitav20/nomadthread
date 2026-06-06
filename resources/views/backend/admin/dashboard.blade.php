@extends('layouts.admin')

@section('title', 'Dashboard | LeatherCraft')
@section('page_title', 'Dashboard')
@section('page_breadcrumb', 'Admin / Dashboard')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Good Morning, Alex 👋</div><div class="page-subheading">Here's what's happening with your store today.</div></div>
  <div class="page-actions">
    <button class="btn btn-outline" onclick="alert('Export completed successfully!')"><i class="ti ti-download"></i> Export</button>
    <a href="{{ route('backend.products.create') }}" class="btn btn-gold"><i class="ti ti-plus"></i> New Product</a>
  </div>
</div>
<div class="stats-grid">
  <div class="stat-card"><div class="stat-label">Total Revenue</div><div class="stat-value">₹{{ number_format($totalRevenue, 0, '.', ',') }}</div><div class="stat-change up"><i class="ti ti-trending-up"></i> +18.4% vs last month</div><div class="stat-icon-bg"><i class="ti ti-currency-rupee"></i></div></div>
  <div class="stat-card"><div class="stat-label">Total Orders</div><div class="stat-value">{{ $ordersCount }}</div><div class="stat-change up"><i class="ti ti-trending-up"></i> +9.2% vs last month</div><div class="stat-icon-bg"><i class="ti ti-shopping-cart"></i></div></div>
  <div class="stat-card"><div class="stat-label">Products Catalogue</div><div class="stat-value">{{ $productsCount }}</div><div class="stat-change up"><i class="ti ti-trending-up"></i> +12.1% vs last month</div><div class="stat-icon-bg"><i class="ti ti-package"></i></div></div>
  <div class="stat-card"><div class="stat-label">Active Customers</div><div class="stat-value">{{ $customersCount }}</div><div class="stat-change down"><i class="ti ti-trending-down"></i> -2.3% vs last month</div><div class="stat-icon-bg"><i class="ti ti-users"></i></div></div>
</div>
<div class="three-col">
  <div class="card">
    <div class="card-head"><div class="card-title">Revenue Overview</div><select class="form-input" style="width:120px;padding:6px 10px;font-size:12px;"><option>Last 7 days</option><option>Last 30 days</option></select></div>
    <div class="chart-area">
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner" style="height:55%"></div></div><div class="chart-label">Mon</div></div>
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner" style="height:72%"></div></div><div class="chart-label">Tue</div></div>
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner" style="height:48%"></div></div><div class="chart-label">Wed</div></div>
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner" style="height:88%"></div></div><div class="chart-label">Thu</div></div>
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner" style="height:65%"></div></div><div class="chart-label">Fri</div></div>
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner" style="height:95%"></div></div><div class="chart-label">Sat</div></div>
      <div class="chart-col"><div class="chart-bar-wrap"><div class="chart-bar-inner active" style="height:78%"></div></div><div class="chart-label">Sun</div></div>
    </div>
    <div style="padding:10px 20px 16px;display:flex;gap:20px;">
      <div><div style="font-size:11px;color:var(--text3);">Today</div><div style="font-size:16px;font-weight:600;color:var(--gold2);">₹18,420</div></div>
      <div><div style="font-size:11px;color:var(--text3);">This Week</div><div style="font-size:16px;font-weight:600;color:var(--text);">₹1,12,800</div></div>
    </div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">Category Sales</div></div>
    <div class="card-body">
      <div class="progress-wrap"><div class="progress-row"><span>Bags & Totes</span><span style="color:var(--gold2)">43%</span></div><div class="progress-bar"><div class="progress-fill" style="width:43%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Wallets</span><span style="color:var(--gold2)">28%</span></div><div class="progress-bar"><div class="progress-fill" style="width:28%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Belts</span><span style="color:var(--gold2)">14%</span></div><div class="progress-bar"><div class="progress-fill" style="width:14%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Cardholders</span><span style="color:var(--gold2)">10%</span></div><div class="progress-bar"><div class="progress-fill" style="width:10%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Others</span><span style="color:var(--gold2)">5%</span></div><div class="progress-bar"><div class="progress-fill" style="width:5%"></div></div></div>
    </div>
  </div>
</div>
<div class="two-col">
  <div class="card">
    <div class="card-head"><div class="card-title">Recent Orders</div><a href="{{ route('backend.orders') }}" class="card-action">View all →</a></div>
    <div class="table-wrap"><table>
      <thead><tr><th>Order</th><th>Customer</th><th>Amount</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($recentOrders as $order)
          <tr>
            <td>#{{ $order->order_number }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>₹{{ number_format($order->total, 0, '.', ',') }}</td>
            <td>
              <span class="badge @if($order->status == 'Completed') badge-green @elseif($order->status == 'Pending') badge-amber @elseif($order->status == 'Processing') badge-blue @else badge-red @endif">
                {{ $order->status }}
              </span>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="text-align:center; padding: 20px;">No orders found.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">Recent Products</div><a href="{{ route('backend.products.index') }}" class="card-action">View all →</a></div>
    <div class="table-wrap"><table>
      <thead><tr><th>Product</th><th>Stock</th><th>Price</th></tr></thead>
      <tbody>
        @forelse($recentProducts as $p)
          <tr>
            <td>
              <div class="product-info">
                <div class="product-thumb" style="display:flex; align-items:center; justify-content:center;">
                  @php
                    $colorsList = explode(',', $p->colors ?? '');
                    $firstColor = trim($colorsList[0] ?? 'tan');
                  @endphp
                  <div class="product-visual {{ $p->shape }}" style="transform: scale(0.3); width: 80px; height: 80px; flex-shrink: 0; background-color: transparent;"></div>
                </div>
                <div class="product-name">{{ $p->name }}<div class="product-sku">{{ $p->sku }}</div></div>
              </div>
            </td>
            <td>{{ $p->stock_quantity }} ({{ $p->stock_status }})</td>
            <td>₹{{ number_format($p->price, 0, '.', ',') }}</td>
          </tr>
        @empty
          <tr><td colspan="3" style="text-align:center; padding: 20px;">No products found.</td></tr>
        @endforelse
      </tbody>
    </table></div>
  </div>
</div>
@endsection
