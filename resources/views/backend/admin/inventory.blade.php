@extends('layouts.admin')

@section('title', 'Inventory | LeatherCraft')
@section('page_title', 'Inventory')
@section('page_breadcrumb', 'Catalogue / Inventory')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Inventory</div><div class="page-subheading">Track stock levels across products</div></div>
  <div class="page-actions"><button class="btn btn-gold"><i class="ti ti-plus"></i> Add Stock</button></div>
</div>
<div class="card">
  <div class="table-wrap"><table>
    <thead><tr><th>Product</th><th>SKU</th><th>In Stock</th><th>Available</th><th>Stock Level</th><th>Status</th></tr></thead>
    <tbody>
      <tr><td>Milano Tote Bag</td><td style="font-family:monospace;font-size:12px;">LTH-001</td><td>48</td><td>42</td><td><div class="stock-bar"><div class="stock-track"><div class="stock-fill high" style="width:84%"></div></div><span style="font-size:11px;color:var(--text3)">84%</span></div></td><td><span class="badge badge-green">Good</span></td></tr>
      <tr><td>Slim Bifold Wallet</td><td style="font-family:monospace;font-size:12px;">LTH-014</td><td>120</td><td>108</td><td><div class="stock-bar"><div class="stock-track"><div class="stock-fill high" style="width:100%"></div></div><span style="font-size:11px;color:var(--text3)">100%</span></div></td><td><span class="badge badge-green">Good</span></td></tr>
      <tr><td>Executive Briefcase</td><td style="font-family:monospace;font-size:12px;">LTH-007</td><td>12</td><td>8</td><td><div class="stock-bar"><div class="stock-track"><div class="stock-fill mid" style="width:24%"></div></div><span style="font-size:11px;color:var(--text3)">24%</span></div></td><td><span class="badge badge-amber">Low</span></td></tr>
      <tr><td>Classic Clutch Purse</td><td style="font-family:monospace;font-size:12px;">LTH-031</td><td>0</td><td>0</td><td><div class="stock-bar"><div class="stock-track"><div class="stock-fill low" style="width:0%"></div></div><span style="font-size:11px;color:var(--text3)">0%</span></div></td><td><span class="badge badge-red">Out</span></td></tr>
    </tbody>
  </table></div>
</div>
@endsection
