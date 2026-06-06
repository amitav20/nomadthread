@extends('layouts.admin')

@section('title', 'Shipping | LeatherCraft')
@section('page_title', 'Shipping')
@section('page_breadcrumb', 'Config / Shipping')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Shipping</div><div class="page-subheading">Configure delivery zones and rates</div></div>
  <div class="page-actions"><button class="btn btn-gold"><i class="ti ti-plus"></i> Add Zone</button></div>
</div>
<div class="card">
  <div class="card-head"><div class="card-title">Shipping Zones</div></div>
  <div style="padding:16px 20px;">
    <div class="shipping-zone">
      <div class="shipping-zone-head"><div style="font-size:14px;font-weight:500;color:var(--text)"><i class="ti ti-map-pin" style="margin-right:6px;color:var(--gold)"></i>Metro Cities</div><div style="display:flex;gap:8px;"><span class="badge badge-green">Active</span><button class="btn btn-outline btn-sm"><i class="ti ti-edit"></i></button></div></div>
      <div style="font-size:12.5px;color:var(--text3);margin-bottom:10px;">Mumbai, Delhi, Bengaluru, Hyderabad, Chennai, Kolkata</div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
        <div style="background:var(--bg4);border-radius:8px;padding:10px 12px;"><div style="color:var(--text3);font-size:11px;margin-bottom:4px;">Standard (3–5 days)</div><div style="color:var(--text);font-weight:500;">₹99</div></div>
        <div style="background:var(--bg4);border-radius:8px;padding:10px 12px;"><div style="color:var(--text3);font-size:11px;margin-bottom:4px;">Express (1–2 days)</div><div style="color:var(--text);font-weight:500;">₹199</div></div>
        <div style="background:var(--bg4);border-radius:8px;padding:10px 12px;"><div style="color:var(--text3);font-size:11px;margin-bottom:4px;">Free above</div><div style="color:var(--gold2);font-weight:500;">₹2,000</div></div>
      </div>
    </div>
  </div>
</div>
@endsection
