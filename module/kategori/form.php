<?php
// Define the $koneksi variable here

$kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : false;

$kategori = "";
$status = "off";
$button = "Add";

if ($kategori_id) {
    $queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kategori_id = '" . mysqli_real_escape_string($koneksi, $kategori_id) . "'");
    if (mysqli_num_rows($queryKategori) > 0) {
        $row = mysqli_fetch_assoc($queryKategori);
        $kategori = $row['kategori'];
        $status = $row['status'];
        $button = "Update";
    }
}
?>

<form action="<?php echo BASE_URL . 'module/kategori/action.php?kategori_id=' . urlencode($kategori_id); ?>" method="POST">
    <div class="element-form">
        <label>kategori</label>
        <span><input type="text" name="kategori" value="<?php echo htmlspecialchars($kategori); ?>" /></span>
    </div>

    <div class="element-form">
        <label>status</label>
        <span>
            <input type="radio" name="status" value="on" <?php if ($status == "on") { echo "checked='true'"; } ?> />on
            <input type="radio" name="status" value="off" <?php if ($status == "off") { echo "checked='true'"; } ?> />off
        </span>
    </div>

    <div class="element-form">
        <span>
            <input type="submit" name="button" value="<?php echo $button; ?>" />
        </span>
    </div>
</form>
