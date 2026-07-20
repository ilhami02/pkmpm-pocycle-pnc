# BUKU PANDUAN LENGKAP PENGGUNAAN APLIKASI POCYCLE
**Platform Edukasi dan Monitoring Pembuatan Pupuk Organik Cair Terintegrasi AI**

---

## DAFTAR ISI
1. [Pendahuluan](#1-pendahuluan)
2. [Persiapan dan Persyaratan Sistem](#2-persiapan-dan-persyaratan-sistem)
3. [Alur Kerja Keseluruhan (Workflow)](#3-alur-kerja-keseluruhan-workflow)
4. [Panduan Lengkap Pengguna Umum (Warga/PKK)](#4-panduan-lengkap-pengguna-umum-wargapkk)
5. [Panduan Lengkap Administrator](#5-panduan-lengkap-administrator)
6. [Penyelesaian Masalah (Troubleshooting)](#6-penyelesaian-masalah-troubleshooting)

---

## 1. PENDAHULUAN
**POCYCLE** (Polytechnic Organic Cycle) adalah sebuah aplikasi berbasis web yang dirancang khusus untuk memandu, mendidik, dan mengawasi masyarakat (khususnya Ibu-ibu PKK) dalam mengubah limbah sisa makanan rumah tangga menjadi Pupuk Organik Cair (POC) bernilai guna. 

Keunggulan utama aplikasi ini adalah penggunaan **Kecerdasan Buatan (AI) Google Gemini** yang dapat menganalisis kualitas pupuk hanya melalui foto dari *smartphone*, serta memberikan rekomendasi penanganan secara *real-time*.

---

## 2. PERSIAPAN DAN PERSYARATAN SISTEM
Sebelum menggunakan POCYCLE, pastikan Anda memenuhi spesifikasi berikut:
- **Perangkat**: *Smartphone* (Android / iPhone), Tablet, atau Laptop/PC yang memiliki kamera.
- **Browser yang Disarankan**: Google Chrome, Mozilla Firefox, atau Safari versi terbaru.
- **Koneksi Internet**: Wajib ada untuk mengirim foto ke server AI.
- **Perizinan Browser (Penting!)**: Saat pertama kali membuka web, browser akan meminta izin (Allow) untuk mengakses **Kamera** (jika memotret langsung) dan mengirimkan **Notifikasi** (untuk pengingat). Pastikan Anda menekan tombol **Izinkan/Allow**.

---

## 3. ALUR KERJA KESELURUHAN (WORKFLOW)
Siklus pembuatan POC di aplikasi ini menggunakan alur 21 Hari (3 Minggu) dengan urutan:
1. **Belajar & Menakar**: Pengguna membaca tutorial dan menghitung bahan baku.
2. **Scan Perdana (Hari ke-1)**: Pengguna memotret galon pertama kali untuk mengaktifkan Argo 21 hari.
3. **Monitoring Berkala (Hari 2 - 20)**: Pengguna memotret galon setiap beberapa hari untuk dipantau oleh AI. Jika lupa, sistem akan mengirim notifikasi teguran setiap 3 hari.
4. **Panen (Hari ke-21)**: Sistem otomatis membuka kunci tombol panen. Pengguna memverifikasi hasil panen.
5. **Kembali ke Awal (Idle)**: Setelah panen sukses, sistem di-reset, dan pengguna bisa memulai racikan galon baru.

---

## 4. PANDUAN LENGKAP PENGGUNA UMUM (WARGA/PKK)

### 4.1. Registrasi dan Akses Masuk
1. Buka tautan website POCYCLE.
2. Jika Anda pengguna baru, klik **Daftar**.
3. Isi kolom **Nama Lengkap**, **Alamat Email**, **Kata Sandi**, dan **Konfirmasi Kata Sandi**.
4. Klik **Daftar Akun**. Anda akan otomatis masuk ke Beranda.
5. Jika sudah pernah mendaftar, cukup gunakan menu **Masuk** dan ketikkan Email serta Kata Sandi Anda.

### 4.2. Menggunakan Kalkulator Takaran (Menu Tutorial)
Sebelum membuat pupuk, Anda harus tahu takarannya agar tidak gagal.
1. Navigasi ke menu **🧪 Tutorial**.
2. Gulir ke bawah hingga menemukan bagian **Kalkulator Takaran POC**.
3. Ketikkan jumlah **Berat Limbah (Sisa Makanan)** yang Anda miliki (dalam satuan Gram atau Kilogram).
4. Kalkulator akan secara ajaib menampilkan seberapa banyak **Air Bersih**, **Tetesan EM4 (Bakteri)**, dan **Gula Merah (Molase)** yang harus dilarutkan ke dalam galon Le Minerale 15 liter.
5. Ikuti video atau instruksi teks yang ada di halaman tersebut untuk mulai memasukkan bahan ke dalam galon.

### 4.3. Memulai Siklus Pembuatan (Scan Pertama)
Setelah galon selesai diracik, Anda wajib mendaftarkannya ke sistem.
1. Di bagian paling bawah halaman **Tutorial**, klik tombol **📷 Scan Galon Pertama Anda**.
2. Anda akan diarahkan ke halaman Upload Foto.
3. **Pilih Foto / Buka Kamera**: Pastikan Anda memotret galon dari arah depan secara jelas, di tempat yang terang, sehingga cairan di dalam galon transparan tersebut terlihat.
4. **Masukkan Suhu**: Cek suhu galon (bisa ditebak dengan sentuhan, idealnya racikan awal terasa agak hangat sekitar 35-40°C).
5. Klik **Analisis Pupuk**.
6. Sistem AI akan bekerja selama 5-10 detik. Jika berhasil, sistem akan meresmikan galon tersebut dan memulai perhitungan **Hari ke-1**.

### 4.4. Menangani Penolakan Foto oleh AI (Anti-Kecurangan)
Sistem POCYCLE dilengkapi AI pintar yang mengenali gambar.
- Jika Anda secara sengaja/tidak sengaja mengunggah foto wajah, pemandangan, atau benda yang bukan galon berisi cairan, AI akan **menolak foto tersebut**.
- Anda akan dikembalikan ke form dengan tulisan peringatan merah: *"Sistem mendeteksi bahwa ini bukan foto galon POC..."*
- Solusi: Unggah ulang foto yang benar-benar menampilkan galon pupuk Anda.

### 4.5. Membaca Hasil Analisis AI
Setelah berhasil memindai galon, layar akan menampilkan hasil diagnosis. Ada 3 status utama:
1. **✅ Normal**: Warna cokelat jernih, bau tercium wajar, dan suhu stabil. Lanjutkan fermentasi!
2. **⚠️ Perlu Diaduk (Needs Stirring)**: Cairan mengendap tebal di bawah, memisah, atau suhu telalu dingin. AI akan menyuruh Anda membuka tutup galon dan mengaduknya.
3. **🚫 Terkontaminasi**: Terdapat jamur putih/hitam berlebih, atau warna menghitam busuk. AI akan memberikan instruksi penyelamatan khusus.

### 4.6. Memahami Dashboard POC (Menu Riwayat)
Menu **📋 Riwayat** adalah pusat kendali galon Anda.
- **Status Fermentasi**: Menampilkan besar-besar hari ke-berapa pupuk Anda saat ini.
- **Bilah Kemajuan (Progress Bar)**: Garis yang perlahan penuh hingga ujung (Hari ke-21).
- **Tombol Scan Baru**: Tekan tombol hijau ini setiap 2 atau 3 hari sekali untuk meng-update kondisi pupuk Anda.
- **Daftar Riwayat**: Kumpulan foto-foto lama galon Anda dari Hari ke-1 hingga hari ini, bisa diklik untuk melihat saran AI di masa lalu.

### 4.7. Mengaktifkan Notifikasi Pengingat (Push Notification)
- Jika Anda tidak melakukan *Scan Baru* selama 3 hari berturut-turut, sistem (VPS) akan mengirimkan peringatan otomatis ke HP Anda.
- Syarat: Saat pertama kali login, Anda sudah menekan tombol **Allow Notifications** di browser. Jika belum, klik ikon gembok di sebelah URL browser Anda, pilih *Site Settings*, lalu izinkan *Notifications*.

### 4.8. Proses Memanen Pupuk (Hari ke-21)
Ini adalah puncak dari usaha Anda!
1. Ketika Dashboard POC Anda menunjukkan bahwa Anda telah mencapai **Hari ke-21 (atau lebih)**, sebuah tombol emas besar bertuliskan **🌾 Panen POC Sekarang!** akan muncul.
2. Klik tombol tersebut.
3. Sistem tidak langsung percaya. Anda harus menjawab **3 Syarat Panen**:
   - Apakah aromanya wangi menyerupai tape/alkohol? (Ya/Tidak)
   - Apakah warnanya cokelat pekat menyerupai teh? (Ya/Tidak)
   - Apakah ampas sudah mengendap di bawah? (Ya/Tidak)
4. Jika Anda menjawab "Tidak" pada salah satunya, sistem akan menyuruh Anda menunggu beberapa hari lagi.
5. Jika Anda menjawab "Ya" untuk ketiganya, sistem akan memberikan ucapan selamat!
6. Siklus selesai. Status Anda direset menjadi **Idle** (Belum mulai), dan Anda bisa mengulang dari awal untuk galon kedua.

### 4.9. Membaca Artikel Edukasi
- Klik menu **📖 Edukasi**.
- Anda dapat membaca artikel-artikel yang diterbitkan oleh Tim PKM untuk menambah wawasan Anda seputar pengelolaan lingkungan dan pertanian rumah tangga.

---

## 5. PANDUAN LENGKAP ADMINISTRATOR
Hanya akun dengan hak akses (Role) Admin yang dapat melihat menu **🛠️ Admin Panel** di pojok kanan atas layar (di-klik pada nama profil).

### 5.1. Dashboard Admin
- Menampilkan grafik atau kartu rangkuman (Summary) yang menginformasikan berapa banyak Ibu PKK yang mendaftar, berapa total galon yang sedang diproses, dan berapa artikel yang tayang.

### 5.2. Pemantauan Data Pupuk Keseluruhan (Monitoring Warga)
- Admin tidak perlu turun ke lapangan setiap hari. Cukup buka menu **Data Pupuk**.
- Di sini Admin bisa melihat riwayat *scan* dari **semua warga/pengguna**.
- Jika Admin melihat ada warga yang hasil scan-nya berstatus **🚫 Terkontaminasi**, Admin bisa langsung mencatat nama warga tersebut dan mendatangi rumahnya untuk memberi bantuan langsung.

### 5.3. Manajemen Artikel Edukasi
- Buka menu **Artikel / Edukasi** di panel samping (Sidebar) Admin.
- **Tambah Artikel**: Klik tombol *Tambah*, masukkan Judul, Tulis isi artikel, dan unggah Foto Sampul (*Thumbnail*).
- **Status Publikasi**: Anda bisa menyimpannya sebagai *Draft* (belum tayang) atau *Published* (langsung tayang dan bisa dibaca warga).
- Anda juga dapat mengedit (Edit) jika ada salah ketik, atau menghapus (Delete) artikel yang sudah usang.

### 5.4. Manajemen Pengguna (User Management)
- Buka menu **Pengguna**.
- Menampilkan seluruh email warga yang terdaftar.
- **Ubah Role**: Anda dapat mempromosikan warga biasa menjadi Admin baru (misalnya ketua RT), atau mencabut hak admin.
- **Hapus Akun**: Jika ada akun spam, Anda berhak menghapusnya dari database.

---

## 6. PENYELESAIAN MASALAH (TROUBLESHOOTING)

**Q: Mengapa saya tidak bisa mengunggah foto?**
A: Pastikan ukuran foto galon Anda tidak lebih dari **5 Megabyte (5 MB)**. Foto dari kamera HP modern terkadang terlalu besar. Jika gagal, coba turunkan resolusi kamera HP Anda atau perkecil (*compress*) foto sebelum diunggah.

**Q: Muncul error "Maaf, Layanan Analisis Sedang Sibuk"?**
A: Ini berarti Server AI Google Gemini sedang mengalami gangguan jaringan global atau batas permintaan (*quota limit*) harian aplikasi telah habis. Silakan coba lagi 1-2 jam kemudian.

**Q: Mengapa saya tidak menerima notifikasi pengingat padahal sudah 3 hari lupa scan?**
A: Fitur pengingat bekerja mengirim *Push Notification* ke browser Anda. Pastikan browser (Chrome) Anda tidak berada dalam mode Hemat Daya ekstrem atau mode "Do Not Disturb" di pengaturan HP, dan pastikan izin Notifikasi untuk website *pocyclepnc.com* berstatus *Allowed*.

**Q: Kenapa tombol "Panen POC" di Dashboard saya tidak ada?**
A: Tombol panen dikunci secara sistem dan HANYA AKAN MUNCUL jika argometer Anda telah menginjak tepat **Hari ke-21** (Tiga Minggu) sejak scan pertama kali dilakukan.

**Q: Apakah sistem ini berbayar?**
A: Tidak. POCYCLE 100% gratis digunakan sebagai bentuk pengabdian dari Politeknik Negeri Cilacap.

---
*Dokumen ini dibuat dan dikembangkan untuk keperluan operasional Program Kreativitas Mahasiswa (PKM).*
*Hak Cipta © 2026 Tim POCYCLE - Politeknik Negeri Cilacap.*
