# Kulier Wood

Tema WordPress + WooCommerce custom untuk **Kulier Wood**, toko furnitur kayu. Dibuat untuk brand furnitur yang butuh tampilan katalog, keranjang, dan checkout yang rapi dengan gaya editorial (hero, studio, jurnal) tanpa keluar dari engine bawaan WooCommerce.

## Fitur Utama

- Homepage editorial: hero showroom, profil studio, koleksi unggulan (ambil otomatis dari kategori produk WooCommerce), filosofi desain, craftsmanship, dan aplikasi ruang (`front-page.php`).
- Katalog produk 2 kolom dengan kartu khusus (gambar, judul, deskripsi singkat, harga, status stok) dan related products yang mengikuti gaya yang sama.
- Halaman produk tunggal dengan galeri (zoom/lightbox/slider WooCommerce) dan breadcrumb bergaya minimal.
- Cart & checkout custom template (`cart.php`, `checkout.php`, `thankyou.php`) yang tetap memakai mesin cart/checkout klasik WooCommerce (bukan block checkout).
- Jurnal/blog dengan kartu artikel (`journal-card.php`, `journal-featured.php`).
- Hitung jumlah item keranjang secara live lewat AJAX (`wp_ajax_kulier_cart_count`).
- Navigasi utama + menu mobile (off-canvas) dengan status aktif otomatis.
- Halaman Customizer "Kulier Wood — Perusahaan" untuk mengatur gambar & teks hero/studio/craft serta kontak (email, WhatsApp, alamat, lokasi).
- Formulir kontak/inquiry proyek (`template-parts/contact.php`).
- Ukuran gambar custom (`kulier-card`, `kulier-card-wide`, `kulier-detail`, `kulier-hero`) dan dukungan menu navigasi (primary, footer).

## Tech Stack

- WordPress (tema classic, PHP murni, tanpa framework/build tool)
- WooCommerce (wajib aktif untuk fitur katalog, cart, checkout)
- PHP 8.0+
- CSS & JavaScript vanilla (`assets/css`, `assets/js`), jQuery (dependency bawaan WordPress)
- Google Fonts: Caprasimo & Urbanist

## Cara Menjalankan Lokal

Tema ini tidak punya proses build (tidak ada `package.json`/`composer.json`) — cukup dijalankan di WordPress seperti tema pada umumnya.

1. Siapkan environment WordPress lokal (misalnya via [Local](https://localwp.com), `wp-env`, atau XAMPP/MAMP) dengan PHP 8.0+.
2. Install plugin **WooCommerce** dan aktifkan.
3. Copy folder tema ini ke `wp-content/themes/kulier-wood`, lalu aktifkan dari menu **Appearance > Themes**.
4. Buat halaman Shop (jika belum ada) lewat **WooCommerce > Settings** agar `kulier_shop_url()` punya tujuan.
5. Atur gambar & teks hero/studio/craft serta kontak di **Appearance > Customize > Kulier Wood — Perusahaan**.
6. Tidak ada file `.env` — semua konfigurasi dilakukan lewat wp-config.php standar WordPress dan Customizer tema, tidak ada secret yang disimpan di repo ini.

Tidak ada langkah build terpisah; perubahan pada file PHP/CSS/JS langsung terlihat setelah refresh (ingat untuk menaikkan `KULIER_VERSION` di `functions.php` saat deploy agar cache asset ter-bust).

## Struktur Folder

```
kulier-wood-theme/
├── assets/            # CSS, JS, dan gambar placeholder
├── inc/               # Setup tema, WooCommerce hooks, customizer, template tags
├── template-parts/    # Partial template (contact, journal card/featured)
├── front-page.php      # Homepage
├── index.php, page.php, single.php   # Template dasar WordPress
├── single-product.php, content-product.php, woocommerce.php  # Override WooCommerce
├── cart.php, checkout.php, thankyou.php  # Alur belanja
├── header.php, footer.php
├── functions.php       # Bootstrap tema
├── style.css            # Header tema WordPress (nama, versi, deskripsi)
└── theme.json           # Pengaturan editor blok
```

## Deploy / Rilis

Tidak ada workflow CI/CD di repo ini. Rilis dilakukan manual: upload folder tema (atau file `.zip`-nya) ke `wp-content/themes/` pada server WordPress tujuan, lalu aktifkan dari dashboard.

## Kredit

Dibuat oleh **Ranupane Rimba Argana** — founder [Kukerjain](https://kukerjain.dev).

Profil: https://ranupane.kukerjain.dev
