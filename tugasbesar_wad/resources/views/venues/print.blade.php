<!DOCTYPE html>
<html>
<head>
    <title>Laporan Daftar Ruangan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 11px; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; }
        .tgl { float: right; font-size: 11px; margin-bottom: 10px; }
        
        /* Helper Classes */
        .center { text-align: center; }
        .text-muted { color: #555; font-size: 10px; }
    </style>
</head>
<body onload="window.print()"> 
    
    <div class="header">
        <h2>LAPORAN DAFTAR RUANGAN</h2>
        <p>Manajemen Inventaris Tempat</p>
    </div>

    <div class="tgl">Dicetak pada: {{ date('d-m-Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="center">No</th>
                <th width="20%">Nama Ruangan</th>
                <th width="15%">Bangunan</th>
                <th width="25%">Lokasi (Wilayah)</th>
                <th width="10%" class="center">Kapasitas</th>
                <th width="25%">Fasilitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venues as $index => $venue)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $venue->nama_venue }}</strong>
                </td>
                <td>{{ $venue->gedung }}</td>
                
                <td>
                    Kec. {{ $venue->kecamatan_id }}<br>
                    {{ $venue->kota_id }}<br>
                    <span class="text-muted">Prov. {{ $venue->provinsi_id }}</span>
                </td>

                <td class="center">{{ $venue->kapasitas }}</td>
                <td>{{ $venue->fasilitas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>