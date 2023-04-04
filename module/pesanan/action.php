<?php
include_once("../../function/koneksi.php");
include_once("../../function/helper.php");

session_start();

$pesanan_id  = $_GET['pesanan_id'];

// debugging koneksi database
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
} else {
    echo "Connected to database successfully.<br>";
}

// debugging query
$query = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE pesanan_id='$pesanan_id'");
if (!$query) {
    die("Query failed: " . mysqli_error($koneksi));
} else {
    echo "Query executed successfully.<br>";
}

$row = mysqli_fetch_assoc($query);
$button  = $_POST["button"];

if($button == "button" ){
    $user_id = $_SESSION["user_id"];
    $nomor_rekening = $_POST['nomor_rekening'];
    $nama_account = $_POST['nama_account'];
    $tanggal_transfer = $_POST['tanggal_transfer'];

    $queryPembayaran = mysqli_query ($koneksi, "INSERT INTO konfirmasi_pembayaran (pesanan_id, nomor_rekening, nama_account, tanggal_transfer)
    VALUES ('$pesanan_id', '$nomor_rekening', '$nama_account', '$tanggal_transfer')");

    if($queryPembayaran){
        mysqli_query($koneksi, "UPDATE pesanan SET status='1' WHERE pesanan_id='$pesanan_id'");
    }

} else if($button == "Edit Status"){
    $status = $_POST['status']; 

    mysqli_query($koneksi, "UPDATE pesanan SET status='$status' WHERE pesanan_id='$pesanan_id'");

    if($status == "2"){
        $query = mysqli_query($koneksi, "SELECT * FROM pesanan_detail WHERE pesanan_id='$pesanan_id'");
        // debugging query
        if (!$query) {
            die("Query failed: " . mysqli_error($koneksi));
        } else {
            echo "Query executed successfully.<br>";
        }

        while($row=mysqli_fetch_assoc($query)){
            $barang_id = $row["barang_id"];
            $quantity = $row["quantity"];

            mysqli_query($koneksi, "UPDATE barang SET stok= stok-$quantity WHERE barang_id='$barang_id'");
        }
    }
}

header("location:".BASE_URL."index.php?page=my_profile&module=pesanan&action=list");
exit();
?>
