<?php

include "../../config/db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" href="../assets/img/gulur.jpg">
  <link rel="icon" type="image/png" sizes="100x100" href="../assets/img/gulur.jpg">
  <title>
    Guluran
  </title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<?php include 'sidebar.php'; ?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Pengguna</li>
        </ol>
      </nav>
    </div>
  </nav>
  <!-- End Navbar -->

  <div class="container-fluid py-2">
    <div class="row">
      <div class="ms-3">
        <h3 class="mb-0 h4 font-weight-bolder">Data Pengguna</h3>
      </div>
    </div>
  </div>
<!-- tabel -->
  <div class="table-wrapper">
    <table class="table align-items-center mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)) : ?>
          <?php foreach ($users as $row) : ?>
            <tr>
              <td><?= htmlspecialchars($row['user_id']); ?></td>
              <td><?= htmlspecialchars($row['username']); ?></td>
              <td><?= htmlspecialchars($row['email']); ?></td>
              <td>
                <button data-bs-toggle="modal" data-bs-target="#editUserModal" class="btn btn-edit btn-warning btn-sm" data-id="<?= $row['user_id']; ?>" data-username="<?= $row['username'] ?>" data-email="<?= $row['email'] ?>" onclick="setEdit(this)">Ubah</button>
                <button class="btn btn-delete btn-danger btn-sm" data-id="<?= $row['user_id']; ?>" onclick="deleteUser(<?= $row['user_id']; ?>)">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="5" class="text-center">Tidak ada data pengguna.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal Edit User -->
  <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editUserForm">
            <div class="mb-3">
              <label for="editUsername" class="form-label">Username</label>
              <input type="text" class="form-control" id="editUsername" required>
            </div>
            <div class="mb-3">
              <label for="editEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="editEmail" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function setEdit(btnData) {
      let username = btnData.getAttribute('data-username');
      let email = btnData.getAttribute('data-email');
      document.getElementById('editUsername').value = username;
      document.getElementById('editEmail').value = email;
    }
    // fungsi mengubah isi tabel 
    function editUser(user_id) {
      // Ambil nilai input dari form
      const username = document.getElementById('editUsername').value;
      const email = document.getElementById('editEmail').value;

      // Verifikasi bahwa input tidak kosong
      if (username === '' || email === '') {
        alert('Nama dan Email tidak boleh kosong!');
        return;
      }

      // Debugging: Pastikan data yang akan dikirim sudah benar
      console.log("User ID:", user_id);
      console.log("Username:", username);
      console.log("Email:", email);

      const confirmUpdate = confirm('Apakah Anda yakin ingin mengubah data pengguna ini?');

      if (confirmUpdate) {
        // Mengirim data update ke server
        const formData = new FormData();
        formData.append('user_id', user_id);
        formData.append('username', username);
        formData.append('email', email);

        fetch('update_user.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            console.log(data); // Debugging: tampilkan data yang diterima dari server
            if (data.success) {
              alert('Data pengguna berhasil diubah!');
              location.reload(); // Refresh halaman setelah berhasil update
            } else {
              alert('Terjadi kesalahan saat mengubah data pengguna.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah data pengguna.');
          });
      }
    }

    // Fungsi untuk menghapus pengguna
    function deleteUser(user_id) {
      const confirmDelete = confirm('Apakah Anda yakin ingin menghapus pengguna ini?');

      if (confirmDelete) {
        fetch(`hapus_users.php?id=${user_id}`, {
            method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Pengguna berhasil dihapus!');
              location.reload();
            } else {
              alert('Terjadi kesalahan saat menghapus pengguna.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus pengguna.');
          });
      }
    }
  </script>

</main>
</body>

</html>