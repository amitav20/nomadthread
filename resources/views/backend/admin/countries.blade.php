@extends('layouts.admin')

@section('title', 'Country & Currency Management | NomadThread')
@section('page_title', 'Country & Currency Management')
@section('page_breadcrumb', 'Config / Countries')

@section('content')
@if(session('success'))
  <div style="background:rgba(39,174,96,.15); border:1px solid var(--green); color:var(--green); padding:16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:13.5px;">
    <strong>Success!</strong> {{ session('success') }}
  </div>
@endif

@if($errors->any())
  <div style="background:rgba(192,57,43,.1); border:1px solid var(--red); color:var(--red2); padding:16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:13.5px;">
    <strong>Validation errors occurred:</strong>
    <ul style="margin-top:5px; padding-left:20px;">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="form-layout" style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 30px; align-items: start;">
  
  <!-- LEFT COLUMN: COUNTRIES LIST -->
  <div class="card">
    <div class="card-head">
      <div class="card-title">
        <i class="ti ti-world" style="margin-right:8px;color:var(--gold)"></i>Active Countries & Currencies
      </div>
    </div>
    <div class="card-body" style="padding: 0;">
      <table style="width: 100%; border-collapse: collapse; font-family: 'DM Sans', sans-serif; font-size: 13.5px;">
        <thead>
          <tr style="background: var(--bg3); border-bottom: 1px solid var(--border); text-align: left;">
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2);">Country Code</th>
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2);">Country Name</th>
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2);">Currency Code</th>
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2);">Symbol</th>
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2);">Exchange Rate (to INR)</th>
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2);">Status</th>
            <th style="padding: 14px 18px; font-weight: 600; color: var(--text2); text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($countries as $country)
            <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='var(--bg3)'" onmouseout="this.style.background='none'">
              <td style="padding: 14px 18px; font-weight: 600; color: var(--gold);">{{ $country->code }}</td>
              <td style="padding: 14px 18px; color: var(--text1);">{{ $country->name }}</td>
              <td style="padding: 14px 18px; color: var(--text2);">{{ $country->currency_code }}</td>
              <td style="padding: 14px 18px; font-weight: 600; color: var(--text1);">{{ $country->currency_symbol }}</td>
              <td style="padding: 14px 18px; color: var(--text2);">{{ number_format($country->exchange_rate, 4) }}</td>
              <td style="padding: 14px 18px;">
                <span style="font-size: 11px; font-weight: 600; text-transform: uppercase; padding: 4px 8px; border-radius: 12px; 
                  background: {{ $country->status === 'active' ? 'rgba(39, 174, 96, 0.15)' : 'rgba(127, 140, 141, 0.15)' }};
                  color: {{ $country->status === 'active' ? 'var(--green)' : 'var(--text3)' }};">
                  {{ $country->status }}
                </span>
              </td>
              <td style="padding: 14px 18px; text-align: right; white-space: nowrap;">
                <button onclick="editCountry({{ json_encode($country) }})" class="btn btn-outline" style="padding: 4px 8px; font-size: 11px; margin-right: 5px;" title="Edit">
                  <i class="ti ti-edit"></i> Edit
                </button>
                <form action="{{ route('backend.countries.destroy', $country->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this country?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline" style="padding: 4px 8px; font-size: 11px; color: var(--red);" title="Delete">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="padding: 40px; text-align: center; color: var(--text3);">No countries found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- RIGHT COLUMN: ADD / EDIT FORM -->
  <div class="card" id="formCard">
    <div class="card-head">
      <div class="card-title" id="formTitle">
        <i class="ti ti-plus" style="margin-right:8px;color:var(--gold)"></i>Add New Country
      </div>
    </div>
    <div class="card-body">
      <form id="countryForm" action="{{ route('backend.countries.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        
        <div class="form-group">
          <label class="form-label">Country Name <span>*</span></label>
          <input type="text" name="name" id="countryName" class="form-input" placeholder="e.g. Australia" required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Country Code <span>*</span></label>
            <input type="text" name="code" id="countryCode" class="form-input" placeholder="e.g. AU" maxlength="5" required>
            <div class="form-hint">ISO 2-letter code preferred</div>
          </div>
          <div class="form-group">
            <label class="form-label">Status <span>*</span></label>
            <select name="status" id="countryStatus" class="form-input" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Currency Code <span>*</span></label>
            <input type="text" name="currency_code" id="currencyCode" class="form-input" placeholder="e.g. AUD" required>
          </div>
          <div class="form-group">
            <label class="form-label">Symbol <span>*</span></label>
            <input type="text" name="currency_symbol" id="currencySymbol" class="form-input" placeholder="e.g. A$" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Exchange Rate (vs INR Base) <span>*</span></label>
          <input type="number" name="exchange_rate" id="exchangeRate" class="form-input" placeholder="e.g. 0.018" step="0.0001" min="0" required>
          <div class="form-hint">Value of 1 INR in this currency (e.g. 1 INR = 0.012 USD)</div>
        </div>

        <div style="margin-top: 25px; display: flex; gap: 10px;">
          <button type="submit" class="btn btn-gold" style="flex: 1;"><i class="ti ti-device-floppy"></i> Save Country</button>
          <button type="button" id="cancelBtn" onclick="resetForm()" class="btn btn-outline" style="display: none;">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function editCountry(country) {
    document.getElementById('formTitle').innerHTML = '<i class="ti ti-edit" style="margin-right:8px;color:var(--gold)"></i>Edit Country: ' + country.name;
    
    // Set form action and method to PUT
    const form = document.getElementById('countryForm');
    form.action = "{{ url('backend/countries') }}/" + country.id;
    document.getElementById('formMethod').value = 'PUT';
    
    // Fill values
    document.getElementById('countryName').value = country.name;
    document.getElementById('countryCode').value = country.code;
    document.getElementById('countryStatus').value = country.status;
    document.getElementById('currencyCode').value = country.currency_code;
    document.getElementById('currencySymbol').value = country.currency_symbol;
    document.getElementById('exchangeRate').value = country.exchange_rate;
    
    // Show cancel button
    document.getElementById('cancelBtn').style.display = 'inline-block';
    
    // Scroll to form on mobile
    document.getElementById('formCard').scrollIntoView({ behavior: 'smooth' });
  }

  function resetForm() {
    document.getElementById('formTitle').innerHTML = '<i class="ti ti-plus" style="margin-right:8px;color:var(--gold)"></i>Add New Country';
    
    const form = document.getElementById('countryForm');
    form.action = "{{ route('backend.countries.store') }}";
    document.getElementById('formMethod').value = 'POST';
    
    form.reset();
    document.getElementById('cancelBtn').style.display = 'none';
  }
</script>
@endsection
