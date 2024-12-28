<?php
if (!isset($_SESSION)) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['nama'])) {
    header("Location: berandaDokter.php?page=profilDokter");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_dokter = mysqli_real_escape_string($mysqli, $_GET['id']);
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($mysqli, $_POST['no_hp']);
    $id_poli = mysqli_real_escape_string($mysqli, $_POST['id_poli']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    // Proses update data dokter
    $update = mysqli_query($mysqli, "UPDATE dokter SET 
        nama = '$nama',
        alamat = '$alamat',
        no_hp = '$no_hp',
        id_poli = '$id_poli',
        password = '$password'
        WHERE id = '$id_dokter'");
    
    if ($update) {
        echo "<script>alert('Data dokter berhasil diperbarui!'); document.location='berandaDokter.php?page=dokter';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data dokter!');</script>";
    }
}

// Jika terdapat parameter 'aksi' pada URL
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id_dokter = $_GET['id'];
    $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '$id_dokter'");

    if ($hapus) {
        echo "<script>alert('Data dokter berhasil dihapus!'); document.location='berandaDokter.php?page=dokter';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data dokter!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Dokter</title>
    <link rel="stylesheet" href="style.css"> <!-- Tambahkan jika memiliki file CSS -->
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 15px;
            font-size: 1.5rem;
            text-align: center;
            font-weight: bold;
        }
        .card-body {
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Jadwal Dokter</div>
            <div class="card-body">
                <form method="POST" action="">
                    <?php
                    $nama = '';
                    $alamat = '';
                    $no_hp = '';
                    $id_poli = '';
                    $password = '';

                    if (isset($_GET['id'])) {
                        $id_dokter = $_GET['id'];
                        $result = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id = '$id_dokter'");
                        if ($row = mysqli_fetch_assoc($result)) {
                            $nama = $row['nama'];
                            $alamat = $row['alamat'];
                            $no_hp = $row['no_hp'];
                            $id_poli = $row['id_poli'];
                            $password = $row['password'];
                        }
                    }
                    ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_poli" class="form-label">Poli</label>
                        <select class="form-select" id="id_poli" name="id_poli" required>
                            <option value="" selected>Pilih Poli...</option>
                            <?php
                            $result_poli = mysqli_query($mysqli, "SELECT * FROM poli");
                            while ($poli = mysqli_fetch_assoc($result_poli)) {
                                $selected = ($poli['id'] == $id_poli) ? 'selected' : '';
                                echo "<option value='{$poli['id']}' $selected>{$poli['nama_poli']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="simpan" class="btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
