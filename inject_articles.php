<?php
use App\Models\Article;
use Illuminate\Support\Str;

$articles = [
    [
        'title' => 'Manfaat Pupuk Organik Cair (POC) untuk Tanaman Hias',
        'excerpt' => 'Tanaman hias di rumah bisa tumbuh lebih subur dan tahan penyakit dengan menggunakan POC secara rutin. Pelajari cara aplikasinya di sini.',
        'body' => '<p>Pupuk Organik Cair (POC) tidak hanya bermanfaat untuk tanaman pertanian, tetapi juga sangat baik untuk tanaman hias kesayangan Anda di rumah. POC kaya akan unsur hara makro dan mikro yang sangat dibutuhkan oleh tanaman hias seperti Aglonema, Monstera, Janda Bolong, hingga anggrek.</p>
        <p>Kelebihan utama POC dibandingkan pupuk kimia adalah sifatnya yang mudah diserap oleh akar dan daun tanaman. Selain itu, penggunaan POC secara rutin juga dapat memperbaiki struktur media tanam di dalam pot sehingga tidak mudah padat dan porositasnya tetap terjaga.</p>
        <p><strong>Cara Pengaplikasian:</strong><br>Sangat mudah! Cukup encerkan POC dengan air bersih dengan perbandingan 1:10 (10 ml POC untuk 1 liter air). Siramkan larutan ini ke media tanam atau semprotkan perlahan ke permukaan daun pada pagi atau sore hari. Lakukan secara rutin 1-2 minggu sekali. Dengan perawatan ini, daun tanaman hias akan tampak lebih hijau mengkilap, tunas baru lebih cepat bermunculan, dan tanaman jauh lebih kebal terhadap serangan hama atau penyakit.</p>'
    ],
    [
        'title' => 'Cara Menyimpan POC Agar Tahan Lama dan Tidak Rusak',
        'excerpt' => 'Sering membuat POC dalam jumlah banyak? Ikuti tips menyimpan POC yang benar agar kualitas unsur haranya tetap terjaga berbulan-bulan.',
        'body' => '<p>Membuat POC sendiri di rumah memang menyenangkan dan hemat. Namun, tantangan berikutnya adalah bagaimana cara menyimpan POC tersebut jika kita membuatnya dalam jumlah yang cukup banyak. Penyimpanan yang salah bisa membuat POC berbau sangat busuk, dipenuhi belatung, atau unsur haranya rusak.</p>
        <p>Berikut adalah beberapa tips penting dalam menyimpan POC hasil panen:</p>
        <ol>
            <li><strong>Saring dengan Bersih:</strong> Pastikan Anda memisahkan ampas padat dari cairan POC dengan menggunakan saringan halus atau kain tipis. Ampas yang tersisa bisa membusuk dan merusak cairan.</li>
            <li><strong>Gunakan Wadah Gelap:</strong> Simpan POC di dalam botol atau jerigen yang berwarna gelap (tidak tembus cahaya matahari langsung). Sinar UV dapat membunuh mikroorganisme baik di dalam POC.</li>
            <li><strong>Jangan Tutup Terlalu Rapat:</strong> Meskipun sudah dipanen, terkadang masih ada sedikit proses fermentasi yang menghasilkan gas. Buka tutup botol sesekali setiap minggu untuk membuang gas, atau jangan putar tutupnya terlalu kencang.</li>
            <li><strong>Simpan di Tempat Sejuk:</strong> Jauhkan dari sumber panas dan terik matahari. Suhu ruangan yang teduh adalah tempat terbaik.</li>
        </ol>
        <p>Jika disimpan dengan benar, POC bisa bertahan hingga 6 bulan bahkan 1 tahun dengan kualitas yang masih sangat baik untuk digunakan.</p>'
    ],
    [
        'title' => 'Memanfaatkan Air Cucian Beras sebagai Bahan Dasar POC',
        'excerpt' => 'Jangan buang air cucian beras Anda! Air ini adalah bahan dasar yang sangat istimewa untuk membuat Pupuk Organik Cair.',
        'body' => '<p>Setiap hari kita pasti memasak nasi dan membuang air cucian beras begitu saja. Padahal, air cucian beras (terutama cucian pertama yang berwarna putih keruh) mengandung karbohidrat, protein, serta berbagai mineral seperti fosfor dan kalsium yang sangat disukai oleh tanaman dan mikroorganisme tanah.</p>
        <p><strong>Mengapa Air Cucian Beras Sangat Bagus?</strong><br>Karbohidrat dalam air cucian beras bertindak sebagai makanan bagi bakteri pengurai (seperti EM4) selama proses fermentasi. Ini membuat proses fermentasi POC berjalan lebih cepat dan sempurna.</p>
        <p><strong>Cara Sederhana Menggunakannya:</strong></p>
        <ul>
            <li>Gunakan air cucian beras sebagai pengganti air biasa saat Anda melarutkan gula merah atau molase dalam pembuatan POC.</li>
            <li>Anda juga bisa langsung memfermentasi air cucian beras saja! Cukup tambahkan sedikit larutan gula merah dan EM4 ke dalam sebotol air cucian beras, diamkan selama 1-2 minggu, dan Anda sudah memiliki POC Air Leri yang kaya akan vitamin B dan memicu pertumbuhan akar.</li>
        </ul>
        <p>Mulai sekarang, sediakan satu wadah khusus di dapur untuk menampung air cucian beras. Tanaman Anda akan sangat berterima kasih!</p>'
    ],
    [
        'title' => 'Perbedaan POC dari Limbah Buah vs Limbah Sayuran',
        'excerpt' => 'Apakah POC dari sisa buah berbeda khasiatnya dengan POC dari sisa sayur? Kenali perbedaannya untuk memaksimalkan hasil panen Anda.',
        'body' => '<p>Banyak yang bertanya, apakah ada perbedaan jika kita membuat POC murni dari sisa buah-buahan (seperti kulit pisang, pepaya, mangga) dibandingkan dengan murni sisa sayuran hijau? Jawabannya: <strong>Ada, dan keduanya memiliki fungsi yang spesifik!</strong></p>
        <p><strong>1. POC Sayuran (Kaya Nitrogen)</strong><br>Sayuran hijau sangat kaya akan unsur Nitrogen (N). POC yang dihasilkan dari limbah sayuran sangat cocok diaplikasikan pada fase vegetatif tanaman (masa pertumbuhan). Pupuk ini akan merangsang pembentukan daun, batang yang kuat, dan tunas baru. Sangat cocok untuk tanaman hias daun atau sayuran daun seperti bayam, kangkung, dan sawi.</p>
        <p><strong>2. POC Buah-buahan (Kaya Kalium & Fosfor)</strong><br>Limbah buah-buahan, terutama kulit pisang dan sabut kelapa, kaya akan Kalium (K) dan Fosfor (P). POC jenis ini sangat direkomendasikan untuk diaplikasikan pada fase generatif (masa berbunga dan berbuah). Pupuk ini membantu mencegah bunga rontok, memperbesar ukuran buah, dan membuat rasa buah menjadi lebih manis.</p>
        <p><strong>Tips Terbaik:</strong> Jika Anda memiliki tanaman yang sedang dalam masa pertumbuhan, gunakan POC sayur. Jika tanaman sudah mulai berbunga, ganti dengan POC buah. Atau, campurkan keduanya sejak awal untuk mendapatkan POC dengan nutrisi yang seimbang (NPK organik)!</p>'
    ],
    [
        'title' => 'Tanda-tanda POC Berhasil dan Siap Panen',
        'excerpt' => 'Ragu apakah fermentasi POC Anda berhasil atau malah busuk? Cek tanda-tandanya di sini sebelum mengaplikasikannya ke tanaman.',
        'body' => '<p>Menunggu masa fermentasi POC (biasanya 14-21 hari) bisa membuat berdebar, apalagi bagi pemula. Pertanyaan yang sering muncul adalah: "Apakah ini berhasil atau gagal?" Mengaplikasikan POC yang gagal (pembusukan patogen) justru bisa membuat tanaman mati atau layu.</p>
        <p>Berikut adalah ciri-ciri mutlak bahwa POC Anda <strong>berhasil</strong> dan siap panen:</p>
        <ul>
            <li><strong>Aroma Khas Fermentasi:</strong> POC yang berhasil TIDAK akan berbau busuk menyengat seperti bangkai atau got mampet. Aromanya akan menyerupai bau tape, tuak, asam wangi segar, atau mirip bau ragi tempe. Jika berbau busuk tajam, berarti proses anaerob gagal atau ada bakteri patogen yang mendominasi.</li>
            <li><strong>Muncul Embun/Buih Putih:</strong> Di permukaan cairan biasanya terdapat lapisan putih seperti jamur tipis atau buih halus. Ini adalah kumpulan bakteri baik (Actinomycetes) yang terbentuk selama fermentasi.</li>
            <li><strong>Cairan Terpisah:</strong> Ampas organik biasanya akan tenggelam ke dasar atau mengapung rata di atas, sementara bagian tengah cairan terlihat lebih jernih dengan warna kecoklatan hingga kehitaman.</li>
            <li><strong>Tidak Ada Belatung Pengebor:</strong> POC yang ditutup rapat tidak boleh ada belatung (maggot). Jika ada belatung, berarti wadah tidak kedap udara dan lalat berhasil bertelur di dalamnya.</li>
        </ul>
        <p>Jika POC Anda memenuhi ciri-ciri di atas, selamat! Anda sudah bisa memanennya dengan menyaring cairannya dan menyimpannya di botol tertutup.</p>'
    ],
    [
        'title' => 'Dosis yang Tepat untuk Penggunaan POC',
        'excerpt' => 'Meski organik, penggunaan POC yang berlebihan bisa berbahaya bagi tanaman. Ketahui dosis dan takaran yang tepat di artikel ini.',
        'body' => '<p>Satu kesalahan umum yang sering dilakukan pemula adalah menganggap bahwa "karena organik, semakin banyak semakin bagus". Padahal, POC hasil fermentasi bersifat sangat pekat (konsentrat). Menyiramkan POC murni secara langsung ke tanaman justru akan membuat daun terbakar, akar kepanasan, dan tanaman mati layu (overdosis).</p>
        <p><strong>Aturan Emas Pengenceran POC:</strong><br>Selalu gunakan rasio <strong>1:10 hingga 1:20</strong>.</p>
        <p>Artinya, 1 bagian POC dicampur dengan 10-20 bagian air bersih. <br>Contoh praktis:</p>
        <ul>
            <li>10 ml POC (sekitar 1 tutup botol air mineral) dicampur dengan 1 Liter air.</li>
            <li>Untuk tanaman yang masih muda (bibit/semaian), gunakan dosis lebih encer, yakni 5 ml POC untuk 1 Liter air.</li>
            <li>Untuk tanaman keras/pohon buah besar, Anda bisa menggunakan dosis 20 ml POC per 1 Liter air.</li>
        </ul>
        <p><strong>Frekuensi Pemberian:</strong><br>Pemberian dilakukan 1 kali seminggu atau paling cepat 2 kali seminggu. Jangan diberikan setiap hari. Biarkan mikroorganisme dalam tanah bekerja mengurai nutrisi secara perlahan. Dengan dosis yang pas, tanaman Anda akan menunjukkan hasil yang memuaskan dalam hitungan minggu!</p>'
    ],
    [
        'title' => 'Mengurangi Sampah Dapur Demi Lingkungan yang Lebih Baik',
        'excerpt' => 'Tahukah Anda bahwa sampah sisa makanan di TPA menyumbang gas metana yang merusak ozon? Mari mulai kelola dari dapur sendiri.',
        'body' => '<p>Masalah sampah adalah tanggung jawab kita bersama. Menurut data, hampir 60% sampah yang masuk ke Tempat Pembuangan Akhir (TPA) di Indonesia adalah sampah organik yang berasal dari sisa makanan rumah tangga. Ketika sampah organik ini menumpuk dan membusuk tanpa sirkulasi udara di TPA, ia akan menghasilkan gas metana (CH4).</p>
        <p>Gas metana adalah gas rumah kaca yang 25 kali lebih merusak lapisan ozon dibandingkan karbon dioksida (CO2)!</p>
        <p><strong>Apa Solusinya?</strong><br>Solusi paling ampuh dimulai dari dapur kita sendiri. Dengan memisahkan sampah organik (sisa sayur, kulit buah, sisa nasi) dan memprosesnya menjadi Pupuk Organik Cair (POC) atau kompos, kita telah memotong rantai masalah sampah ini secara drastis.</p>
        <p>Selain mencegah pemanasan global, limbah yang tadinya menjijikkan ini bertransformasi menjadi "emas cair" yang bernilai gizi tinggi bagi bumi. Mari jadikan pembuatan POC sebagai kebiasaan gaya hidup ramah lingkungan keluarga. Mulai dari langkah kecil, untuk bumi yang lebih hijau.</p>'
    ],
    [
        'title' => 'Menghindari Bau Busuk Saat Fermentasi POC',
        'excerpt' => 'Takut rumah menjadi bau karena membuat POC? Jangan khawatir, ini dia rahasia membuat POC tanpa bau busuk.',
        'body' => '<p>Banyak orang enggan membuat POC karena khawatir akan menimbulkan bau busuk yang mengganggu kenyamanan keluarga atau tetangga. Padahal, jika dilakukan dengan metode yang benar, proses pembuatan POC 100% tidak akan menghasilkan bau menyengat yang mengganggu.</p>
        <p>Berikut adalah kunci anti-bau dalam membuat POC:</p>
        <ol>
            <li><strong>Pastikan Kondisi Anaerob (Kedap Udara):</strong> Pembusukan berbau busuk disebabkan oleh bakteri aerob pembusuk. Oleh karena itu, pastikan galon/wadah POC tertutup rapat. Gunakan sistem selang yang dialirkan ke botol air (water trap) agar gas bisa keluar tapi udara luar tidak bisa masuk.</li>
            <li><strong>Cukupkan Kebutuhan Gula (Karbohidrat):</strong> Bakteri EM4 sangat butuh gula untuk bekerja optimal. Jika bahan organik sangat banyak tapi gula (molase/gula merah/gula pasir) kurang, bakteri baik akan kalah bersaing dengan patogen. Berikan setidaknya 100 gram gula untuk setiap 1 kg bahan organik.</li>
            <li><strong>Hindari Sampah Hewani:</strong> Untuk pemula, SANGAT DISARANKAN hanya menggunakan sampah nabati (sayur, buah, nasi). Sampah hewani seperti tulang ikan, sisa daging, atau kulit udang membutuhkan penanganan khusus dan sangat rentan memicu bau busuk seperti bangkai jika salah sedikit saja.</li>
        </ol>
        <p>Dengan mengikuti 3 aturan di atas, POC Anda justru akan menghasilkan aroma harum fermentasi seperti tape!</p>'
    ],
    [
        'title' => 'Mengapa Pupuk Organik Lebih Baik dari Pupuk Kimia?',
        'excerpt' => 'Banyak petani mulai beralih kembali ke pupuk organik. Apa sebenarnya bahaya pupuk kimia jangka panjang?',
        'body' => '<p>Selama puluhan tahun, penggunaan pupuk kimia sintetis (seperti Urea, TSP, KCl) dianggap sebagai solusi instan untuk meningkatkan panen. Memang benar, efek pupuk kimia sangat cepat terlihat karena unsur haranya langsung siap serap. Namun, ada harga mahal yang harus dibayar oleh lingkungan.</p>
        <p><strong>Dampak Buruk Pupuk Kimia Jangka Panjang:</strong></p>
        <ul>
            <li><strong>Tanah Menjadi Keras dan Mati:</strong> Pupuk kimia meninggalkan residu garam. Lama kelamaan, tanah akan mengeras, kehilangan porositas, dan cacing tanah mati. Tanah kehilangan kesuburan alaminya.</li>
            <li><strong>Tanaman Ketergantungan:</strong> Sama seperti suplemen instan, tanaman menjadi manja dan daya tahan tubuhnya terhadap hama justru menurun, sehingga membutuhkan lebih banyak pestisida kimia.</li>
        </ul>
        <p><strong>Keajaiban Pupuk Organik (Termasuk POC):</strong><br>Berbeda dengan kimia, pupuk organik bekerja dengan cara <em>memperbaiki ekosistem tanah</em>. POC tidak hanya memberi makan tanaman, tetapi juga memberi makan miliaran mikroba baik di dalam tanah. Mikroba inilah yang akan menggemburkan tanah dan mengikat unsur hara alami.</p>
        <p>Meskipun efeknya sedikit lebih lambat dari kimia, penggunaan POC memastikan tanah Anda tetap subur dan produktif untuk diwariskan hingga ke anak cucu nanti.</p>'
    ],
    [
        'title' => 'Tips Berkebun di Lahan Sempit dengan Bantuan POC',
        'excerpt' => 'Tidak punya pekarangan luas? Anda tetap bisa berkebun subur di polybag dan pot bermodalkan nutrisi dari POC.',
        'body' => '<p>Tinggal di perkotaan dengan lahan pekarangan yang sempit atau bahkan hanya memiliki balkon apartemen bukanlah halangan untuk berkebun. Sistem tabulampot (tanaman buah dalam pot) atau menanam sayur di <em>polybag</em> menjadi solusi populer.</p>
        <p>Tantangan utama berkebun di pot adalah ketersediaan nutrisi tanah yang sangat terbatas. Akar tidak bisa mencari makan jauh-jauh. Di sinilah Pupuk Organik Cair (POC) menjadi pahlawan utama!</p>
        <p><strong>Cara Memaksimalkan POC untuk Lahan Sempit:</strong></p>
        <ol>
            <li><strong>Sistem Semprot (Foliar):</strong> Karena ruang akar terbatas, maksimalkan penyerapan lewat daun. Semprotkan larutan POC encer (1:20) ke bagian bawah daun pada jam 7-9 pagi. Stomata daun sedang terbuka lebar dan akan langsung meminum nutrisi tersebut.</li>
            <li><strong>Campurkan POC dengan Air Siraman:</strong> Jadwalkan penyiraman khusus POC setiap hari minggu pagi. Ini akan terus meregenerasi unsur hara di dalam media pot yang terbatas.</li>
            <li><strong>Pembuatan Kompos Langsung:</strong> Ampas dari pembuatan POC jangan dibuang! Kubur ampas tersebut sedikit di bagian bawah tanah di dalam pot Anda. Ampas akan menjadi pupuk padat slow-release yang istimewa.</li>
        </ol>
        <p>Dengan telaten menggunakan POC, tanaman cabe, tomat, atau seledri di pot Anda bisa tumbuh luar biasa subur seolah ditanam di kebun yang luas.</p>'
    ]
];

foreach ($articles as $data) {
    Article::create([
        'title' => $data['title'],
        'excerpt' => $data['excerpt'],
        'body' => $data['body'],
        'cover_image' => null, 
        'is_published' => true,
        'published_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 24)),
    ]);
}
echo "10 Artikel berhasil di-inject ke database!\n";
