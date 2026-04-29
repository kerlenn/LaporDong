@extends('layouts.utama')
@section('judul', 'LaporDong - Statistik Nasional')

@section('konten')

<div class="ld-page-wrapper">
    <div class="ld-container ld-container-wide">

        {{-- Hero Banner --}}
        <div class="ld-hero-wrapper">
            <h1 class="ld-hero__judul">
                <span class="aksen">Statistik Laporan</span>
            </h1>
            <p class="ld-hero__desc ld-hero__desc-custom">
                Pantau seluruh laporan yang telah masuk, status penanganannya, serta distribusi prioritas AI berdasarkan penilaian otomatis.
            </p>
        </div>

        {{-- Kartu Statistik Utama - floating cards --}}
        <div class="ld-stats-grid">
            @php
                
                $statsCards = [
                    ['id' => 'total',          'angka' => $stats['total'] ?? 0,          'label' => 'Total Laporan',  'warna' => 'var(--ld-indigo)', 'bg' => 'var(--ld-grad-light);'],
                    ['id' => 'selesai',        'angka' => $stats['selesai'] ?? 0,        'label' => 'Selesai',        'warna' => 'var(--ld-indigo)', 'bg' => 'var(--ld-grad-light);'],
                    ['id' => 'diproses',       'angka' => $stats['diproses'] ?? 0,       'label' => 'Sedang Diproses','warna' => 'var(--ld-indigo)', 'bg' => 'var(--ld-grad-light);'],
                    ['id' => 'lewat_deadline', 'angka' => $stats['lewat_deadline'] ?? 0, 'label' => 'Lewat Deadline', 'warna' => 'var(--ld-indigo)', 'bg' => 'var(--ld-grad-light);'],
                ];
            @endphp
            
            @foreach($statsCards as $card)
                <div class="ld-card ld-stat-card">
             
                    <div class="ld-stat-icon" style="background: {{ $card['bg'] }};">
                        @switch($card['id'])
                            @case('total')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#234A89" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                    <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                                </svg>
                                @break
                            @case('selesai')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#234A89" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>
                                @break
                            @case('diproses')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#234A89" class="bi bi-wrench" viewBox="0 0 16 16">
                                    <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                                </svg>
                                @break
                            @case('lewat_deadline')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#234A89" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                @break
                        @endswitch
                    </div>
                    <div>
                        <div class="ld-stat-number" style="color: {{ $card['warna'] }};">
                            {{ number_format($card['angka']) }}
                        </div>
                        <div class="ld-stat-label">
                            {{ $card['label'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Grid 2 kolom --}}
        <div class="ld-content-grid">

            {{-- Distribusi Status --}}
            <div class="ld-card">
                <div class="ld-card__header">
                    <h2 class="ld-section-title">Distribusi Status</h2>
                </div>
                <div class="ld-card__body">
                    @php
                        $statusData = [
                            'dikirim'      => ['label' => 'Dikirim',      'warna' => '#B6E6F5'],
                            'diverifikasi' => ['label' => 'Diverifikasi', 'warna' => '#3B82F6'],
                            'diproses'     => ['label' => 'Diproses',     'warna' => '#4FB0F5'],
                            'selesai'      => ['label' => 'Selesai',      'warna' => '#3575AF'],
                            'ditolak'      => ['label' => 'Ditolak',      'warna' => '#234A89'],
                        ];
                        $totalStatus = $byStatus->sum('jumlah');
                    @endphp
                    @if($byStatus->isEmpty())
                        <p class="ld-empty-state">Belum ada data</p>
                    @else
                        <div class="ld-status-list">
                            @foreach($byStatus as $item)
                                @php
                                    $info = $statusData[$item->status] ?? ['label' => $item->status, 'warna' => '#9CA3AF'];
                                    $persen = $totalStatus > 0 ? round(($item->jumlah / $totalStatus) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="ld-status-item-header">
                                        <div class="ld-status-item-label">
                                            <div class="ld-status-dot" style="background: {{ $info['warna'] }};"></div>
                                            <span class="ld-status-name">{{ $info['label'] }}</span>
                                        </div>
                                        <span class="ld-status-count">
                                            {{ $item->jumlah }} <span class="ld-status-percent">({{ $persen }}%)</span>
                                        </span>
                                    </div>
                                    <div class="ld-progress-bar">
                                        <div class="ld-progress-fill" style="width: {{ $persen }}%; background: {{ $info['warna'] }};"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Prioritas AI --}}
            <div class="ld-card ld-border-gradient ld-card-detail">
                <div class="ld-card__body">
                    <div class="ld-ai-header">
                        <div class="ld-ai-icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 16 16"><path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/></svg>
                        </div>
                        <div>
                            <div class="ld-ai-title">Distribusi Prioritas AI</div>
                            <div class="ld-ai-subtitle">Penilaian otomatis berdasarkan foto</div>
                        </div>
                    </div>

                    @php
                        // Menyeragamkan semua class menjadi 'ld-ai-val-skor' agar ukuran angkanya sama besar
                        $prioritasData = [
                            'tinggi' => ['label' => 'Prioritas Tinggi', 'warna' => '#234A89', 'class' => 'ld-ai-val-skor'],
                            'sedang' => ['label' => 'Prioritas Sedang', 'warna' => '#3575AF', 'class' => 'ld-ai-val-skor'],
                            'rendah' => ['label' => 'Prioritas Rendah', 'warna' => '#4FB0F5', 'class' => 'ld-ai-val-skor'],
                        ];
                        $totalPrioritas = $byPrioritas->sum('jumlah');
                    @endphp
                    @if($byPrioritas->isEmpty())
                        <p class="ld-empty-state">Belum ada data AI</p>
                    @else
                        <div class="ld-ai-grid">
                            @foreach($byPrioritas as $item)
                                @php
                                    $aiKey = $item->prioritas_ai ? strtolower($item->prioritas_ai) : '';
                                    $info = $prioritasData[$aiKey] ?? ['label' => $item->prioritas_ai ?: 'Tidak ada', 'warna' => 'var(--ld-indigo)', 'class' => 'ld-ai-val-skor'];
                                    $persen = $totalPrioritas > 0 ? round(($item->jumlah / $totalPrioritas) * 100) : 0;
                                @endphp
                                <div class="ld-card ld-ai-card">
                                    <div class="{{ $info['class'] }}" style="color: {{ $info['warna'] }};">{{ number_format($item->jumlah) }}</div>
                                    <div class="ld-ai-label">{{ $info['label'] }} ({{ $persen }}%)</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tabel Per Provinsi (Sistem Ranking) --}}
        <div class="ld-card">
            <div class="ld-card__header ld-card__header-flex">
                <h2 class="ld-section-title">Ranking Penyelesaian Laporan per Provinsi</h2>
                <form method="GET">
                    <select name="provinsi" class="ld-input ld-input-select" onchange="this.form.submit()">
                        <option value="">Semua Provinsi</option>
                        @foreach($byProvinsi as $prov)
                            <option value="{{ $prov->provinsi }}" {{ request('provinsi') === $prov->provinsi ? 'selected' : '' }}>
                                {{ $prov->provinsi }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            @php
                // LOGIKA RANKING PENALTI:
                // Selesai dikurangi lewat_deadline. Hasilnya dijadikan persentase.
                $rankedProvinsi = collect($byProvinsi)->map(function($prov) {
                    $total = $prov->total ?? 0;
                    $selesai = $prov->selesai ?? 0;
                    $lewat_deadline = $prov->lewat_deadline ?? 0;
                    
                    // Hitung skor kinerja: selesai dikurangi pelanggaran deadline
                    $skor_efektif = $selesai - $lewat_deadline;
                    
                    // Hitung persen (gunakan max(0, ...) agar jika penaltinya terlalu besar tidak bernilai negatif)
                    $prov->persentase_selesai = $total > 0 ? max(0, round(($skor_efektif / $total) * 100)) : 0;
                    
                    return $prov;
                })->sortByDesc('persentase_selesai')->values(); 
            @endphp

            <div class="ld-card__body ld-card__body-nopad">
                @if($rankedProvinsi->isEmpty())
                    <p class="ld-empty-state-lg">Belum ada data provinsi</p>
                @else
                    <div class="ld-table-responsive">
                        <table class="ld-table">
                            <thead>
                                <tr class="ld-table-head-row">
                                    <th class="ld-th ld-th-left ld-text-muted">Rank</th>
                                    <th class="ld-th ld-th-left ld-text-muted">Provinsi</th>
                                    <th class="ld-th ld-th-center ld-text-muted">Total</th>
                                    <th class="ld-th ld-th-center ld-text-azure">Selesai</th>
                                    <th class="ld-th ld-th-center ld-text-cobalt">Diproses</th>
                                    <th class="ld-th ld-th-center ld-text-indigo">Lewat Deadline</th>
                                    
                                    <th class="ld-th ld-th-right ld-text-muted">% Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rankedProvinsi as $idx => $prov)
                                    <tr class="ld-table-row">
                                        <td class="ld-td ld-td-index">#{{ $idx + 1 }}</td>
                                        
                                        <td class="ld-td">
                                            <span class="ld-td-provinsi-text">{{ $prov->provinsi }}</span>
                                        </td>
                                        <td class="ld-td ld-td-center">
                                            <span class="ld-td-total-val">{{ $prov->total }}</span>
                                        </td>
                                        
                                        <td class="ld-td ld-td-center">
                                            <span class="ld-td-selesai-val">{{ $prov->selesai ?? 0 }}</span>
                                        </td>
                                        
                                        <td class="ld-td ld-td-center">
                                            <span class="ld-td-diproses-val">{{ $prov->diproses ?? 0 }}</span>
                                        </td>
                                        
                                        <td class="ld-td ld-td-center">
                                            <span class="ld-td-tinggi-val">{{ $prov->lewat_deadline ?? 0 }}</span>
                                        </td>
                                        
                                        <td class="ld-td ld-td-right">
                                            <div class="ld-td-progress-wrap">
                                                <div class="ld-td-progress">
                                                    <div class="ld-td-progress-fill" style="width: {{ $prov->persentase_selesai }}%;"></div>
                                                </div>
                                                <span class="ld-td-progress-text">{{ $prov->persentase_selesai }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection