<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Apa Itu Pupuk Organik Cair (POC)?',
                'slug' => 'apa-itu-pupuk-organik-cair',
                'excerpt' => 'Mengenal pupuk organik cair yang dibuat dari limbah sisa makanan bergizi dan manfaatnya untuk tanaman.',
                'body' => '<h2>Pengertian Pupuk Organik Cair</h2>
<p>Pupuk Organik Cair (POC) adalah pupuk yang berasal dari bahan-bahan organik seperti sisa makanan, sayuran, buah-buahan, dan bahan alami lainnya yang difermentasi dalam bentuk cairan. POC mengandung unsur hara makro dan mikro yang dibutuhkan tanaman.</p>

<h2>Mengapa Membuat POC dari Limbah Makanan?</h2>
<p>Setiap hari, rumah tangga menghasilkan sisa makanan yang biasanya dibuang begitu saja. Padahal, limbah ini bisa diolah menjadi pupuk yang sangat bermanfaat untuk tanaman. Dengan membuat POC, kita:</p>
<ul>
<li><strong>Mengurangi sampah organik</strong> yang mencemari lingkungan</li>
<li><strong>Menghemat biaya</strong> karena tidak perlu membeli pupuk kimia</li>
<li><strong>Menyuburkan tanaman</strong> secara alami dan ramah lingkungan</li>
<li><strong>Menjaga kesehatan tanah</strong> dalam jangka panjang</li>
</ul>

<h2>Manfaat POC untuk Tanaman</h2>
<p>POC memiliki banyak manfaat, di antaranya:</p>
<ul>
<li>Mempercepat pertumbuhan tanaman</li>
<li>Meningkatkan kesuburan tanah</li>
<li>Membantu tanaman lebih tahan terhadap hama dan penyakit</li>
<li>Ramah lingkungan karena tidak mengandung bahan kimia berbahaya</li>
</ul>',
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Panduan Lengkap Membuat POC di Galon 15 Liter',
                'slug' => 'panduan-membuat-poc-galon-15-liter',
                'excerpt' => 'Langkah demi langkah cara membuat Pupuk Organik Cair menggunakan galon Le Minerale 15 liter.',
                'body' => '<h2>Bahan yang Dibutuhkan</h2>
<ul>
<li>1 buah galon Le Minerale 15 liter (bersih)</li>
<li>Sisa makanan bergizi (sayuran, buah, nasi, dll) — sekitar 3-4 kg</li>
<li>Air bersih — sekitar 10 liter</li>
<li>Gula merah atau molase — 200 gram</li>
<li>EM4 atau starter mikroba — 50 ml (opsional)</li>
</ul>

<h2>Langkah Pembuatan</h2>
<h3>1. Persiapan Bahan</h3>
<p>Potong kecil-kecil semua sisa makanan. Semakin kecil potongannya, semakin cepat proses fermentasi.</p>

<h3>2. Mencampur Bahan</h3>
<p>Masukkan sisa makanan yang sudah dipotong ke dalam galon. Tambahkan air bersih hingga <strong>volume maksimal 14,5 liter</strong> (sisakan ruang untuk gas fermentasi). Larutkan gula merah dan masukkan ke galon.</p>

<h3>3. Proses Fermentasi</h3>
<p>Tutup galon, tetapi <strong>jangan terlalu rapat</strong> agar gas hasil fermentasi bisa keluar. Simpan di tempat teduh dan tidak terkena sinar matahari langsung.</p>

<h3>4. Perawatan Harian</h3>
<p>Aduk campuran <strong>setiap 2-3 hari sekali</strong>. Buka tutup galon sebentar untuk melepaskan gas. Pantau warna dan bau cairan.</p>

<h3>5. Masa Panen</h3>
<p>POC siap digunakan setelah <strong>14-21 hari</strong> fermentasi. Ciri POC yang sudah jadi:</p>
<ul>
<li>Warna coklat kehijauan</li>
<li>Bau asam seperti tape (tidak busuk menyengat)</li>
<li>Tidak ada jamur atau bercak aneh</li>
</ul>

<h2>Tips Penting</h2>
<p>Gunakan fitur <strong>Scan Pupuk</strong> di POCYCLE untuk memantau kondisi fermentasi secara berkala!</p>',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Mengenali Tanda-Tanda Pupuk Bermasalah',
                'slug' => 'tanda-pupuk-bermasalah',
                'excerpt' => 'Cara mengidentifikasi apakah pupuk organik cair Anda dalam kondisi baik atau perlu penanganan khusus.',
                'body' => '<h2>Tanda Pupuk dalam Kondisi Normal</h2>
<ul>
<li>Warna <strong>coklat kehijauan</strong> atau kecoklatan jernih</li>
<li>Bau asam seperti tape atau cuka — wajar dan normal</li>
<li>Cairan tidak terlalu pekat</li>
<li>Suhu stabil antara <strong>25-35°C</strong></li>
</ul>

<h2>Tanda Pupuk Perlu Diaduk</h2>
<ul>
<li>Warna terlalu <strong>pekat atau gelap</strong></li>
<li>Ada <strong>endapan tebal</strong> di dasar galon</li>
<li>Cairan terlihat <strong>terpisah</strong> (ada lapisan atas dan bawah)</li>
<li>Suhu di bawah 25°C atau di atas 35°C</li>
</ul>
<p><strong>Penanganan:</strong> Aduk perlahan menggunakan tongkat bersih selama 2-3 menit. Pastikan galon disimpan di tempat yang suhunya stabil.</p>

<h2>Tanda Pupuk Terkontaminasi</h2>
<ul>
<li>Warna <strong>kehitaman atau keabu-abuan</strong></li>
<li>Ada <strong>jamur putih, biru, atau hijau</strong> mengambang</li>
<li>Bau <strong>sangat busuk</strong> dan menyengat (bukan bau asam wajar)</li>
<li>Cairan terlihat sangat tidak normal</li>
</ul>
<p><strong>Penanganan:</strong> Jika kontaminasi ringan, coba tambahkan EM4 dan aduk rata. Jika parah, sebaiknya buang dan mulai membuat batch baru.</p>

<h2>Gunakan POCYCLE untuk Monitoring</h2>
<p>Daripada menebak-nebak, gunakan fitur <strong>Scan Pupuk</strong> di POCYCLE! Cukup foto galon Anda dan masukkan suhu, sistem akan menganalisis kondisi pupuk secara otomatis.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Cara Menggunakan POC untuk Tanaman',
                'slug' => 'cara-menggunakan-poc-tanaman',
                'excerpt' => 'Panduan penggunaan Pupuk Organik Cair yang tepat agar tanaman tumbuh subur dan sehat.',
                'body' => '<h2>Persiapan Sebelum Menggunakan</h2>
<p>POC yang sudah matang (14-21 hari fermentasi) harus <strong>diencerkan</strong> terlebih dahulu sebelum digunakan. Jangan langsung disiramkan ke tanaman dalam kondisi pekat!</p>

<h2>Cara Mengencerkan POC</h2>
<p>Campurkan POC dengan air bersih dengan perbandingan:</p>
<ul>
<li><strong>Tanaman sayuran:</strong> 1 bagian POC : 10 bagian air</li>
<li><strong>Tanaman buah:</strong> 1 bagian POC : 8 bagian air</li>
<li><strong>Tanaman hias:</strong> 1 bagian POC : 15 bagian air</li>
</ul>

<h2>Waktu Penyiraman yang Tepat</h2>
<ul>
<li>Siram pada <strong>pagi hari (06:00-08:00)</strong> atau <strong>sore hari (16:00-18:00)</strong></li>
<li>Hindari menyiram saat terik matahari</li>
<li>Lakukan penyiraman <strong>seminggu sekali</strong></li>
</ul>

<h2>Tips Tambahan</h2>
<ul>
<li>Siram ke area <strong>tanah di sekitar akar</strong>, bukan ke daun</li>
<li>Untuk tanaman dalam pot, gunakan sekitar <strong>200-300 ml</strong> larutan per pot</li>
<li>Amati reaksi tanaman setelah 1-2 minggu penggunaan</li>
</ul>',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($articles as $data) {
            Article::create($data);
        }
    }
}
