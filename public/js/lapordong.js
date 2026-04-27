/**
 * lapordong.js — JavaScript Utama LaporDong
 * Mengelola: header scroll, navigasi, GSAP animasi, dropdown, upload foto, rating
 * Prinsip: Modular, ringan, tanpa efek zoom
 */

// ════════════════════════════════════════════════
// INISIALISASI GSAP
// ════════════════════════════════════════════════
if (typeof gsap !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
}

// ════════════════════════════════════════════════
// HEADER SCROLL BEHAVIOR
// ════════════════════════════════════════════════
function inisialisasiHeader() {
    const header = document.getElementById('headerUtama');
    if (!header) return;

    let posisiTerakhir = 0;

    window.addEventListener('scroll', () => {
        const posisiSekarang = window.scrollY;

        if (posisiSekarang > 20) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        posisiTerakhir = posisiSekarang;
    }, { passive: true });
}

// ════════════════════════════════════════════════
// DROPDOWN PROFIL
// ════════════════════════════════════════════════
function inisialisasiDropdownProfil() {
    const tombolProfil = document.getElementById('menuProfilToggle');
    const menuProfil = document.getElementById('menuProfil');

    if (!tombolProfil) return;

    tombolProfil.addEventListener('click', (e) => {
        e.stopPropagation();
        tombolProfil.classList.toggle('terbuka');
    });

    document.addEventListener('click', (e) => {
        if (!tombolProfil.contains(e.target)) {
            tombolProfil.classList.remove('terbuka');
        }
    });
}

// ════════════════════════════════════════════════
// HAMBURGER MOBILE
// ════════════════════════════════════════════════
function inisialisasiHamburger() {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    if (!hamburger || !mobileMenu) return;

    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('terbuka');
        const terbuka = mobileMenu.classList.contains('terbuka');
        hamburger.setAttribute('aria-expanded', terbuka);
    });
}

// ════════════════════════════════════════════════
// AUTO-DISMISS FLASH MESSAGE
// ════════════════════════════════════════════════
function inisialisasiFlash() {
    const flash = document.getElementById('flashMessage');
    if (!flash) return;

    setTimeout(() => {
        if (typeof gsap !== 'undefined') {
            gsap.to(flash, {
                opacity: 0,
                x: 24,
                duration: 0.4,
                ease: 'power2.in',
                onComplete: () => flash.remove()
            });
        } else {
            flash.remove();
        }
    }, 5000);
}

// ════════════════════════════════════════════════
// GSAP SCROLL ANIMATIONS (tanpa zoom)
// ════════════════════════════════════════════════
function inisialisasiAnimasiScroll() {
    if (typeof gsap === 'undefined') return;

    // Animasi masuk dari bawah untuk elemen konten
    const elemenAnimate = document.querySelectorAll('[data-animate]');
    elemenAnimate.forEach((el) => {
        const tipe = el.dataset.animate || 'fadeUp';
        const delay = parseFloat(el.dataset.delay || '0');

        let fromVars = { opacity: 0, duration: 0.7, delay };

        if (tipe === 'fadeUp')   fromVars.y = 30;
        if (tipe === 'fadeLeft') fromVars.x = -30;
        if (tipe === 'fadeRight') fromVars.x = 30;
        if (tipe === 'fadeIn')   { /* hanya opacity */ }

        gsap.from(el, {
            ...fromVars,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
                once: true,
            }
        });
    });

    // Animasi staggered untuk grid item
    const gridAnimate = document.querySelectorAll('[data-animate-grid]');
    gridAnimate.forEach((grid) => {
        const anak = grid.children;
        gsap.from(anak, {
            opacity: 0,
            y: 24,
            duration: 0.6,
            stagger: 0.1,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: grid,
                start: 'top 85%',
                once: true,
            }
        });
    });
}

// ════════════════════════════════════════════════
// ANIMASI HERO (satu kali saat load)
// ════════════════════════════════════════════════
function animasiHero() {
    if (typeof gsap === 'undefined') return;

    const labelHero  = document.querySelector('.ld-hero__label');
    const judulHero  = document.querySelector('.ld-hero__judul');
    const descHero   = document.querySelector('.ld-hero__desc');
    const aksiHero   = document.querySelector('.ld-hero__aksi');
    const gambarHero = document.querySelector('.ld-hero__gambar');

    const elemenAda = [labelHero, judulHero, descHero, aksiHero, gambarHero].filter(Boolean);
    if (elemenAda.length === 0) return;

    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    if (labelHero) tl.from(labelHero, { opacity: 0, y: 20, duration: 0.6 }, 0.2);
    if (judulHero) tl.from(judulHero, { opacity: 0, y: 28, duration: 0.7 }, 0.35);
    if (descHero)  tl.from(descHero, { opacity: 0, y: 20, duration: 0.6 }, 0.5);
    if (aksiHero)  tl.from(aksiHero, { opacity: 0, y: 16, duration: 0.5 }, 0.65);
    if (gambarHero) tl.from(gambarHero, { opacity: 0, x: 40, duration: 0.8 }, 0.4);
}

// ════════════════════════════════════════════════
// ANIMASI COUNTING ANGKA STATISTIK
// ════════════════════════════════════════════════
function animasiAngkaStatistik() {
    const elemenAngka = document.querySelectorAll('[data-count]');
    if (elemenAngka.length === 0) return;

    elemenAngka.forEach((el) => {
        const targetAngka = parseInt(el.dataset.count, 10);
        const satuan = el.dataset.satuan || '';

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    let hitungan = 0;
                    const langkah = targetAngka / 50;
                    const interval = setInterval(() => {
                        hitungan = Math.min(hitungan + langkah, targetAngka);
                        el.textContent = Math.round(hitungan).toLocaleString('id-ID') + satuan;
                        if (hitungan >= targetAngka) clearInterval(interval);
                    }, 30);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(el);
    });
}

// ════════════════════════════════════════════════
// UPLOAD FOTO — PREVIEW & DRAG DROP
// ════════════════════════════════════════════════
function inisialisasiUploadFoto() {
    const areaUpload = document.querySelectorAll('.ld-upload-area');

    areaUpload.forEach((area) => {
        const inputFile = area.querySelector('input[type="file"]');
        const previewContainer = area.querySelector('.ld-upload-preview');
        const teksUpload = area.querySelector('.ld-upload-teks');

        if (!inputFile) return;

        // Klik area → trigger input
        area.addEventListener('click', (e) => {
            if (e.target !== inputFile) inputFile.click();
        });

        // Drag & Drop
        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.classList.add('drag-over');
        });

        area.addEventListener('dragleave', () => area.classList.remove('drag-over'));

        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.classList.remove('drag-over');
            const dt = e.dataTransfer;
            if (dt.files.length) {
                inputFile.files = dt.files;
                tampilkanPreviewFoto(inputFile.files, previewContainer, teksUpload);
            }
        });

        inputFile.addEventListener('change', () => {
            tampilkanPreviewFoto(inputFile.files, previewContainer, teksUpload);
        });
    });
}

function tampilkanPreviewFoto(files, container, teks) {
    if (!container) return;

    container.innerHTML = '';

    if (teks && files.length > 0) {
        teks.style.display = 'none';
    }

    Array.from(files).forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'ld-upload-preview__item';
            wrapper.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${i + 1}">
                <span class="ld-upload-preview__label">Foto ${i + 1}</span>
            `;
            container.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

// ════════════════════════════════════════════════
// RATING INTERAKTIF
// ════════════════════════════════════════════════
function inisialisasiRating() {
    const grupRating = document.querySelectorAll('.ld-rating-input');

    grupRating.forEach((grup) => {
        const inputHidden = grup.querySelector('input[type="hidden"]');
        const bintang = grup.querySelectorAll('.ld-rating__bintang');

        bintang.forEach((b, i) => {
            b.addEventListener('mouseenter', () => perbaruiTampilanRating(bintang, i + 1));
            b.addEventListener('mouseleave', () => {
                const nilaiBintang = parseInt(inputHidden?.value || 0);
                perbaruiTampilanRating(bintang, nilaiBintang);
            });
            b.addEventListener('click', () => {
                if (inputHidden) inputHidden.value = i + 1;
                perbaruiTampilanRating(bintang, i + 1);
            });
        });
    });
}

function perbaruiTampilanRating(bintang, nilai) {
    bintang.forEach((b, i) => {
        if (i < nilai) {
            b.textContent = '★';
            b.classList.add('ld-rating__bintang--aktif');
            b.classList.remove('ld-rating__bintang--kosong');
        } else {
            b.textContent = '☆';
            b.classList.remove('ld-rating__bintang--aktif');
            b.classList.add('ld-rating__bintang--kosong');
        }
    });
}

// ════════════════════════════════════════════════
// GPS LOKASI OTOMATIS
// ════════════════════════════════════════════════
function inisialisasiGPS() {
    const tombolGPS = document.getElementById('tombolAmbilLokasi');
    const inputLat  = document.getElementById('latitude');
    const inputLng  = document.getElementById('longitude');
    const statusGPS = document.getElementById('statusGPS');

    if (!tombolGPS) return;

    tombolGPS.addEventListener('click', () => {
        if (!navigator.geolocation) {
            if (statusGPS) statusGPS.textContent = 'GPS tidak didukung browser ini.';
            return;
        }

        tombolGPS.disabled = true;
        tombolGPS.textContent = '📡 Mencari lokasi...';

        navigator.geolocation.getCurrentPosition(
            (posisi) => {
                const lat = posisi.coords.latitude.toFixed(8);
                const lng = posisi.coords.longitude.toFixed(8);

                if (inputLat) inputLat.value = lat;
                if (inputLng) inputLng.value = lng;

                if (statusGPS) statusGPS.textContent = `✅ Lokasi ditemukan: ${lat}, ${lng}`;

                tombolGPS.textContent = '📍 Lokasi Terdeteksi';
                tombolGPS.style.background = '#16A34A';
            },
            (error) => {
                const pesanError = {
                    1: 'Izin lokasi ditolak. Aktifkan GPS di browser.',
                    2: 'Lokasi tidak tersedia. Coba lagi.',
                    3: 'Waktu habis. Coba lagi.',
                }[error.code] || 'Gagal mendapatkan lokasi.';

                if (statusGPS) statusGPS.textContent = `❌ ${pesanError}`;
                tombolGPS.disabled = false;
                tombolGPS.textContent = '📍 Ambil Lokasi GPS';
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    });
}

// ════════════════════════════════════════════════
// TRACKING STEP PROGRESS BAR
// ════════════════════════════════════════════════
function inisialisasiTracking() {
    const stepTracker = document.querySelector('.ld-step-tracker');
    if (!stepTracker || typeof gsap === 'undefined') return;

    const langkah = stepTracker.querySelectorAll('.ld-step');

    gsap.from(langkah, {
        opacity: 0,
        y: 16,
        duration: 0.5,
        stagger: 0.12,
        ease: 'power3.out',
        delay: 0.3
    });
}

// ════════════════════════════════════════════════
// SCROLL HORIZONTAL GSAP (Cara Kerja section)
// ════════════════════════════════════════════════
function inisialisasiScrollHorizontal() {
    const rel = document.querySelector('.ld-scroll-rel');
    if (!rel || typeof gsap === 'undefined') return;

    const panelKumpulan = rel.querySelectorAll('.ld-panel');
    if (panelKumpulan.length === 0) return;

    gsap.to(panelKumpulan, {
        xPercent: -100 * (panelKumpulan.length - 1),
        ease: 'none',
        scrollTrigger: {
            trigger: rel,
            pin: true,
            scrub: 1,
            end: () => '+=' + rel.offsetWidth,
        }
    });
}

// ════════════════════════════════════════════════
// KONFIRMASI HAPUS/AKSI BERBAHAYA
// ════════════════════════════════════════════════
function inisialisasiKonfirmasi() {
    document.querySelectorAll('[data-konfirmasi]').forEach((el) => {
        el.addEventListener('click', (e) => {
            const pesan = el.dataset.konfirmasi || 'Apakah Anda yakin?';
            if (!confirm(pesan)) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
}

// ════════════════════════════════════════════════
// INIT — Jalankan Semua
// ════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    inisialisasiHeader();
    inisialisasiDropdownProfil();
    inisialisasiHamburger();
    inisialisasiFlash();
    inisialisasiAnimasiScroll();
    animasiHero();
    animasiAngkaStatistik();
    inisialisasiUploadFoto();
    inisialisasiRating();
    inisialisasiGPS();
    inisialisasiTracking();
    inisialisasiScrollHorizontal();
    inisialisasiKonfirmasi();
});

document.addEventListener("DOMContentLoaded", () => {

    // Dropdown profile
    const toggle = document.getElementById("menuProfilToggle");
    const dropdown = document.getElementById("menuProfil");

    if (toggle && dropdown) {
        toggle.addEventListener("click", () => {
            dropdown.classList.toggle("active");
        });
    }

    // Hamburger menu
    const hamburger = document.getElementById("hamburger");
    const mobileMenu = document.getElementById("mobileMenu");

    if (hamburger && mobileMenu) {
        hamburger.addEventListener("click", () => {
            mobileMenu.classList.toggle("active");
        });
    }

    // Flash close
    document.querySelectorAll("[data-flash]").forEach(flash => {
        const btn = flash.querySelector(".ld-flash__close");
        if (btn) {
            btn.addEventListener("click", () => {
                flash.remove();
            });
        }
    });

});

