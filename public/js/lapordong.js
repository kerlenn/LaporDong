/**
 * lapordong.js — JavaScript Utama LaporDong
 * Mengelola: header scroll, navigasi, GSAP animasi, dropdown, upload foto, rating, peta
 * Prinsip: Modular, ringan, tanpa efek zoom, aman dari null error
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
// NAVIGASI (Dropdown Profil + Hamburger Mobile)
// ════════════════════════════════════════════════
function inisialisasiNavigasi() {
    const toggle = document.getElementById('menuProfilToggle');
    const dropdown = document.getElementById('menuProfil');

    if (toggle && dropdown) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggle.classList.toggle('terbuka');
            dropdown.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                toggle.classList.remove('terbuka');
                dropdown.classList.remove('active');
            }
        });
    }

    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            hamburger.setAttribute('aria-expanded', mobileMenu.classList.contains('active'));
        });
    }
}

// ════════════════════════════════════════════════
// FLASH MESSAGE (auto-dismiss + tombol tutup)
// ════════════════════════════════════════════════
function inisialisasiFlash() {
    const flash = document.getElementById('flashMessage');

    if (flash) {
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

    document.querySelectorAll('[data-flash]').forEach(el => {
        el.querySelector('.ld-flash__close')?.addEventListener('click', () => el.remove());
    });
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

        if (tipe === 'fadeUp')    fromVars.y = 30;
        if (tipe === 'fadeLeft')  fromVars.x = -30;
        if (tipe === 'fadeRight') fromVars.x = 30;
        if (tipe === 'fadeIn')    { /* hanya opacity */ }

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

    if (labelHero)  tl.from(labelHero,  { opacity: 0, y: 20, duration: 0.6 }, 0.2);
    if (judulHero)  tl.from(judulHero,  { opacity: 0, y: 28, duration: 0.7 }, 0.35);
    if (descHero)   tl.from(descHero,   { opacity: 0, y: 20, duration: 0.6 }, 0.5);
    if (aksiHero)   tl.from(aksiHero,   { opacity: 0, y: 16, duration: 0.5 }, 0.65);
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
// RATING INTERAKTIF (input form)
// ════════════════════════════════════════════════
function inisialisasiRatingInput() {
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
// RATING LAPORAN (kirim ke backend via fetch)
// ════════════════════════════════════════════════
function inisialisasiRating() {
    document.querySelectorAll('.ld-rating').forEach(el => {
        const stars = el.querySelectorAll('.ld-star');
        const id = el.dataset.id;

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const val = star.dataset.value;

                // UI update dulu (instant feedback)
                stars.forEach(s => {
                    s.classList.toggle('is-active', s.dataset.value <= val);
                });

                const valueEl = el.querySelector('.ld-rating__value');
                if (valueEl) valueEl.innerText = val + '/5';

                // Kirim ke backend
                fetch(`/laporan/${id}/rating`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ bintang: val })
                });
            });
        });
    });

    // Rating bintang untuk input form (stars input)
    document.querySelectorAll('.ld-stars-input').forEach(container => {
        const stars = container.querySelectorAll('.ld-star-input');
        const input = container.querySelector('input');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const val = star.dataset.value;
                if (input) input.value = val;

                stars.forEach(s => {
                    s.classList.toggle('active', s.dataset.value <= val);
                });
            });
        });
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
        tombolGPS.textContent = 'Mencari lokasi...';

        navigator.geolocation.getCurrentPosition(
            (posisi) => {
                const lat = posisi.coords.latitude.toFixed(8);
                const lng = posisi.coords.longitude.toFixed(8);

                if (inputLat) inputLat.value = lat;
                if (inputLng) inputLng.value = lng;

                if (statusGPS) statusGPS.textContent = `Lokasi ditemukan: ${lat}, ${lng}`;

                tombolGPS.textContent = 'Lokasi Terdeteksi';
            },
            (error) => {
                const pesanError = {
                    1: 'Izin lokasi ditolak. Aktifkan GPS di browser.',
                    2: 'Lokasi tidak tersedia. Coba lagi.',
                    3: 'Waktu habis. Coba lagi.',
                }[error.code] || 'Gagal mendapatkan lokasi.';

                if (statusGPS) statusGPS.textContent = `❌ ${pesanError}`;
                tombolGPS.disabled = false;
                tombolGPS.textContent = 'Ambil Lokasi GPS';
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
// PETA LEAFLET + NOMINATIM + GPS + PENCARIAN
// ════════════════════════════════════════════════
function inisialisasiPeta() {
    const mapEl = document.getElementById('mapLocation');
    if (!mapEl || typeof L === 'undefined') return;

    // 1. Inisialisasi Peta (Default koordinat diarahkan ke Jakarta/Indonesia)
    var map = L.map('mapLocation').setView([-6.2088, 106.8456], 13);

    // Gunakan peta standar OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // 2. Tambahkan Pin (Marker) yang bisa di-drag
    var marker = L.marker([-6.2088, 106.8456], { draggable: true }).addTo(map);

    // Definisi Elemen Form
    var latInput      = document.getElementById('latitude');
    var lngInput      = document.getElementById('longitude');
    var alamatInput   = document.getElementById('alamat_lengkap');
    var kelurahanInput = document.getElementById('kelurahan');
    var kecamatanInput = document.getElementById('kecamatan');
    var kotaInput     = document.getElementById('kota');
    var provinsiInput = document.getElementById('provinsi');
    var kodePosInput  = document.getElementById('kode_pos');
    var statusGps     = document.getElementById('statusGPS');

    // 3. Fungsi untuk Update Form otomatis via API Nominatim
    function updateFormFields(lat, lng) {
        if (latInput) latInput.value = lat.toFixed(6);
        if (lngInput) lngInput.value = lng.toFixed(6);

        if (statusGps) {
            statusGps.innerText = 'Mengambil data alamat...';
            statusGps.className = 'ld-gps-status ld-status-sukses';
            statusGps.style.color = '';
        }

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    var addr = data.address;
                    if (alamatInput)    alamatInput.value    = data.display_name || '';
                    if (kelurahanInput) kelurahanInput.value = addr.village || addr.suburb || addr.neighbourhood || addr.residential || '';
                    if (kecamatanInput) kecamatanInput.value = addr.city_district || addr.county || addr.district || '';
                    if (kotaInput)      kotaInput.value      = addr.city || addr.town || addr.municipality || addr.regency || '';
                    if (provinsiInput)  provinsiInput.value  = addr.state || addr.province || '';
                    if (kodePosInput)   kodePosInput.value   = addr.postcode || '';

                    if (statusGps) {
                        statusGps.innerText = 'Lokasi dan alamat berhasil diperbarui.';
                        statusGps.className = 'ld-gps-status ld-status-sukses';
                        statusGps.style.color = '';
                    }
                }
            })
            .catch(err => {
                if (statusGps) {
                    statusGps.innerText = 'Gagal mengambil nama jalan otomatis. Silakan isi manual.';
                    statusGps.className = 'ld-gps-status';
                    statusGps.style.color = 'red';
                }
                console.error(err);
            });
    }

    // 4. Jika Pin Digeser
    marker.on('dragend', function () {
        var position = marker.getLatLng();
        updateFormFields(position.lat, position.lng);
        map.panTo(position);
    });

    // 5. Jika Peta di-Klik
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateFormFields(e.latlng.lat, e.latlng.lng);
    });

    // 6. Fitur Pencarian Alamat Manual di Peta
    const btnSearch = document.getElementById('btnSearchMap');
    const searchInput = document.getElementById('mapSearchInput');

    if (btnSearch && searchInput) {
        btnSearch.addEventListener('click', function () {
            var query = searchInput.value;
            if (!query) return;

            if (statusGps) {
                statusGps.innerText = 'Mencari lokasi...';
                statusGps.className = 'ld-gps-status ld-status-sukses';
                statusGps.style.color = '';
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var lat = parseFloat(data[0].lat);
                        var lon = parseFloat(data[0].lon);
                        var newLatLng = new L.LatLng(lat, lon);

                        map.setView(newLatLng, 16);
                        marker.setLatLng(newLatLng);
                        updateFormFields(lat, lon);
                    } else {
                        if (statusGps) {
                            statusGps.innerText = 'Lokasi tidak ditemukan. Coba kata kunci lain.';
                            statusGps.className = 'ld-gps-status';
                            statusGps.style.color = 'red';
                        }
                    }
                })
                .catch(() => {
                    if (statusGps) {
                        statusGps.innerText = 'Terjadi kesalahan saat mencari lokasi.';
                        statusGps.className = 'ld-gps-status';
                        statusGps.style.color = 'red';
                    }
                });
        });

        // Tekan Enter pada kolom pencarian
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnSearch.click();
            }
        });
    }

    // 7. Tombol "Ambil Lokasi GPS" (Device GPS) — override inisialisasiGPS untuk peta
    const tombolGps = document.getElementById('tombolAmbilLokasi');
    if (tombolGps) {
        // Hapus listener lama agar tidak double-fire, lalu pasang ulang dengan logika peta
        const tombolBaru = tombolGps.cloneNode(true);
        tombolGps.parentNode.replaceChild(tombolBaru, tombolGps);

        tombolBaru.addEventListener('click', function () {
            if (!('geolocation' in navigator)) {
                if (statusGps) {
                    statusGps.innerText = 'Browser Anda tidak mendukung fitur GPS.';
                    statusGps.className = 'ld-gps-status';
                    statusGps.style.color = 'red';
                }
                return;
            }

            if (statusGps) {
                statusGps.innerText = 'Mencari sinyal GPS pada perangkat...';
                statusGps.className = 'ld-gps-status ld-status-sukses';
                statusGps.style.color = '';
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    var newLatLng = new L.LatLng(lat, lon);

                    map.setView(newLatLng, 17);
                    marker.setLatLng(newLatLng);
                    updateFormFields(lat, lon);
                },
                function () {
                    if (statusGps) {
                        statusGps.innerText = 'Gagal mengambil GPS. Pastikan izin lokasi aktif.';
                        statusGps.className = 'ld-gps-status';
                        statusGps.style.color = 'red';
                    }
                }
            );
        });
    }

    // Fix rendering Leaflet agar sesuai dengan ukuran kotak pembungkus
    setTimeout(() => map.invalidateSize(), 500);
}

// ════════════════════════════════════════════════
// LIGHTBOX GAMBAR
// ════════════════════════════════════════════════
function bukaGambarBesar(src) {
    const img = document.getElementById('lightboxGambarImg');
    const box = document.getElementById('lightboxGambar');
    if (img) img.src = src;
    if (box) box.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function tutupGambarBesar() {
    const box = document.getElementById('lightboxGambar');
    if (box) box.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') tutupGambarBesar();
});

// ════════════════════════════════════════════════
// EKSPLORASI — Toggle Ulasan & Highlight Bintang
// ════════════════════════════════════════════════
function toggleUlasan(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function highlightStars(containerId, rating) {
    const container = document.getElementById(containerId);
    if (!container) return;
    const labels = container.querySelectorAll('.star-label');

    labels.forEach((label, idx) => {
        label.style.color = idx < rating ? '#F59E0B' : '#D1D5DB';
    });
}

// ════════════════════════════════════════════════
// DASHBOARD ADMIN — Modal Selesaikan Laporan
// ════════════════════════════════════════════════
function bukaModal(id, judul) {
    const modal = document.getElementById('modalSelesai');
    const form  = document.getElementById('formSelesai');
    if (modal) modal.style.display = 'flex';
    if (form)  form.action = `/admin/laporan/${id}/selesaikan`;
}

function tutupModal() {
    const modal = document.getElementById('modalSelesai');
    if (modal) modal.style.display = 'none';
}

// ════════════════════════════════════════════════
// INIT — Jalankan Semua
// ════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    inisialisasiHeader();
    inisialisasiNavigasi();
    inisialisasiFlash();
    inisialisasiAnimasiScroll();
    animasiHero();
    animasiAngkaStatistik();
    inisialisasiUploadFoto();
    inisialisasiRatingInput();
    inisialisasiRating();
    inisialisasiGPS();
    inisialisasiTracking();
    inisialisasiScrollHorizontal();
    inisialisasiKonfirmasi();
    inisialisasiPeta();
});