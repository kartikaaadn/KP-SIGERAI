{{-- resources/views/gerai/laporan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Layanan Gerai</title>

    <style>
        :root{
            --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
            --headerGrad: linear-gradient(90deg, #F44545 0%, #7C1012 100%);
            --card: rgba(255,255,255,.92);
            --stroke: rgba(0,0,0,.12);
        }

        html, body{
            margin:0;
            padding:0;
            width:100%;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
            color:#111;
        }

        body{
            background:
                radial-gradient(circle at 30% 10%, rgba(255,255,255,.35), rgba(255,255,255,0) 55%),
                url('{{ asset('assets/gedung.jpg') }}') center/cover no-repeat fixed;
        }

        .page{
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        /* 🔥 sidebar nempel kiri full */
        .main-row{
            display:flex;
            gap:18px;
            padding:18px 18px 0 0;
            box-sizing:border-box;
        }

        /* 🔥 kecilkan teks konten saja */
        .content{
            flex:1;
            min-width:0;
            font-size:13.5px;
        }

        .hero{
            background: var(--card);
            border:1px solid var(--stroke);
            border-radius:14px;
            padding:16px 18px;
            box-shadow: 0 16px 28px rgba(0,0,0,.08);
            margin-bottom:14px;
        }

        .hero h1{
            margin:0;
            font-size:30px;
            font-weight:900;
        }

        .hero h1 .grad{
            background: var(--footerGrad);
            -webkit-background-clip:text;
            color:transparent;
        }

        .hero p{
            margin-top:4px;
            font-size:13px;
            opacity:.8;
        }

        .stats{
            display:flex;
            justify-content:center;
            gap:14px;
            margin-bottom:14px;
        }

        .stat{
            width:170px;
            background: var(--card);
            border:1px solid var(--stroke);
            border-radius:12px;
            padding:12px;
            display:flex;
            gap:10px;
        }

        .stat .num{ font-size:22px; font-weight:900; }
        .stat .lbl{ font-size:11px; opacity:.75; }

        .bar{
            background: var(--card);
            border:1px solid var(--stroke);
            border-radius:14px;
            padding:12px 14px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:14px;
        }

        .bar-left{ display:flex; gap:10px; align-items:center; }
        .bar-left .label{ font-size:18px; font-weight:900; }

        .rangeText{
            font-size:13px;
            font-weight:800;
            opacity:.75;
            margin-left:6px;
        }

        .btn{
            height:36px;
            padding:0 14px;
            border-radius:10px;
            border:1px solid rgba(0,0,0,.15);
            font-weight:800;
            cursor:pointer;
            background:#fff;
        }

        .btn-primary{
            background:#E53935;
            border:none;
            color:#fff;
        }

        .btn-blue{
            background:#3B82F6;
            border:none;
            color:#fff;
        }

        .card{
            background: var(--card);
            border:1px solid var(--stroke);
            border-radius:14px;
            padding:14px;
        }

        .card h2{ font-size:18px; }

        table{
            width:100%;
            border-collapse:collapse;
        }

        thead th{
            background: rgba(59,130,246,.18);
            border:1px solid rgba(0,0,0,.12);
            font-size:13px;
            padding:10px;
        }

        tbody td{
            border:1px solid rgba(0,0,0,.12);
            padding:10px;
            font-size:13px;
        }

        td.c, th.c{ text-align:center; }
        td.l, th.l{ text-align:left; }

        .totalBar{
            margin-top:12px;
            background:#4EA0FF;
            color:#fff;
            font-size:14px;
            font-weight:900;
            padding:12px;
            border-radius:12px;
            text-align:center;
        }

        .note{
            margin-top:14px;
            background: var(--card);
            border:1px solid var(--stroke);
            border-radius:14px;
            padding:14px;
        }

        .note h3{ font-size:15px; }
        .note ol{ font-size:13px; }
    </style>
</head>

<body>
<div class="page">

    @include('partials.header')

    <div class="main-row">
        @include('partials.sidebar-gerai')

        <div class="content">

            <div class="hero">
                <h1><span class="grad">Laporan</span> Layanan Gerai</h1>
                <p>Kelola seluruh layanan gerai Anda</p>
            </div>

            <div class="stats">
                <div class="stat">
                    <div>👥</div>
                    <div>
                        <div class="num">{{ $weeklyTotal }}</div>
                        <div class="lbl">Total Pengguna</div>
                    </div>
                </div>
                <div class="stat">
                    <div>⬆️</div>
                    <div>
                        <div class="num">{{ $max }}</div>
                        <div class="lbl">Tertinggi</div>
                    </div>
                </div>
                <div class="stat">
                    <div>↔️</div>
                    <div>
                        <div class="num">{{ $median }}</div>
                        <div class="lbl">Menengah</div>
                    </div>
                </div>
                <div class="stat">
                    <div>⬇️</div>
                    <div>
                        <div class="num">{{ $min }}</div>
                        <div class="lbl">Terendah</div>
                    </div>
                </div>
            </div>

            <div class="bar">
                <form class="bar-left" method="GET">
                    <div class="label">Periode</div>
                    <input type="date" name="start" value="{{ request('start') }}">
                    <button class="btn btn-primary">Pilih</button>
                    <div class="rangeText">{{ $rangeText }}</div>
                </form>

                <div>
                    <a class="btn" href="{{ route('gerai.laporan.export', request()->query()) }}">⬇ Ekspor</a>
                    <a class="btn btn-blue" href="{{ route('gerai.laporan.create', request()->query()) }}">＋ Input Data Baru</a>
                </div>
            </div>

            <div class="card">
                <h2>Data Layanan Per-Periode</h2>

                <table>
                    <thead>
                        <tr>
                            <th class="c">No</th>
                            <th class="c">Hari</th>
                            <th class="c">Tanggal</th>
                            <th class="l">Jenis Layanan</th>
                            <th class="c">Jumlah Pengguna</th>
                            <th class="c">Keterangan</th>
                            <th class="c">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="c" colspan="7">Belum ada data.</td>
                        </tr>
                    </tbody>
                </table>

                <div class="totalBar">
                    Total Jumlah Pengguna Layanan Mingguan: {{ $weeklyTotal }}
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')

</div>
</body>
</html>
