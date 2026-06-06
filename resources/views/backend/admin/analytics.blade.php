@extends('layouts.admin')

@section('title', 'Analytics | LeatherCraft')
@section('page_title', 'Analytics')
@section('page_breadcrumb', 'Admin / Analytics')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Analytics</div><div class="page-subheading">Deep insights into store performance</div></div>
  <div class="page-actions"><select class="form-input" style="width:160px"><option>Last 30 days</option><option>Last 90 days</option><option>This year</option></select></div>
</div>
<div class="stats-grid">
  <div class="stat-card"><div class="stat-label">Conversion Rate</div><div class="stat-value">3.8%</div><div class="stat-change up">+0.4% vs prev period</div></div>
  <div class="stat-card"><div class="stat-label">Avg. Session</div><div class="stat-value">4m 22s</div><div class="stat-change up">+18s vs prev</div></div>
  <div class="stat-card"><div class="stat-label">Cart Abandonment</div><div class="stat-value">61%</div><div class="stat-change down">+3% vs prev</div></div>
  <div class="stat-card"><div class="stat-label">Return Rate</div><div class="stat-value">4.2%</div><div class="stat-change up">-1.1% vs prev</div></div>
</div>
<div class="two-col">
  <div class="card">
    <div class="card-head"><div class="card-title">Monthly Revenue (2026)</div></div>
    <div class="chart-area" style="height:200px;">
      <div class="chart-col"><div class="chart-bar-wrap" style="height:160px;"><div class="chart-bar-inner" style="height:55%"></div></div><div class="chart-label">Jan</div></div>
      <div class="chart-col"><div class="chart-bar-wrap" style="height:160px;"><div class="chart-bar-inner" style="height:60%"></div></div><div class="chart-label">Feb</div></div>
      <div class="chart-col"><div class="chart-bar-wrap" style="height:160px;"><div class="chart-bar-inner" style="height:70%"></div></div><div class="chart-label">Mar</div></div>
      <div class="chart-col"><div class="chart-bar-wrap" style="height:160px;"><div class="chart-bar-inner" style="height:65%"></div></div><div class="chart-label">Apr</div></div>
      <div class="chart-col"><div class="chart-bar-wrap" style="height:160px;"><div class="chart-bar-inner active" style="height:88%"></div></div><div class="chart-label">May</div></div>
    </div>
  </div>
  <div class="card">
    <div class="card-head"><div class="card-title">Traffic Sources</div></div>
    <div class="card-body">
      <div class="progress-wrap"><div class="progress-row"><span>Organic Search</span><span style="color:var(--gold2)">38%</span></div><div class="progress-bar"><div class="progress-fill" style="width:38%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Instagram / Meta</span><span style="color:var(--gold2)">29%</span></div><div class="progress-bar"><div class="progress-fill" style="width:29%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Direct</span><span style="color:var(--gold2)">18%</span></div><div class="progress-bar"><div class="progress-fill" style="width:18%"></div></div></div>
      <div class="progress-wrap"><div class="progress-row"><span>Email Campaigns</span><span style="color:var(--gold2)">10%</span></div><div class="progress-bar"><div class="progress-fill" style="width:10%"></div></div></div>
    </div>
  </div>
</div>
@endsection
