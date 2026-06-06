@extends('layouts.admin')

@section('title', 'Orders | LeatherCraft')
@section('page_title', 'Orders')
@section('page_breadcrumb', 'Sales / Orders')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Orders</div><div class="page-subheading">{{ $orders->where('status', 'Pending')->count() }} new orders need attention</div></div>
  <div class="page-actions"><button class="btn btn-outline" onclick="alert('CSV export completed!')"><i class="ti ti-download"></i> Export CSV</button></div>
</div>
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
  <div class="stat-card"><div class="stat-label">Pending</div><div class="stat-value" style="font-size:22px;">{{ $orders->where('status', 'Pending')->count() }}</div><div class="stat-change" style="color:var(--blue2);">Awaiting confirmation</div></div>
  <div class="stat-card"><div class="stat-label">Processing</div><div class="stat-value" style="font-size:22px;">{{ $orders->where('status', 'Processing')->count() }}</div><div class="stat-change" style="color:var(--amber2);">Being prepared</div></div>
  <div class="stat-card"><div class="stat-label">Shipped</div><div class="stat-value" style="font-size:22px;">{{ $orders->where('status', 'Shipped')->count() }}</div><div class="stat-change" style="color:var(--gold2);">Out for delivery</div></div>
  <div class="stat-card"><div class="stat-label">Completed</div><div class="stat-value" style="font-size:22px;">{{ $orders->where('status', 'Completed')->count() }}</div><div class="stat-change up">Successfully delivered</div></div>
</div>
<div class="filter-bar">
  <div class="search-box"><i class="ti ti-search" style="color:var(--text3)"></i><input type="text" placeholder="Order ID, customer…"></div>
  <select class="form-input" style="width:140px"><option>All Status</option><option>Pending</option><option>Processing</option><option>Shipped</option><option>Completed</option><option>Cancelled</option></select>
  <input type="date" class="form-input" style="width:160px">
  <input type="date" class="form-input" style="width:160px">
</div>
<div class="card">
  <div class="tab-row">
    <div class="tab-item active">All ({{ count($orders) }})</div>
    <div class="tab-item">Pending <span class="nav-badge" style="background:var(--red);color:#fff;font-size:10px;padding:1px 5px;border-radius:8px;margin-left:4px;">{{ $orders->where('status', 'Pending')->count() }}</span></div>
    <div class="tab-item">Processing ({{ $orders->where('status', 'Processing')->count() }})</div>
    <div class="tab-item">Shipped ({{ $orders->where('status', 'Shipped')->count() }})</div>
    <div class="tab-item">Completed ({{ $orders->where('status', 'Completed')->count() }})</div>
  </div>
  <div class="table-wrap"><table>
    <thead><tr><th>Order ID</th><th>Customer</th><th>Products</th><th>Date</th><th>Amount</th><th>Payment</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($orders as $order)
        <tr>
          <td>#{{ $order->order_number }}</td>
          <td>{{ $order->customer_name }}<div><small style="color:var(--text3)">{{ $order->customer_email }}</small></div></td>
          <td>{{ $order->id % 2 + 1 }} items</td>
          <td>{{ $order->created_at->format('d M Y') }}</td>
          <td>₹{{ number_format($order->total, 0, '.', ',') }}</td>
          <td><span class="badge @if($order->payment_status == 'Paid') badge-green @else badge-amber @endif">{{ $order->payment_status }}</span></td>
          <td>
            <span class="badge @if($order->status == 'Completed') badge-green @elseif($order->status == 'Pending') badge-amber @elseif($order->status == 'Processing') badge-blue @else badge-red @endif">
              {{ $order->status }}
            </span>
          </td>
          <td><button class="btn btn-outline btn-sm" onclick="alert('Viewing order #{{ $order->order_number }} details!')"><i class="ti ti-eye"></i></button></td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center; padding: 20px;">No orders found.</td></tr>
      @endforelse
    </tbody>
  </table></div>
  <div class="pagination"><span style="font-size:13px;color:var(--text3);">Showing 1–{{ count($orders) }} of {{ count($orders) }}</span><div style="display:flex;gap:6px;"><button class="btn btn-outline btn-sm"><i class="ti ti-chevron-left"></i></button><button class="btn btn-outline btn-sm" style="background:rgba(201,168,76,.1);color:var(--gold2);border-color:var(--gold-dim);">1</button><button class="btn btn-outline btn-sm"><i class="ti ti-chevron-right"></i></button></div></div>
</div>
@endsection
