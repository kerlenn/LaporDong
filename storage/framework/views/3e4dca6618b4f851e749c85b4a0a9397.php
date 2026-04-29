<?php $__env->startSection('judul', 'LaporDong - Detail Laporan ' . $laporan->kode_laporan); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/detail-laporan.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('konten'); ?>
<div class="ld-page-wrapper">
    <div class="ld-container ld-detail-container">

        
        <div class="ld-breadcrumb-wrap">
            <a href="<?php echo e(url()->previous()); ?>" class="ld-btn ld-btn--ghost ld-btn--back ld-btn-back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Kembali
            </a>
        </div>

        
        <div class="ld-header-wrap">
            <div>
                <h1 class="ld-header-title"><?php echo e($laporan->judul); ?></h1>
                <div class="ld-header-badges">
                    <span class="ld-badge ld-badge-code"><?php echo e($laporan->kode_laporan); ?></span>
                    <span class="ld-badge ld-badge--<?php echo e($laporan->status); ?>"><?php echo e($laporan->label_status); ?></span>
                    
                    <?php if($laporan->prioritas_ai): ?>
                        <span class="ld-badge ld-badge--prioritas-<?php echo e($laporan->prioritas_ai); ?> <?php echo e(match(strtolower($laporan->prioritas_ai)) {
                                'tinggi' => 'ld-priority--high',
                                'sedang' => 'ld-priority--medium',
                                'rendah' => 'ld-priority--low',
                                default  => '',
                            }); ?>">
                            <?php echo e($laporan->label_prioritas); ?>

                        </span>
                    <?php endif; ?>
                    <span class="ld-header-time"><?php echo e($laporan->created_at->diffForHumans()); ?></span>
                </div>
            </div>
        </div>

        
        <div class="ld-step-tracker ld-tracker-wrap">
            <?php
                $steps = ['dikirim', 'diverifikasi', 'diproses', 'selesai'];
                $currentIdx = array_search($laporan->status, $steps);
            ?>
            
            <?php $__currentLoopData = ['Dikirim', 'Diverifikasi', 'Diproses', 'Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $code = $steps[$i];
                    $isPast = $currentIdx !== false && $i < $currentIdx; 
                    $isActive = $i === $currentIdx; 
                ?>
                <div class="ld-step <?php echo e($isPast ? 'ld-step--lewat' : ''); ?> <?php echo e($isActive ? 'ld-step--sekarang' : ''); ?>">
                    <div class="ld-step__nomor ld-step-num-inner <?php echo e(($isPast || $isActive) ? 'ld-step-num-active' : ''); ?>">
                        <?php if($isPast || $isActive): ?>
                            <?php switch($code):
                                case ('dikirim'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 16 16"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/></svg>
                                    <?php break; ?>
                                <?php case ('diverifikasi'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/></svg>
                                    <?php break; ?>
                                <?php case ('diproses'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 16 16"><path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/></svg>
                                    <?php break; ?>
                                <?php case ('selesai'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 16 16"><path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/></svg>
                                    <?php break; ?>
                            <?php endswitch; ?>
                        <?php else: ?> 
                            <?php echo e($i + 1); ?> 
                        <?php endif; ?>
                    </div>
                    <div class="ld-step__label"><?php echo e($label); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($laporan->tenggat_sla && $laporan->status !== 'ditolak'): ?>
            <?php
                $slaStatus = $laporan->status_sla;
                $daysLeft = $laporan->sisa_hari_sla;
                $slaLabel = match($slaStatus) {
                    'selesai' => 'Diselesaikan Tepat Waktu',
                    'overdue' => 'Sudah lewat Deadline',
                    'warning' => 'Mendekati Waktu Dealine',
                    'ontime'  => 'Dalam Tenggat Waktu',
                    default   => 'Deadline Belum Ditetapkan',
                };
            ?>
            <div class="ld-card ld-border-gradient ld-card-detail-1">
                <div class="ld-card__body" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div class="ld-sla-left">
                        <div class="ld-ai-icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="ld-sla-label" style="color: var(--ld-indigo);"><?php echo e($slaLabel); ?></div>
                            <div class="ld-sla-target" style="color: var(--ld-indigo); opacity: 0.8;">
                                Target: <?php echo e($laporan->tenggat_sla->format('d M Y')); ?>

                                <?php if($laporan->estimasi_hari): ?> · Estimasi AI: <?php echo e($laporan->estimasi_hari); ?> hari <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ld-sla-right">
                        <?php if($slaStatus === 'selesai'): ?>
                            <div class="ld-sla-status" style="color: var(--ld-indigo);">
                                <?php echo e($laporan->tepat_waktu ? '✓ Tepat Waktu' : 'Terlambat'); ?>

                            </div>
                        <?php elseif($slaStatus === 'overdue'): ?>
                            <div class="ld-sla-status" style="color: var(--ld-indigo);"><?php echo e(abs($daysLeft)); ?> hari terlewat</div>
                        <?php else: ?>
                            <div class="ld-sla-status" style="color: var(--ld-indigo);"><?php echo e($daysLeft); ?> hari lagi</div>
                        <?php endif; ?>
                        <div class="ld-sla-subtext" style="color: var(--ld-indigo); opacity: 0.8;">dari tenggat waktu</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="ld-main-grid">
            <div class="ld-col-flex">
                
                <?php if($laporan->prioritas_ai): ?>
                <div class="ld-card ld-border-gradient ld-card-detail">
                    <div class="ld-card__body">
                        <div class="ld-ai-header">
                            <div class="ld-ai-icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 16 16"><path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/></svg>
                            </div>
                            <div>
                                <div class="ld-ai-title">Analisis AI Gemini</div>
                                <div class="ld-ai-subtitle">Penilaian otomatis berdasarkan foto</div>
                            </div>
                        </div>
                        <div class="ld-ai-grid">
                            <div class="ld-card ld-ai-card">
                                <div class="ld-ai-val-prioritas"><?php echo e($laporan->label_prioritas); ?></div>
                                <div class="ld-ai-label">Prioritas</div>
                            </div>
                            <div class="ld-card ld-ai-card">
                                <div class="ld-ai-val-skor"><?php echo e($laporan->skor_keparahan_ai ?? '-'); ?></div>
                                <div class="ld-ai-label">Skor Keparahan</div>
                            </div>
                            <div class="ld-card ld-ai-card">
                                <div class="ld-ai-val-estimasi"><?php echo e($laporan->estimasi_hari ?? '-'); ?></div>
                                <div class="ld-ai-label">Estimasi Hari</div>
                            </div>
                            <div class="ld-card ld-ai-card">
                                <div class="ld-ai-val-catatan"><?php echo e(Str::limit($laporan->catatan_ai ?? 'N/A', 40)); ?></div>
                                <div class="ld-ai-label ld-ai-label-mt">Catatan AI</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 class="ld-section-title">Deskripsi Kerusakan</h2>
                    </div>
                    <div class="ld-card__body">
                        <p class="ld-section-desc"><?php echo e($laporan->deskripsi); ?></p>
                    </div>
                </div>

                
                <?php if($laporan->foto_sebelum && count($laporan->foto_sebelum) > 0): ?>
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 class="ld-section-title">Foto Kerusakan (Sebelum)</h2>
                        <span class="ld-photo-time"><?php echo e($laporan->created_at->format('d M Y, H:i')); ?> WIB</span>
                    </div>
                    <div class="ld-card__body">
                        <div class="ld-photo-grid">
                            <?php $__currentLoopData = $laporan->foto_sebelum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ld-photo-wrap">
                                <img src="<?php echo e(asset('storage/' . $foto)); ?>" alt="Foto sebelum" class="ld-photo-img ld-photo-img--sebelum" onclick="bukaGambarBesar(this.src)">
                                <div class="ld-photo-date ld-photo-date--sebelum"><?php echo e($laporan->created_at->format('d/m/Y')); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($laporan->foto_sesudah && count($laporan->foto_sesudah) > 0): ?>
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 class="ld-section-title">Foto Bukti Perbaikan (Sesudah)</h2>
                        <?php if($laporan->tanggal_selesai): ?>
                            <span class="ld-photo-time-sesudah"><?php echo e($laporan->tanggal_selesai->format('d M Y, H:i')); ?> WIB</span>
                        <?php endif; ?>
                    </div>
                    <div class="ld-card__body">
                        <div class="ld-photo-grid">
                            <?php $__currentLoopData = $laporan->foto_sesudah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ld-photo-wrap">
                                <img src="<?php echo e(asset('storage/' . $foto)); ?>" alt="Foto sesudah" class="ld-photo-img ld-photo-img--sesudah">
                                <div class="ld-photo-date ld-photo-date--sesudah"><?php echo e($laporan->tanggal_selesai?->format('d/m/Y') ?? ''); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php if($laporan->catatan_petugas): ?>
                        <div class="ld-note-wrap">
                            <div class="ld-note-title">Catatan Petugas:</div>
                            <p class="ld-note-text"><?php echo e($laporan->catatan_petugas); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($laporan->ulasan): ?>
                <div class="ld-card">
                    <div class="ld-card__header"><h2 class="ld-section-title">Ulasan & Komentar</h2></div>
                    <div class="ld-card__body">
                        <div class="ld-review-header">
                            <?php for($b = 1; $b <= 5; $b++): ?>
                                <span class="ld-review-star" style="color: <?php echo e($b <= $laporan->ulasan->bintang ? '#F59E0B' : '#E2E8F0'); ?>;">★</span>
                            <?php endfor; ?>
                            <span class="ld-review-score"><?php echo e($laporan->ulasan->bintang); ?>/5</span>
                            <span class="ld-review-author">— <?php echo e($laporan->ulasan->nama_penulis); ?></span>
                        </div>
                        <?php if($laporan->ulasan->komentar): ?>
                        <p class="ld-review-comment">"<?php echo e($laporan->ulasan->komentar); ?>"</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="ld-col-flex">
                
                <div class="ld-card">
                    <div class="ld-card__header"><h2 class="ld-section-title">Lokasi</h2></div>
                    <div class="ld-card__body ld-loc-body">
                        <div class="ld-loc-grid">
                            <div><strong>Alamat:</strong><br><?php echo e($laporan->alamat_lengkap); ?></div>
                            <div><strong>Kelurahan:</strong> <?php echo e($laporan->kelurahan); ?></div>
                            <div><strong>Kecamatan:</strong> <?php echo e($laporan->kecamatan); ?></div>
                            <div><strong>Kota:</strong> <?php echo e($laporan->kota); ?></div>
                            <div><strong>Provinsi:</strong> <?php echo e($laporan->provinsi); ?></div>
                            <div class="ld-loc-coords"><?php echo e($laporan->latitude); ?>, <?php echo e($laporan->longitude); ?></div>
                        </div>
                    </div>
                </div>

                
                <div class="ld-card">
                    <div class="ld-card__header"><h2 class="ld-section-title">Riwayat Status</h2></div>
                    <div class="ld-card__body">
                        <div class="ld-timeline">
                            <?php $__currentLoopData = $laporan->riwayatStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $riwayat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ld-timeline__item <?php echo e($i === $laporan->riwayatStatus->count() - 1 ? 'ld-timeline__item--aktif' : ''); ?>">
                                <div class="ld-timeline__dot ld-timeline-dot-custom">
                                    <?php switch($riwayat->status_baru):
                                        case ('selesai'): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffffff" viewBox="0 0 16 16"><path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/></svg> <?php break; ?>
                                        <?php case ('diproses'): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffffff" viewBox="0 0 16 16"><path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/></svg> <?php break; ?>
                                        <?php case ('diverifikasi'): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffffff" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/></svg> <?php break; ?>
                                        <?php case ('ditolak'): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffffff" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg> <?php break; ?>
                                        <?php default: ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ffffff" viewBox="0 0 16 16"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/></svg>
                                    <?php endswitch; ?>
                                </div>
                                <div class="ld-timeline__konten">
                                    <div class="ld-timeline__label"><?php echo e(ucfirst($riwayat->status_baru)); ?></div>
                                    <div class="ld-timeline__waktu"><?php echo e($riwayat->created_at->format('d M Y, H:i')); ?> <?php if($riwayat->pengubah): ?> · <?php echo e($riwayat->pengubah->nama_lengkap); ?> <?php endif; ?></div>
                                    <?php if($riwayat->catatan): ?><div class="ld-timeline__catatan"><?php echo e($riwayat->catatan); ?></div><?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="lightboxGambar" class="ld-lightbox-overlay" onclick="tutupGambarBesar()">
    <img id="lightboxGambarImg" src="" alt="" class="ld-lightbox-img">
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/laporan/detail.blade.php ENDPATH**/ ?>