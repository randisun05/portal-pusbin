/*
 * Skeleton loading: mengatur overlay #page-skeleton (muat awal & pindah halaman),
 * placeholder gambar, dan kotak grafik ApexCharts. Tidak bergantung pada jQuery.
 */
(function () {
  'use strict';

  var overlay = document.getElementById('page-skeleton');
  var timer = null;

  // Beranda berbentuk hero; halaman lain berbentuk judul + kartu. Overlay admin tidak berganti bentuk.
  function pilihBentuk(url) {
    if (!overlay || overlay.getAttribute('data-variant') === 'admin') return;
    var beranda = url && (url.pathname === '/' || url.pathname === '/webpusbin');
    overlay.setAttribute('data-variant', beranda ? 'landing' : 'public');
  }

  function setState(state, tujuan) {
    if (!overlay) return;
    if (tujuan) pilihBentuk(tujuan);
    clearTimeout(timer);
    // animation inline dikosongkan agar animasi CSS state baru berjalan dari awal
    overlay.style.animation = '';
    overlay.setAttribute('data-state', state);
    if (document.body) document.body.setAttribute('aria-busy', state === 'idle' ? 'false' : 'true');

    if (state === 'navigating') {
      // Jika navigasi tidak pernah selesai (unduhan, dibatalkan), jangan biarkan overlay menutupi halaman
      timer = setTimeout(function () { setState('idle'); }, 10000);
    }
  }

  // --- Muat awal selesai ---
  // Konten sudah bisa dipakai saat DOM siap; gambar besar punya skeleton sendiri,
  // jadi tidak perlu menunggu seluruh gambar tuntas seperti preloader lama.
  function ready() { setState('idle'); }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      setTimeout(ready, 0);
      skeletonImages();
    });
    window.addEventListener('load', ready);
  } else {
    ready();
    skeletonImages();
  }

  // Kembali lewat tombol back (bfcache) tidak memicu load ulang
  window.addEventListener('pageshow', function (e) { if (e.persisted) ready(); });

  // --- Pindah halaman: tampilkan skeleton sampai halaman baru datang ---
  // Respons yang berupa unduhan file tidak memuat ulang halaman, sehingga overlay akan tersangkut.
  var UNDUHAN_PATH = /\/(export|download|unduh|cetak|qr-absensi|daftar-hadir)\/?$/i;
  var UNDUHAN_FILE = /\.(pdf|docx?|xlsx?|pptx?|csv|zip|rar|png|jpe?g|gif|svg|webp|mp4)$/i;

  function sameOriginNavigation(a) {
    if (!a.href || a.hasAttribute('download') || a.hasAttribute('data-no-skeleton')) return false;
    if (a.target && a.target !== '_self') return false;
    // Pemicu komponen Bootstrap/lightbox (dropdown, modal, tab, galeri) bukan navigasi
    if (a.hasAttribute('data-bs-toggle') || a.hasAttribute('data-bs-target') || a.classList.contains('glightbox')) return false;
    if (!/^https?:$/.test(a.protocol) || a.origin !== window.location.origin) return false;
    // Hanya anchor di halaman yang sama
    if (a.pathname === window.location.pathname && a.search === window.location.search) return false;
    return !UNDUHAN_PATH.test(a.pathname) && !UNDUHAN_FILE.test(a.pathname);
  }

  document.addEventListener('click', function (e) {
    if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
    var a = e.target.closest && e.target.closest('a[href]');
    if (a && sameOriginNavigation(a)) setState('navigating', a);
  });

  document.addEventListener('submit', function (e) {
    var form = e.target;
    // Handler lain (konfirmasi hapus, submit via fetch) sudah jalan lebih dulu dan membatalkan submit bawaan
    if (e.defaultPrevented || form.hasAttribute('data-no-skeleton')) return;
    if (form.target && form.target !== '_self') return;
    var action;
    try { action = new URL(form.action, window.location.href); } catch (err) { return; }
    if (UNDUHAN_PATH.test(action.pathname)) return;
    setState('navigating', action);
  });

  // --- Gambar: kilau sampai selesai dimuat ---
  function skeletonImages(root) {
    var imgs = (root || document).querySelectorAll('img');
    Array.prototype.forEach.call(imgs, function (img) {
      if (img.complete) return;
      img.classList.add('skeleton-img');
      var done = function () { img.classList.remove('skeleton-img'); };
      img.addEventListener('load', done, { once: true });
      img.addEventListener('error', done, { once: true });
    });
  }
  // Untuk gambar yang ditambahkan lewat JS
  window.skeletonImages = skeletonImages;

  // --- Grafik ApexCharts: lepas kilau (class skel) setelah grafik tergambar ---
  // Kotak grafik diberi class "skel skel-chart" di view; ApexCharts menulis ke dalam elemen yang sama.
  if (window.ApexCharts && window.ApexCharts.prototype && !window.ApexCharts.prototype.__skelPatched) {
    var asli = window.ApexCharts.prototype.render;
    window.ApexCharts.prototype.render = function () {
      var el = this.el;
      var hasil = asli.apply(this, arguments);
      var selesai = function () {
        if (el && el.classList) el.classList.remove('skel', 'skel-chart');
      };
      Promise.resolve(hasil).then(selesai, selesai);
      return hasil;
    };
    window.ApexCharts.prototype.__skelPatched = true;
  }

  // Jaring pengaman: jika pustaka grafik tidak termuat (mis. diblokir CSP) atau grafik tak kunjung
  // tergambar, hentikan kilau supaya tidak berkilau selamanya.
  function lepasKilauGrafik(pesan) {
    Array.prototype.forEach.call(document.querySelectorAll('.skel-chart'), function (el) {
      el.classList.remove('skel', 'skel-chart');
      if (pesan && !el.children.length) {
        el.textContent = pesan;
        el.classList.add('text-muted', 'small', 'text-center', 'py-4');
      }
    });
  }

  window.addEventListener('load', function () {
    setTimeout(function () {
      if (typeof window.ApexCharts === 'undefined') lepasKilauGrafik('Grafik tidak dapat dimuat.');
    }, 600);
    setTimeout(function () { lepasKilauGrafik(); }, 8000);
  });
})();
