<?php
// Gantilah dengan koneksi database sesuai kebutuhan Anda
include '../config.php';

// Pastikan parameter 'id' dan 'barang' tersedia dalam URL
if (isset($_GET['id']) && isset($_GET['barang'])) {
    // Gunakan fungsi mysqli_real_escape_string() untuk mencegah SQL injection
    $id_barang = $_GET['id'];

    // Nama tabel yang ingin Anda hapus datanya
    $namaTabel = 'paket';

    // Query untuk menghapus data
    $sql = "DELETE FROM $namaTabel WHERE id = '$id_barang'";

    // Eksekusi query
    $result = $db->query($sql);

    if ($result) {
        // Redirect ke halaman yang sesuai setelah penghapusan berhasil
        header('Location: ../admin.php?page=barang');
        exit();
    } else {
        // Tampilkan pesan kesalahan jika query gagal
        echo "Gagal menghapus data: " . $db->error;
    }
} else if (isset($_GET['id']) && isset($_GET['user'])) {
    // Gunakan fungsi mysqli_real_escape_string() untuk mencegah SQL injection
    $id_barang = $_GET['id'];

    // Nama tabel yang ingin Anda hapus datanya
    $namaTabel = 'user';

    // Query untuk menghapus data
    $sql = "DELETE FROM $namaTabel WHERE id = '$id_barang'";

    // Eksekusi query
    $result = $db->query($sql);

    if ($result) {
        // Redirect ke halaman yang sesuai setelah penghapusan berhasil
        header('Location: ../admin.php?page=pengaturan');
        exit();
    } else {
        // Tampilkan pesan kesalahan jika query gagal
        echo "Gagal menghapus data: " . $db->error;
    }
} else if (isset($_GET['id']) && isset($_GET['laporan'])) {
    // Gunakan fungsi mysqli_real_escape_string() untuk mencegah SQL injection
    $id_barang = $_GET['id'];

    // Nama tabel yang ingin Anda hapus datanya
    $namaTabel = 'waktu_meja';

    // Query untuk menghapus data
    $sql = "DELETE FROM $namaTabel WHERE id = '$id_barang'";

    // Eksekusi query
    $result = $db->query($sql);

    if ($result) {
        // Redirect ke halaman yang sesuai setelah penghapusan berhasil
        header('Location: ../admin.php?page=laporan');
        exit();
    } else {
        // Tampilkan pesan kesalahan jika query gagal
        echo "Gagal menghapus data: " . $db->error;
    }
} else if (isset($_GET['id']) && isset($_GET['tambahan'])) {
    // Gunakan fungsi mysqli_real_escape_string() untuk mencegah SQL injection
    $id_barang = $_GET['id'];

    // Nama tabel yang ingin Anda hapus datanya
    $namaTabel = 'rekap_tambahan';

    // Query untuk menghapus data
    $sql = "DELETE FROM $namaTabel WHERE id = '$id_barang'";

    // Eksekusi query
    $result = $db->query($sql);

    if ($result) {
        // Redirect ke halaman yang sesuai setelah penghapusan berhasil
        header('Location: ../admin.php?page=tambahan');
        exit();
    } else {
        // Tampilkan pesan kesalahan jika query gagal
        echo "Gagal menghapus data: " . $db->error;
    }
} else if (isset($_GET['id']) && isset($_GET['minuman'])) {
    // Gunakan fungsi mysqli_real_escape_string() untuk mencegah SQL injection
    $id_barang = $_GET['id'];

    // Nama tabel yang ingin Anda hapus datanya
    $namaTabel = 'minuman';

    // Query untuk menghapus data
    $sql = "DELETE FROM $namaTabel WHERE id = '$id_barang'";

    // Eksekusi query
    $result = $db->query($sql);

    if ($result) {
        // Redirect ke halaman yang sesuai setelah penghapusan berhasil
        header('Location: ../admin.php?page=minuman');
        exit();
    } else {
        // Tampilkan pesan kesalahan jika query gagal
        echo "Gagal menghapus data: " . $db->error;
    }
} else {
    // Tampilkan pesan jika parameter tidak tersedia
    echo "Parameter 'id' atau 'barang' tidak tersedia.";
}

// Menutup koneksi database
$db->close();
