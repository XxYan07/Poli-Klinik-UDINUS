<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: index.php?page=loginUser");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        // Proses update data user
        $ubah = mysqli_query($mysqli, "UPDATE user SET 
            nama = '" . $_POST['nama'] . "',
            username = '" . $_POST['username'] . "',
            `password` = '" . $_POST['password'] . "'
            WHERE id = '" . $_POST['id'] . "'");
    } else {
        // Proses tambah data user
        $tambah = mysqli_query($mysqli, "INSERT INTO user (nama, username, no_hp, id_poli, `password`) 
            VALUES (
                '" . $_POST['nama'] . "',
                '" . $_POST['username'] . "',
                '" . $_POST['password'] . "'
            )");
    }
    echo "<script>document.location='index.php?page=admin';</script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM user WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php?page=admin';
        </script>";
}
?>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">User</div>
                <div class="card-body">
                    <form class="form row" method="POST" style="width: 30rem;" action="" name="myForm" onsubmit="return(validate());">
                        <?php
                        $nama = '';
                        $username = '';
                        $password = '';
                        if (isset($_GET['id'])) {
                            $ambil = mysqli_query($mysqli, "SELECT * FROM user 
                                WHERE id='" . $_GET['id'] . "'");
                            while ($row = mysqli_fetch_array($ambil)) {
                                $nama = $row['nama'];
                                $username = $row['username'];
                                $password = $row['password'];
                            }
                        ?>
                            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                        <?php
                        }
                        ?>
                        <div class="row">
                            <label for="inputNama" class="form-label fw-bold">Nama</label>
                            <div>
                                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="inputusername" class="form-label fw-bold">Username</label>
                            <div>
                                <input type="text" class="form-control" name="username" id="inputusername" placeholder="Username" value="<?php echo $username ?>">
                            </div>
                        </div>
                        <div class="row">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div>
                                <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <br><br>
    <!-- Table-->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM user");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row" class="text-center"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['username'] ?></td>
                    <td><?php echo $data['password'] ?></td>
                    <td class="d-flex justify-content-center">
                        <div class="d-flex gap-2 mb-3">
                            <a type="button" class="btn btn-success rounded-pill px-3" href="index.php?page=admin&id=<?php echo $data['id'] ?>">
                                Edit
                            </a>
                            <a type="button" class="btn btn-danger rounded-pill px-3" href="index.php?page=admin&id=<?php echo $data['id'] ?>&aksi=hapus">
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
