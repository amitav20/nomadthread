@extends('layouts.admin')

@section('title', 'Payments | LeatherCraft')
@section('page_title', 'Payments')
@section('page_breadcrumb', 'Config / Payments')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Payments</div><div class="page-subheading">Payment gateways and transaction overview</div></div>
</div>
<div class="two-col">
  <div class="card">
    <div class="card-head"><div class="card-title">Payment Methods</div></div>
    <div style="padding:16px 20px;">
      <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border);"><div style="display:flex;align-items:center;gap:10px;"><div style="width:36px;height:24px;background:#1a1aff;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;">RZPAY</div><div><div style="font-size:13px;color:var(--text)">Razorpay</div><div style="font-size:11px;color:var(--text3)">UPI, Cards, Netbanking</div></div></div><span class="badge badge-green">Active</span></div>
      <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border);"><div style="display:flex;align-items:center;gap:10px;"><div style="width:36px;height:24px;background:#00b9f1;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;">PAYTM</div><div><div style="font-size:13px;color:var(--text)">Paytm</div><div style="font-size:11px;color:var(--text3)">Wallet, UPI</div></div></div><span class="badge badge-green">Active</span></div>
      <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;"><div style="display:flex;align-items:center;gap:10px;"><div style="width:36px;height:24px;background:#f5a623;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;">COD</div><div><div style="font-size:13px;color:var(--text)">Cash on Delivery</div><div style="font-size:11px;color:var(--text3)">Metro only</div></div></div><span class="badge badge-green">Active</span></div>
    </div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">Payment Split</div></div>
    <div class="card-body">
      <div class="progress-wrap"><div class="progress-row"><span>UPI / PhonePe</span><span style="color:var(--gold2)">48%</span></div><div class="progress-bar"><div class="progress-fill" style="width:48%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Credit / Debit Card</span><span style="color:var(--gold2)">28%</span></div><div class="progress-bar"><div class="progress-fill" style="width:28%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Cash on Delivery</span><span style="color:var(--gold2)">16%</span></div><div class="progress-bar"><div class="progress-fill" style="width:16%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Net Banking</span><span style="color:var(--gold2)">8%</span></div><div class="progress-bar"><div class="progress-fill" style="width:8%"></div></div></div>
    </div>
  </div>
</div>
@endsection
