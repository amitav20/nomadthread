@extends('layouts.admin')

@section('title', 'Coupons & Offers | LeatherCraft')
@section('page_title', 'Coupons & Offers')
@section('page_breadcrumb', 'Marketing / Coupons')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Coupons & Offers</div><div class="page-subheading">Manage discount codes</div></div>
  <div class="page-actions"><button class="btn btn-gold"><i class="ti ti-plus"></i> Create Coupon</button></div>
</div>
<div class="two-col">
  <div>
    <div class="coupon-card"><div class="coupon-code">LEATHER20</div><div><p style="font-size:13px;font-weight:500;color:var(--text);">20% Off All Bags</p><span style="font-size:12px;color:var(--text3);">Min. ₹2,000 · Expires 30 Jun</span></div><div class="coupon-meta"><span class="badge badge-green">Active</span><p style="font-size:11px;color:var(--text3);margin-top:4px;">Used 142×</p></div></div>
    <div class="coupon-card"><div class="coupon-code">FLAT500</div><div><p style="font-size:13px;font-weight:500;color:var(--text);">₹500 Flat Discount</p><span style="font-size:12px;color:var(--text3);">Min. ₹3,000 · No expiry</span></div><div class="coupon-meta"><span class="badge badge-green">Active</span><p style="font-size:11px;color:var(--text3);margin-top:4px;">Used 89×</p></div></div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">Create Coupon</div></div>
    <div class="card-body">
      <div class="form-group"><label class="form-label">Coupon Code</label><input type="text" class="form-input" placeholder="e.g. NEWUSER15"></div>
      <div class="form-group"><label class="form-label">Discount Type</label><select class="form-input"><option>Percentage (%)</option><option>Fixed Amount (₹)</option><option>Free Shipping</option></select></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Value</label><input type="number" class="form-input" placeholder="15"></div>
        <div class="form-group"><label class="form-label">Min. Order</label><input type="number" class="form-input" placeholder="1000"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Start Date</label><input type="date" class="form-input"></div>
        <div class="form-group"><label class="form-label">End Date</label><input type="date" class="form-input"></div>
      </div>
      <button class="btn btn-gold btn-block"><i class="ti ti-plus"></i> Create Coupon</button>
    </div>
  </div>
</div>
@endsection
