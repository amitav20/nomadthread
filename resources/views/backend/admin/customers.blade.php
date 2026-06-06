@extends('layouts.admin')

@section('title', 'Customers | LeatherCraft')
@section('page_title', 'Customers')
@section('page_breadcrumb', 'Sales / Customers')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Customers</div><div class="page-subheading">8,540 registered customers</div></div>
  <div class="page-actions"><button class="btn btn-outline"><i class="ti ti-download"></i> Export</button></div>
</div>
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
  <div class="stat-card"><div class="stat-label">Total Customers</div><div class="stat-value" style="font-size:22px;">8,540</div><div class="stat-change up">+342 this month</div></div>
  <div class="stat-card"><div class="stat-label">Avg. Order Value</div><div class="stat-value" style="font-size:22px;">₹3,870</div><div class="stat-change up">+₹240 vs last month</div></div>
  <div class="stat-card"><div class="stat-label">Repeat Buyers</div><div class="stat-value" style="font-size:22px;">62%</div><div class="stat-change up">+4% vs last month</div></div>
</div>
<div class="two-col">
  <div class="card">
    <div class="card-head"><div class="card-title">Recent Customers</div></div>
    <div>
      <div class="customer-row"><div class="cust-avatar">PS</div><div><div style="font-size:13px;font-weight:500;">Priya Sharma</div><div style="font-size:11.5px;color:var(--text3);">priya.s@gmail.com</div></div><div class="cust-orders"><strong>₹18,400</strong>12 orders</div></div>
      <div class="customer-row"><div class="cust-avatar">RV</div><div><div style="font-size:13px;font-weight:500;">Rahul Verma</div><div style="font-size:11.5px;color:var(--text3);">rahul.v@yahoo.com</div></div><div class="cust-orders"><strong>₹7,200</strong>3 orders</div></div>
      <div class="customer-row"><div class="cust-avatar">SN</div><div><div style="font-size:13px;font-weight:500;">Sneha Nair</div><div style="font-size:11.5px;color:var(--text3);">sneha.nair@gmail.com</div></div><div class="cust-orders"><strong>₹24,600</strong>18 orders</div></div>
      <div class="customer-row"><div class="cust-avatar">AS</div><div><div style="font-size:13px;font-weight:500;">Amit Singh</div><div style="font-size:11.5px;color:var(--text3);">amit123@hotmail.com</div></div><div class="cust-orders"><strong>₹4,100</strong>2 orders</div></div>
    </div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">Top Locations</div></div>
    <div class="card-body">
      <div class="progress-wrap"><div class="progress-row"><span>Mumbai</span><span style="color:var(--gold2)">24%</span></div><div class="progress-bar"><div class="progress-fill" style="width:24%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Delhi NCR</span><span style="color:var(--gold2)">21%</span></div><div class="progress-bar"><div class="progress-fill" style="width:21%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Bengaluru</span><span style="color:var(--gold2)">18%</span></div><div class="progress-bar"><div class="progress-fill" style="width:18%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Kolkata</span><span style="color:var(--gold2)">10%</span></div><div class="progress-bar"><div class="progress-fill" style="width:10%"></div></div></div>
    </div>
  </div>
</div>
@endsection
