<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon"  href="../assets/img/gulur.jpg">
  <link rel="icon" type="image/png" sizes="100x100" href="../assets/img/gulur.jpg">
  <title>
    Guluran
  </title>
  <!--     Fonts and icons     -->
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
</head>
<style>
    /* body {
      font-family: 'Roboto', sans-serif;
      background-color: #f9f9f9;
    } */

    .container {
      max-width: 1200px;
      margin: 30px auto;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 2.5em;
      color: #333;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .action-btns button {
      margin-left: 5px;
    }

    .btn-detail {
      background-color: #4CAF50;
      color: white;
    }

    .btn-edit {
      background-color: #ffa500;
      color: white;
    }

    .btn-delete {
      background-color: #f44336;
      color: white;
    }

    .btn-add {
      background-color: #007bff;
      color: white;
    }

    .btn-detail:hover {
      background-color: #45a049;
    }

    .btn-edit:hover {
      background-color: #e68900;
    }

    .btn-delete:hover {
      background-color: #d32f2f;
    }

    .btn-add:hover {
      background-color: #0069d9;
    }

    .pagination .page-item .page-link {
      color: #333;
    }

    .pagination .page-item.active .page-link {
      background-color: #4CAF50;
      border-color: #4CAF50;
      color: white;
    }

    .pagination .page-item:hover .page-link {
      background-color: #45a049;
      border-color: #45a049;
    }

    .table-wrapper {
      overflow-x: auto;
    }

    .btn-add-container {
      text-align: right;
      margin-bottom: 20px;
    }
    .custom-input {
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
    transition: all 0.3s ease; /* Smooth transition for focus */
  }

  .custom-input:focus {
    border-color: #0056b3; /* Change border color when focused */
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Highlight input with blue shadow */
    outline: none; /* Remove the default focus outline */
  }

  .form-label {
    font-weight: 600; /* Make labels bold */
    color: #333; /* Dark color for the label text */
  }

  .form-text.text-muted {
    font-size: 0.875rem; /* Slightly smaller text */
  }
  .custom-label {
    margin-left: 10px; /* Move the label slightly to the left */
    font-weight: 600; /* Bold label */
    color: #333; /* Dark color for label text */
  }

  .custom-input {
    border-radius: 2px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
    padding-left: 20px; /* Add space to the left of placeholder text */
    transition: all 0.3s ease; /* Smooth transition for focus */
  }

  .custom-input::placeholder {
    color: #999; /* Placeholder text color */
    font-size: 0.9rem; /* Slightly smaller font size */
  }

  .custom-input:focus {
    border-color: #0056b3; /* Border color on focus */
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Blue shadow on focus */
    outline: none; /* Remove default outline */
  }

  .form-text.text-muted {
    font-size: 0.875rem; /* Slightly smaller text */
  }

  </style>

<body class="g-sidenav-show  bg-gray-100">
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="../assets/img/gulur.jpg" class="navbar-brand-img" width="35%" height="50" alt="main_logo">
        <span class="ms-1 text-sm text-dark">GULURAN</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/data_product.php">
            <i class="material-symbols-rounded opacity-5">Box</i>
            <span class="nav-link-text ms-1">Data Product</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark " href="../pages/data_pesanan.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Data Pesanan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="../pages/laporan_penjualan.php">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Laporan Penjualan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/data_pengguna.php">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Data Pengguna</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/profile.html">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-Out.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign Out</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Laporan Penjualan</li>
          </ol>
        </nav>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Laporan Penjualan</h3>
        </div>
        </div>
      </div>
  <!-- Button to Add Product -->
  

  <!-- Table displaying products -->
  <div class="table-wrapper">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>ID Transaksi</th>
          <th>Tanggal</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Nama Pembeli</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td><img src="https://via.placeholder.com/50" alt="Produk 1" class="rounded-circle"></td>
          <td>ID-00016</td>
          <td>Smartphone</td>
          <td>Elektronik</td>
          <td>Rp 5.000.000</td>
          <td>50</td>
          <td>Selesai</td>
          <td class="action-btns">
            <button class="btn btn-detail"><i class="fas fa-eye"></i> Detail</button>
            <td class="action-btns">
            <button class="btn btn-detail" data-bs-toggle="modal" data-bs-target="#editConfirmModal"><i class="fas fa-edit"></i> Ubah</button>
            <button class="btn btn-delete" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"><i class="fas fa-trash"></i> Hapus</button>
          </td>
          </td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>

<!-- Modal Konfirmasi Edit -->
<div class="modal fade" id="editConfirmModal" tabindex="-1" aria-labelledby="editConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-black">
        <h5 class="modal-title" id="editConfirmModalLabel">Konfirmasi Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin mengedit data ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-warning" id="confirmEditBtn">Ya, Edit</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- Add custom styles -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success" id="saveProductBtn">Simpan</button>
      </div>
    </div>
  </div>
</div>
    </div>
  </main>
 
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!-- <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Views",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: [50, 45, 22, 28, 50, 60, 76],
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
          label: "Sales",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [4, 4]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script> -->
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>