@extends('layouts.utama')

@section('judul', 'Statistik Nasional')

@section('konten')

{{-- Hero --}}
<section style="padding: 4rem 1rem 6rem; text-align: center; background: linear-gradient(135deg, var(--warna-indigo) 0%, var(--warna-cobalt) 50%, var(--warna-biru-langit) 100%); position: relative; overflow: hidden;">
    {{-- Decorative circles --}}
    <div style="position: absolute; top: -60px; right: -60px; width: 250px; height: 250px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
    <div style="position: absolute; bottom: -40px; left: -40px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
    <div class="max-w-3xl mx-auto" style="position: relative;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(59,130,246,0.15); color: #60A5FA; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; padding: 0.375rem 1rem; border-radius: 100px; margin-bottom: 1rem;">
            📊 Data Real-Time
        </div>
        <h1 style="font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: #60A5FA; letter-spacing: -0.02em; margin-bottom: 0.75rem;">
            Statistik Nasional
        </h1>
        <p style="font-size: 1.05rem; color: #BFDBFE; max-width: 500px; margin: 0 auto;">
            Data kerusakan jalan yang dilaporkan masyarakat secara real-time di seluruh Indonesia
        </p>
    </div>
</section>

<section style="padding: 0 1rem 4rem; background: var(--warna-latar);">
    <div style="max-width: 1152px; margin: 0 auto;">

        {{-- Kartu Statistik Utama - floating cards --}}
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: -3rem; margin-bottom: 3rem;">
            @php
                $statsCards = [
                    ['angka' => $stats['total'],    'label' => 'Total Laporan',    'icon' => '📋', 'warna' => 'var(--warna-indigo)', 'bg' => '#EEF2FF'],
                    ['angka' => $stats['selesai'],  'label' => 'Selesai',          'icon' => '✅', 'warna' => '#059669',             'bg' => '#ECFDF5'],
                    ['angka' => $stats['diproses'], 'label' => 'Sedang Diproses',  'icon' => '🔧', 'warna' => '#D97706',             'bg' => '#FFFBEB'],
                    ['angka' => $stats['tinggi'],   'label' => 'Prioritas Tinggi', 'icon' => '🚨', 'warna' => '#DC2626',             'bg' => '#FEF2F2'],
                ];
            @endphp
            @foreach($statsCards as $card)
                <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); border-bottom: 4px solid {{ $card['warna'] }}; display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: {{ $card['bg'] }}; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">
                        {{ $card['icon'] }}
                    </div>
                    <div>
                        <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: {{ $card['warna'] }}; line-height: 1;">
                            {{ number_format($card['angka']) }}
                        </div>
                        <div style="font-size: 0.8125rem; color: var(--warna-teks-muted); margin-top: 0.25rem;">
                            {{ $card['label'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Grid 2 kolom --}}
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">

            {{-- Distribusi Status --}}
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                <h2 style="font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; color: var(--warna-indigo); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    📊 Distribusi Status
                </h2>
                @php
                    $statusData = [
                        'dikirim'      => ['label' => 'Dikirim',      'warna' => '#6B7280'],
                        'diverifikasi' => ['label' => 'Diverifikasi', 'warna' => '#3B82F6'],
                        'diproses'     => ['label' => 'Diproses',     'warna' => '#F59E0B'],
                        'selesai'      => ['label' => 'Selesai',      'warna' => '#10B981'],
                        'ditolak'      => ['label' => 'Ditolak',      'warna' => '#EF4444'],
                    ];
                    $totalStatus = $byStatus->sum('jumlah');
                @endphp
                @if($byStatus->isEmpty())
                    <p style="text-align: center; color: var(--warna-teks-muted); padding: 2rem 0;">Belum ada data</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 0.875rem;">
                        @foreach($byStatus as $item)
                            @php
                                $info = $statusData[$item->status] ?? ['label' => $item->status, 'warna' => '#9CA3AF'];
                                $persen = $totalStatus > 0 ? round(($item->jumlah / $totalStatus) * 100) : 0;
                            @endphp
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.375rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="width: 10px; height: 10px; border-radius: 50%; background: {{ $info['warna'] }};"></div>
                                        <span style="font-size: 0.875rem; font-weight: 500; color: var(--warna-teks);">{{ $info['label'] }}</span>
                                    </div>
                                    <span style="font-size: 0.875rem; font-weight: 700; color: {{ $info['warna'] }};">
                                        {{ $item->jumlah }} <span style="font-weight: 400; color: var(--warna-teks-muted);">({{ $persen }}%)</span>
                                    </span>
                                </div>
                                <div style="height: 8px; border-radius: 100px; background: #F3F4F6; overflow: hidden;">
                                    <div style="height: 8px; border-radius: 100px; width: {{ $persen }}%; background: {{ $info['warna'] }};"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Prioritas AI --}}
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                <h2 style="font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; color: var(--warna-indigo); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    🤖 Distribusi Prioritas AI
                </h2>
                @php
                    $prioritasData = [
                        'tinggi' => ['label' => 'Prioritas Tinggi', 'warna' => '#EF4444', 'icon' => '🔴', 'bg' => '#FEF2F2'],
                        'sedang' => ['label' => 'Prioritas Sedang', 'warna' => '#F59E0B', 'icon' => '🟡', 'bg' => '#FFFBEB'],
                        'rendah' => ['label' => 'Prioritas Rendah', 'warna' => '#10B981', 'icon' => '🟢', 'bg' => '#ECFDF5'],
                    ];
                    $totalPrioritas = $byPrioritas->sum('jumlah');
                @endphp
                @if($byPrioritas->isEmpty())
                    <p style="text-align: center; color: var(--warna-teks-muted); padding: 2rem 0;">Belum ada data AI</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($byPrioritas as $item)
                            @php
                                $info = $prioritasData[$item->prioritas_ai] ?? ['label' => $item->prioritas_ai, 'warna' => '#9CA3AF', 'icon' => '⚪', 'bg' => '#F9FAFB'];
                                $persen = $totalPrioritas > 0 ? round(($item->jumlah / $totalPrioritas) * 100) : 0;
                            @endphp
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 12px; background: {{ $info['bg'] }};">
                                <div style="font-size: 1.5rem;">{{ $info['icon'] }}</div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.375rem;">
                                        <span style="font-weight: 600; font-size: 0.875rem; color: {{ $info['warna'] }};">{{ $info['label'] }}</span>
                                        <span style="font-weight: 700; font-size: 0.875rem; color: {{ $info['warna'] }};">{{ $item->jumlah }} ({{ $persen }}%)</span>
                                    </div>
                                    <div style="height: 6px; border-radius: 100px; background: rgba(0,0,0,0.08); overflow: hidden;">
                                        <div style="height: 6px; border-radius: 100px; width: {{ $persen }}%; background: {{ $info['warna'] }};"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Tabel Per Provinsi --}}
        <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <h2 style="font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; color: var(--warna-indigo); display: flex; align-items: center; gap: 0.5rem;">
                    🗺️ Laporan per Provinsi
                </h2>
                <form method="GET">
                    <select name="provinsi" class="ld-input" style="width: auto; font-size: 0.875rem;" onchange="this.form.submit()">
                        <option value="">Semua Provinsi</option>
                        @foreach($byProvinsi as $prov)
                            <option value="{{ $prov->provinsi }}" {{ request('provinsi') === $prov->provinsi ? 'selected' : '' }}>
                                {{ $prov->provinsi }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($byProvinsi->isEmpty())
                <p style="text-align: center; color: var(--warna-teks-muted); padding: 3rem 0;">Belum ada data provinsi</p>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #F3F4F6;">
                                <th style="text-align: left; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: var(--warna-teks-muted); text-transform: uppercase; letter-spacing: 0.05em;">#</th>
                                <th style="text-align: left; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: var(--warna-teks-muted); text-transform: uppercase; letter-spacing: 0.05em;">Provinsi</th>
                                <th style="text-align: center; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: var(--warna-teks-muted); text-transform: uppercase; letter-spacing: 0.05em;">Total</th>
                                <th style="text-align: center; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: #059669; text-transform: uppercase; letter-spacing: 0.05em;">Selesai</th>
                                <th style="text-align: center; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: #D97706; text-transform: uppercase; letter-spacing: 0.05em;">Diproses</th>
                                <th style="text-align: center; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: #DC2626; text-transform: uppercase; letter-spacing: 0.05em;">Prioritas Tinggi</th>
                                <th style="text-align: right; padding: 0.75rem 1rem; font-size: 0.75rem; font-weight: 700; color: var(--warna-teks-muted); text-transform: uppercase; letter-spacing: 0.05em;">% Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byProvinsi as $idx => $prov)
                                @php $persen = $prov->total > 0 ? round(($prov->selesai / $prov->total) * 100) : 0; @endphp
                                <tr style="border-bottom: 1px solid #F9FAFB; transition: background 0.15s;" onmouseover="this.style.background='#F8FAFF'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 0.875rem 1rem; font-size: 0.8125rem; color: var(--warna-teks-muted); font-weight: 600;">{{ $idx + 1 }}</td>
                                    <td style="padding: 0.875rem 1rem;">
                                        <span style="font-weight: 600; color: var(--warna-teks);">{{ $prov->provinsi }}</span>
                                    </td>
                                    <td style="padding: 0.875rem 1rem; text-align: center;">
                                        <span style="font-weight: 800; color: var(--warna-indigo); font-family: var(--font-display);">{{ $prov->total }}</span>
                                    </td>
                                    <td style="padding: 0.875rem 1rem; text-align: center;">
                                        <span style="font-weight: 600; color: #059669;">{{ $prov->selesai ?? 0 }}</span>
                                    </td>
                                    <td style="padding: 0.875rem 1rem; text-align: center;">
                                        <span style="font-weight: 600; color: #D97706;">{{ $prov->diproses ?? 0 }}</span>
                                    </td>
                                    <td style="padding: 0.875rem 1rem; text-align: center;">
                                        <span style="font-weight: 600; color: #DC2626;">{{ $prov->tinggi ?? 0 }}</span>
                                    </td>
                                    <td style="padding: 0.875rem 1rem; text-align: right;">
                                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.625rem;">
                                            <div style="width: 60px; height: 6px; border-radius: 100px; background: #F3F4F6; overflow: hidden;">
                                                <div style="height: 6px; border-radius: 100px; width: {{ $persen }}%; background: #10B981;"></div>
                                            </div>
                                            <span style="font-size: 0.8125rem; font-weight: 700; color: #10B981; min-width: 2.5rem; text-align: right;">{{ $persen }}%</span>
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
</section>
@endsection