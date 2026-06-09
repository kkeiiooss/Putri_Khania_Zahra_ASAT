<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @page {
        margin: 0;
    }
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background: #fff;
        color: #000;
        margin: 0;
        padding: 15px 12px;
        font-size: 10px;
        line-height: 1.4;
    }
    .ticket-container {
        width: 100%;
        text-align: center;
        box-sizing: border-box;
    }
    .header-title {
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 2px;
        letter-spacing: 0.5px;
    }
    .header-address {
        font-size: 8.5px;
        margin-bottom: 15px;
        line-height: 1.3;
    }
    .ticket-title {
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }
    .ticket-location {
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 3px;
    }
    .ticket-vehicle {
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 18px;
    }
    .detail-row {
        font-size: 10px;
        margin-bottom: 3px;
    }
    .warning-footer {
        font-size: 7.5px;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 25px;
        line-height: 1.3;
        padding: 0 5px;
    }
</style>
</head>
<body>
<div class="ticket-container">
    <div class="header-title">SIJA PARKING</div>
    <div class="header-address">
        Jl. Raya Karadenan No. 7, Karadenan,<br>
        Kec. Cibinong, Kabupaten Bogor, Jawa<br>
        Barat 16111
    </div>

    <div class="ticket-title">TIKET PARKIR</div>
    <div class="ticket-location">{{ $location->location_name }}</div>
    <div class="ticket-vehicle">{{ $jenisLabel }}</div>

    <div class="detail-row">No Tiket : {{ $transaction->no_tiket }}</div>
    <div class="detail-row">Tanggal : {{ $transaction->masuk->format('Y-m-d H:i:s') }}</div>

    <div class="warning-footer">
        JANGAN MENINGGALKAN TIKET DAN BARANG<br>
        BERHARGA DI DALAM KENDARAAN
    </div>
</div>
</body>
</html>