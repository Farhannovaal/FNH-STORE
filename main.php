<div id="kiri">
    <?php
        echo kategori($kategori_id);


    ?>

</div>


<div id="kanan">
    <div class="frame-barang">
        <ul>
        <?php

        if($kategori_id){

            $kategori_id = "AND barang.kategori_id='$kategori_id'";
        }
           $query=mysqli_query($koneksi, "SELECT barang.*, kategori.kategori FROM barang JOIN kategori ON barang.kategori_id=kategori.kategori_id WHERE barang.status='on' $kategori_id  ORDER BY rand() DESC LIMIT 9");

           $no=1;
            while($row=mysqli_fetch_assoc($query)){

                    $kategori = strtolower($row["kategori"]);
                    $barang = strtolower($row["nama_barang"]);
                    $barang = str_replace(" ","-", $barang);

                $style = false;
                if($no == 3){
                    $style ="style ='margin-right:0px'";
                    $no = 0;
                }


                echo "<li>
                    <p class='price'>".rupiah($row['harga']),"</p>
                    <a href='".BASE_URL."$row[barang_id]/$kategori/$barang.html'>
                        <img src='".BASE_URL."images/barang/$row[gambar]'/>
                    </a>
                    <div class='keterangan-gambar'>
                        <p><a href='".BASE_URL."$row[barang_id]/$kategori/$barang.html'>$row[nama_barang]</a></p>
                            <span> Stock :$row[stok]</span>

                            <div class='button-add-cart'>
                                <a href='".BASE_URL."tambah_keranjang.php?barang_id=$row[barang_id]'> + Add to Cart </a>
                            </div>
                    <div>    
                
                </li>";
            }
        ?>
        </ul>
                
    </div>
</div>
