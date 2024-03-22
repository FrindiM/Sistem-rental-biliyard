# Aplikasi Web Rental Biliard

Aplikasi Web Rental Biliard adalah sebuah sistem manajemen untuk rental meja biliard yang dibangun menggunakan PHP,Javascript, Jquery, dan MYSQL. Aplikasi ini memungkinkan pengguna untuk melakukan pemesanan meja, melihat ketersediaan meja, mengelola data pelanggan, dan menyimpan riwayat transaksi.

## Cara Menggunakan

1. Pastikan Anda memiliki lingkungan pengembangan PHP yang telah terpasang di komputer Anda. Anda dapat menggunakan XAMPP, WAMP, MAMP, atau lingkungan serupa.
2. Clone repositori ini ke dalam direktori web server Anda.
    ```
    git clone https://github.com/FrindiM/Sistem-rental-biliyard.git
    ```
3. Buatlah sebuah database MySQL untuk aplikasi rental biliard Anda.
4. Impor struktur tabel dan data awal yang terdapat pada direktori `database` ke dalam database yang telah Anda buat.
5. Konfigurasikan koneksi database Anda pada file `config.php` yang terletak di dalam direktori `includes`.
    ```php
    <?php
    // File: includes/config.php
    
    $db_host = 'localhost'; // Sesuaikan dengan host database Anda
    $db_user = 'root';      // Sesuaikan dengan username database Anda
    $db_pass = '';          // Sesuaikan dengan password database Anda
    $db_name = 'rental_biliard'; // Nama database yang telah Anda buat
    
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($db->connect_error) {
        die("Koneksi database gagal: " . $db->connect_error);
    }
    ?>
    ```
6. Akses aplikasi melalui web browser Anda.
7. Login ke dalam aplikasi menggunakan akun yang telah Anda buat sebelumnya.

## Fitur Aplikasi

- Pemesanan meja biliard.
- Melihat ketersediaan meja biliard.
- Manajemen data pelanggan (penambahan, pengeditan, dan penghapusan).
- Penyimpanan riwayat transaksi.
- Dan fitur lainnya.

## Tambahan

- Terdapat fitur komunikasi serial untuk mematikan dan menghidupkan lampu secara otomatis
- jika ingin memanfaatkan fitur ini syaratnya alat/saklar harus menerima data "1N - 10N" untuk menghidupkan dan "1F - 10F" untuk menghidpkan lampu
- broser yang dignakan harus chrome

## Kontribusi

Jika Anda menemukan bug atau memiliki saran untuk peningkatan, jangan ragu untuk membuat *issue* atau *pull request* pada repositori ini.

## Suport

Jika ada pertanyaan silakan hubungi saya di friendymangimbulude@gmail.com dengan subject "Suport-Biliard"

