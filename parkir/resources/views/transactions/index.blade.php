@extends('layouts.app')
@section('page-title', 'Transaction')

@push('styles')
<style>
.vehicle-tab {
    padding: 0.4rem 1.1rem;
    border: 1.5px solid #1a1a2e;
    border-radius: 8px;
    background: #fff;
    color: #1a1a2e;
    font-size: 11.5px; font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.18s;
}
.vehicle-tab.active {
    background: #1a1a2e;
    color: #fff;
    border-color: #1a1a2e;
    box-shadow: 0 4px 12px rgba(26,26,46,0.25);
}
.vehicle-tab:hover:not(.active) { background: #f0f2f8; }

/* Location cards - white/light background like photo */
.location-card {
    background: #fff;
    color: #333;
    border-radius: 16px;
    padding: 1rem;
    cursor: pointer;
    border: 2px solid #eee;
    transition: all 0.18s;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.location-card.active { border-color: var(--pink); box-shadow: 0 4px 18px rgba(233,30,140,0.2); }

/* Clock card - dark with city image effect */
.location-card.clock-card {
    background: linear-gradient(160deg, #0f2027, #203a43, #2c5364);
    color: #fff;
    cursor: default;
    border-color: transparent;
    justify-content: center;
}

/* Icon building on location card */
.loc-icon {
    width: 54px; height: 54px;
    border-radius: 14px;
    background: linear-gradient(135deg, #e91e8c, #9c27b0);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
    margin-bottom: 10px;
    box-shadow: 0 4px 14px rgba(233,30,140,0.35);
}

.clock-display {
    font-size: 20px; font-weight: 800;
    letter-spacing: 2px;
    font-variant-numeric: tabular-nums;
    margin-top: 8px;
    color: #fff;
    background: rgba(0, 0, 0, 0.45);
    padding: 6px 14px;
    border-radius: 8px;
    display: inline-block;
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.clock-sub { font-size: 11px; color: #cbd5e1; margin-bottom: 2px; }

.location-name { font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #222; }
.location-capacity { display: none; }

/* Slot items dengan warna berbeda per jenis */
.location-slots { display: flex; gap: 10px; font-size: 11px; flex-wrap: wrap; justify-content: center; }
.slot-item { display: flex; align-items: center; gap: 3px; font-weight: 700; }

.ticket-item {
    display: flex; align-items: center; gap: 8px;
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--border);
    font-size: 12px; cursor: pointer;
    transition: background 0.12s;
    border-radius: 6px;
    padding-left: 6px;
}
.ticket-item:last-child { border-bottom: none; }
.ticket-item:hover { background: var(--bg); }
.ticket-date { color: var(--text-muted); font-size: 10.5px; }
.ticket-no { font-weight: 700; color: var(--text-main); font-size: 12.5px; }
.ticket-price { margin-left: auto; font-weight: 700; color: var(--pink); font-size: 12px; white-space: nowrap; }

.pdf-badge {
    background: transparent;
    color: #1a1a2e;
    font-size: 11px; font-weight: 700;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px;
    white-space: nowrap;
    flex-shrink: 0;
    border: none;
    padding: 2px 4px;
}
.pdf-badge:hover {
    color: var(--pink);
}

/* Exit button - dark navy */
.btn-exit {
    background: #1a1a2e;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.45rem 1rem;
    font-size: 12px; font-weight: 700;
    cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    transition: background 0.18s;
}
.btn-exit:hover { background: #2a2a4e; }

.tx-section { display: grid; grid-template-columns: 1fr 340px; gap: 1.25rem; }
@media(max-width:768px) { .tx-section { grid-template-columns: 1fr; } }

.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

/* Transaction Input Form title style */
.tx-form-title { font-size: 15px; font-weight: 400; color: var(--text-main); }
.tx-form-title span { color: var(--pink); font-weight: 800; }

.location-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
@media (max-width: 992px) {
    .location-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 576px) {
    .location-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('topbar-actions')
    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        @foreach($vehicleTypes as $vt)
        <button class="vehicle-tab {{ $loop->first ? 'active' : '' }}" onclick="selectVehicle({{ $vt->id }}, this)">
            {{ strtoupper($vt->jenis === 'motorcycle' ? 'Motorcycle' : ($vt->jenis === 'car' ? 'Car' : 'Other')) }}
        </button>
        @endforeach
        <button class="btn-primary" onclick="submitEnter()">
            <i class="fas fa-plus"></i> ENTER VEHICLE
        </button>
    </div>
@endsection

@section('content')

@if(session('total_bayar'))
<div class="modal-overlay" id="payModal">
    <div class="modal-box">
        <div class="modal-icon-success"><i class="fas fa-money-bill-wave"></i></div>
        <div class="modal-title">Pembayaran</div>
        <div class="modal-msg" style="font-size:22px; font-weight:800; color:var(--pink);">
            Rp {{ number_format(session('total_bayar'), 0, ',', '.') }}
        </div>
        <button class="btn-primary" style="justify-content:center; width:100%;"
                onclick="document.getElementById('payModal').style.display='none'">
            <i class="fas fa-check"></i> OK
        </button>
    </div>
</div>
@endif

<!-- Hidden form for direct vehicle entry (bypasses modal) -->
<form method="POST" action="{{ route('transactions.enter') }}" id="directEnterForm" style="display:none;">
    @csrf
    <input type="hidden" name="id_lokasi" id="direct_id_lokasi" value="{{ $locations->first()->id ?? '' }}">
    <input type="hidden" name="id_jenis" id="direct_id_jenis" value="{{ $vehicleTypes->first()->id ?? '' }}">
</form>

<div class="tx-section">

    <div style="display:flex; flex-direction:column; gap:1.25rem;">

        <div class="location-grid">
   
            <div class="location-card clock-card">
                <img src="{{ asset('images/logo.png') }}" onerror="this.src='{{ asset('public/images/logo.png') }}'" alt="logo"
                     style="width:64px; height:64px; object-fit:contain; margin-bottom:6px; filter:drop-shadow(0 2px 8px rgba(0,0,0,0.4));">
                <div class="clock-sub" id="clock-day"></div>
                <div class="clock-sub" id="clock-date"></div>
                <div class="clock-display" id="clock-time"></div>
            </div>

            @foreach($locations as $loc)
            <div class="location-card {{ $loop->first ? 'active' : '' }}"
                 id="loc-card-{{ $loc->id }}"
                 onclick="selectLocation({{ $loc->id }}, this)">
                <div class="loc-icon"><i class="fas fa-building"></i></div>
                <div class="location-name">{{ $loc->location_name }}</div>
                
                <!-- Line 1: Max capacities in grey/slate color -->
                <div class="location-slots" style="margin-bottom:4px; color:#8592a6;">
                    <span class="slot-item"><i class="fas fa-motorcycle"></i> {{ $loc->max_motorcycle }}</span>
                    <span class="slot-item"><i class="fas fa-car"></i> {{ $loc->max_car }}</span>
                    <span class="slot-item"><i class="fas fa-truck"></i> {{ $loc->max_other }}</span>
                </div>

                <!-- Horizontal separator line -->
                <div style="width:80%; height:1px; background:#f0f2f8; margin:6px 0;"></div>

                @php
                    $availMoto  = $loc->getAvailableMotorcycle();
                    $availCar   = $loc->getAvailableCar();
                    $availOther = $loc->getAvailableOther();
                @endphp
                
                <!-- Line 2: Available capacities in green/red -->
                <div class="location-slots">
                    <span class="slot-item" style="color:{{ $availMoto  > 0 ? '#28a745' : '#dc3545' }};"><i class="fas fa-motorcycle"></i> <span id="avail-moto-{{ $loc->id }}">{{ $availMoto }}</span></span>
                    <span class="slot-item" style="color:{{ $availCar   > 0 ? '#28a745' : '#dc3545' }};"><i class="fas fa-car"></i> <span id="avail-car-{{ $loc->id }}">{{ $availCar }}</span></span>
                    <span class="slot-item" style="color:{{ $availOther > 0 ? '#28a745' : '#dc3545' }};"><i class="fas fa-truck"></i> <span id="avail-other-{{ $loc->id }}">{{ $availOther }}</span></span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card" style="margin:0;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.1rem;">
                <div class="tx-form-title"><span>Transaction</span> Input Form</div>
                <form method="POST" action="{{ route('transactions.exit') }}" id="exitForm">
                    @csrf
                    <input type="hidden" name="no_tiket"   id="exit_no_tiket">
                    <input type="hidden" name="no_polisi"  id="exit_no_polisi_hidden">
                    <button type="button" onclick="submitExit()" class="btn-exit">
                        <i class="fas fa-plus"></i> EXIT VEHICLE
                    </button>
                </form>
            </div>
            <div class="form-grid-2">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Ticket Number</label>
                    <input type="text" id="ticketNumber" class="form-control" placeholder="">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Police Number</label>
                    <input type="text" id="policeNumber" class="form-control" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin:0; max-height:440px; overflow-y:auto;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.9rem;">
            <span style="font-weight:700; font-size:14px; color:var(--text-main);">Tickets</span>
            <a href="{{ route('transactions.all') }}" onclick="openAllModal(event)"
               style="background:transparent; color:var(--pink); border:1.5px solid var(--pink); border-radius:8px; padding:4px 14px; font-size:11px; font-weight:700; text-decoration:none; text-transform:uppercase;">
                View All
            </a>
        </div>
        <div id="ticketList">
            @forelse($tickets as $ticket)
            <div class="ticket-item" onclick="fillTicket('{{ $ticket->no_tiket }}')">
                <div style="flex:1; min-width:0;">
                    <div class="ticket-date">{{ $ticket->masuk->format('Y-m-d H:i:s') }}</div>
                    <div class="ticket-no">#{{ $ticket->no_tiket }}</div>
                </div>
                @if($ticket->total_bayar)
                <span class="ticket-price">Rp {{ number_format($ticket->total_bayar, 0, ',', '.') }}</span>
                @endif
                <a href="{{ route('transactions.show-ticket', $ticket->no_tiket) }}" target="_blank"
                   class="pdf-badge" onclick="event.stopPropagation();">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
            @empty
            <p style="color:var(--text-muted); font-size:12px; text-align:center; padding:2rem 0;">
                <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px; opacity:.4;"></i>
                Belum ada tiket.
            </p>
            @endforelse
        </div>
    </div>
</div>

<div class="modal-overlay" id="enterVehicleModal" style="display:none;">
    <div class="modal-box" style="text-align:left; max-width:460px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h3 style="font-size:16px; font-weight:700;">Masukkan Kendaraan</h3>
            <button onclick="closeEnterModal()" class="topbar-icon-btn" style="width:30px;height:30px;font-size:13px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('transactions.enter') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Lokasi Parkir</label>
                <select name="id_lokasi" class="form-control" id="enter_id_lokasi">
                    @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->location_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kendaraan</label>
                <select name="id_jenis" class="form-control" id="enter_id_jenis">
                    @foreach($vehicleTypes as $vt)
                    <option value="{{ $vt->id }}">{{ $vt->jenis_label }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex; gap:10px; margin-top:1.5rem;">
                <button type="button" class="btn-outline" style="flex:1; justify-content:center;" onclick="closeEnterModal()">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="flex:1; justify-content:center;">
                    <i class="fas fa-plus"></i> Enter Vehicle
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="allModal" style="display:none;"
     onclick="if(event.target===this)this.style.display='none'">
    <div class="modal-box" style="max-width:95vw; width:1000px; text-align:left;
         max-height:88vh; overflow-y:auto; padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.1rem;">
            <h3 style="font-size:16px; font-weight:700;">All Transactions</h3>
            <button onclick="document.getElementById('allModal').style.display='none'"
                    class="btn-outline btn-sm">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center;">No.</th>
                        <th style="text-align:center;">Ticket No.</th>
                        <th style="text-align:center;">Police No.</th>
                        <th style="text-align:center;">Location</th>
                        <th style="text-align:center;">Vehicle</th>
                        <th style="text-align:center;">Time In</th>
                        <th style="text-align:center;">Time Out</th>
                        <th style="text-align:center;">1st Hour</th>
                        <th style="text-align:center;">Next Hour</th>
                        <th style="text-align:center;">Max/Day</th>
                        <th style="text-align:center;">Total Hours</th>
                        <th style="text-align:center;">Total Days</th>
                        <th style="text-align:center;">Total Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <a href="{{ route('transactions.show-ticket', $t->no_tiket) }}"
                                   target="_blank" class="pdf-badge" style="margin:0;">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                {{ $t->no_tiket }}
                            </div>
                        </td>
                        <td style="text-align:center;">{{ $t->no_polisi ?? '-' }}</td>
                        <td style="text-align:center;">{{ $t->location->location_name ?? '-' }}</td>
                        <td style="text-align:center;">{{ $t->vehicleType->jenis ?? '-' }}</td>
                        <td style="white-space:nowrap;">{{ $t->masuk->format('Y-m-d H:i:s') }}</td>
                        <td style="white-space:nowrap;">{{ $t->keluar ? $t->keluar->format('Y-m-d H:i:s') : '-' }}</td>
                        <td style="text-align:center;">{{ $t->perjam_pertama    ? 'Rp '.number_format($t->perjam_pertama,0,',','.')    : '-' }}</td>
                        <td style="text-align:center;">{{ $t->perjam_berikutnya ? 'Rp '.number_format($t->perjam_berikutnya,0,',','.') : '-' }}</td>
                        <td style="text-align:center;">{{ $t->max_perhari       ? 'Rp '.number_format($t->max_perhari,0,',','.')       : '-' }}</td>
                        <td style="text-align:center;">{{ $t->total_jam ?? '-' }}</td>
                        <td style="text-align:center;">{{ $t->keluar ? ceil($t->total_jam / 24) : '-' }}</td>
                        <td style="text-align:center;" style="font-weight:700; color:var(--pink);">
                            {{ $t->total_bayar ? 'Rp '.number_format($t->total_bayar,0,',','.') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let selectedLocationId = {{ $locations->first()->id ?? 'null' }};
let selectedVehicleId  = {{ $vehicleTypes->first()->id ?? 'null' }};

function updateClock() {
    const now  = new Date();
    const days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('clock-day').textContent  = days[now.getDay()];
    document.getElementById('clock-date').textContent = now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    document.getElementById('clock-time').textContent = h + ':' + m + ':' + s;
}
setInterval(updateClock, 1000);
updateClock();

function selectLocation(id, el) {
    selectedLocationId = id;
    document.querySelectorAll('.location-card:not(.clock-card)').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    
    // Update direct form value
    const directLoc = document.getElementById('direct_id_lokasi');
    if (directLoc) directLoc.value = id;
    
    // Update modal select if it exists
    const modalLoc = document.getElementById('enter_id_lokasi');
    if (modalLoc) modalLoc.value = id;
}

function selectVehicle(id, el) {
    selectedVehicleId = id;
    document.querySelectorAll('.vehicle-tab').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    
    // Update direct form value
    const directVeh = document.getElementById('direct_id_jenis');
    if (directVeh) directVeh.value = id;
    
    // Update modal select if it exists
    const modalVeh = document.getElementById('enter_id_jenis');
    if (modalVeh) modalVeh.value = id;
}

function submitEnter() {
    const form = document.getElementById('directEnterForm');
    if (form) form.submit();
}

function openEnterModal()  { document.getElementById('enterVehicleModal').style.display = 'flex'; }
function closeEnterModal() { document.getElementById('enterVehicleModal').style.display = 'none'; }

function fillTicket(noTiket) {
    document.getElementById('ticketNumber').value = noTiket;
}

function submitExit() {
    const noTiket  = document.getElementById('ticketNumber').value.trim();
    const noPolisi = document.getElementById('policeNumber').value.trim();
    if (!noTiket)  { alert('Masukkan nomor tiket terlebih dahulu!'); return; }
    if (!noPolisi) { alert('Masukkan nomor polisi terlebih dahulu!'); return; }
    document.getElementById('exit_no_tiket').value = noTiket;
    document.getElementById('exit_no_polisi_hidden').value = noPolisi;
    document.getElementById('exitForm').submit();
}

function openAllModal(e) {
    e.preventDefault();
    document.getElementById('allModal').style.display = 'flex';
}
</script>
@endpush