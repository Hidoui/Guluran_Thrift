<?php
$host           ="localhost";
$user           ="root";
$pass           ="";
$db             ="guluran_thrift";

$koneksi        = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("tidak bisa terkoneksi ke database");
}
$categories="";
$nama      ="";
$alamat    ="";
$celana    ="";
$cart      ="";
$sukses    ="";
$error     ="";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from Guluran_thrift where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
      $sukses   = "Berhasil hapus data";
    }else{
      $error    = "Gagal melakukan delete data";
    }
}

if($op == 'edit'){
    $id         = $_GET['id'];
    $sql1       = "select * from Guluran_thrift where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    $r1         = mysqli_fetch_array($q1);
    $categories = $r1['categories'];
    $nama       = $r1['nama'];
    $alamat     = $r1['alamat'];
    $celana     = $r1['celana'];

    if($categories == ''){
          $error = "Data tidak ditemukan";
    }


}


if(isset($_POST['simpan'])){ // untuk crate
    $categories   =$_POST['categories'];
    $nama         =$_POST['nama'];
    $alamat       =$_POST['alamat'];
    $celana       =$_POST['celana'];

    if($categories && $nama && $alamat && $celana){
      if($op == 'edit'){ // untuk update
          $sqli         = "update Guluran_thrift set categories = '$categories',nama='$nama',alamat='$alamat',celana='$celana' where id = '$id'";
          $q1           = mysqli_query($koneksi, $sql1);
          if($q1){
              $sukses = "Data berhasil di update";
          }else{
              $error  = "Gagal memasukan data";
          }
      }else{ // untuk insert
        $sql1 = "insert into thrift (categories,nama,alamat,celana) values ('$categories','$nama','$alamat','$celana')";
        $q1 = mysqli_query($koneksi,$sql1);
        if($qi){
          $sukses       ="Berhasil memasukan data baru";
        }else{
          $error        ="Gagal memasukan data";
        }
      }
        
      }else{
        $error = "Silahkan masukan semua data";
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
      .mx-auto{ width:800px }
      .card { margin-top:10px }
    </style>
  </head>

<body>
    
<div class="card">
  <div class="card-header text-white bg-secondary">
   create / Edit Data
  </div>
</div>

  <div class="card-body">
    <?php
    if($error){
        ?>
        <div class="alert alert-danger" role="alert">
              <?php echo $error ?>
        </div> 
      <?php
          header("refresh:5;url=index.php"); // 5 : detik
    }
    ?>
    <?php
    if($sukses){
        ?>
        <div class="alert alert-success" role="alert">
              <?php echo $sukses ?>
        </div> 
      <?php
          header("refresh:5;url=index.php");
    }
    ?>

   <form action=""method="POST">
   <div class="mb-3 row">
  <label for="categories" class="col-sm-2 col-form-label">CATEGORIES</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="categories" name="categories" value="<?php echo $categories?>">
  </div>
</div>
<div class="mb-3 row">
  <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama?>">
  </div>
</div>
<div class="mb-3 row">
  <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>">
  </div>
</div>
<div class="mb-3 row">
  <label for="" class="col-sm-2 col-form-label">CELANA</label>
  <div class="col-sm-10">
  <select class="form-control" name="celana" id="celana">
   <option value="">- PILIH KATEGORI CELANA -</option>
   <option value="JEANS"<?php if($celana == "JEANS") echo "selected"?>>JEANS</option>
   <option value="CARGO"<?php if($celana == "CARGO") echo "selected"?>>CARGO</option> 
  </select>
  </div>
</div>
<div class="mb-3 row">
  <label for="" class="col-sm-2 col-form-label">CART</label>
  <div class="col-sm-10">
  <select class="form-control" name="cart" id="cart">
   <option value="">- PILIH UKURAN CELANA -</option>
   <option value="S"<?php if($cart == "S") echo "selected"?>>S</option>
   <option value="M"<?php if($cart == "M") echo "selected"?>>M</option> 
  </select>
  </div>
</div>
<div class="col-12">
  <input type="submit" name="simpan" value="simpan data" class="btn btn-primary"

</div>
   </form>
  </div>
</div> 

  <!-- untuk mengeluarkan data-->
  <div class="card">
  <div class="card-header text-white bg-secondary">
   create / Edit Data
  </div>
</div>
<div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">CATEGORIES</th>
            <th scope="col">NAMA</th>
            <th scope="col">ALAMAT</th>
            <th scope="col">CELANA</th>
            <th scope="col">CART</th>
            <th scope="col">AKSI</th>
          </tr>
          <tbody>
              <?php
              $sql2   ="select * from Guluran_thrift orddr by id desc";
              $q2     =mysqli_query($koneksi,$sql2);
              $urut   = 1;
              while($r2 = mysqli_fetch_array($q2)){
                  $id           = $r2['id'];
                  $categories   = $r2['categories'];
                  $nama         = $r2['nama'];
                  $alamat       = $r2['alamat'];
                  $celana       = $r2['celana'];

                  ?>
                    <tr>
                        <th scope="row"><?php echo $urut++ ?></th>
                        <td scope="row"><?php echo $categories ?></td>
                        <td scope="row"><?php echo $nama ?></td>
                        <td scope="row"><?php echo $alamat ?></td>
                        <td scope="row"><?php echo $celana ?></td>
                        <td scope="row">
                        <a href="index.php?op=edit&id=<?php echo $id?>"> <button type="button" class="btn btn-warning">Edit</button></a>
                        <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"> <button type="button" class="btn btn-danger">Delete</button></a>
                        
                        </td>
                    </tr>
                  <?php
              }
              ?>
          </tbody>
        </thead>
      </table>
    </div>
  </div>
</div>     
</body>
</html>
