<?php
//membuat koneksi
session_start();

$conn= mysqli_connect("localhost","root","","kasir");

if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi']; 
    $stock = $_POST['stock'];

   
    $addtomasuk = mysqli_query($conn,"INSERT INTO stock (namabarang, deskripsi, stock) VALUES ('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');

    } else {
        echo'gagal';
        header('location:index.php');
    }
};

//
if(isset($_POST['barangmasuk'])){
    $idbarang = $_POST['idbarang'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $stocksekarang = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$idbarang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO masuk (idbarang,keterangan,qty) VALUES ('$idbarang','$keterangan','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$idbarang'");
    if($addtomasuk&&$updatestockmasuk){
    header('location:masuk.php');
    } else {
    echo'gagal';
    header('location:masuk.php');
    }
};

if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $stocksekarang = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO keluar (idbarang,penerima,qty) VALUES ('$barangnya','$penerima',$qty)");
    $updatestockmasuk = mysqli_query($conn,"UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
    header('location:keluar.php');

    } else {
    echo'gagal';
    header('location:keluar.php');
    }
};

if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn,"UPDATE stock SET namabarang ='$namabarang', deskripsi ='$deskripsi' WHERE idbarang = '$idb'");
    if($update){
        header('location:index.php');
    } else {
    echo'gagal';
    header('location:index.php');
    }
    
};

if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];
   

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");   
     if($hapus){
        header('location:index.php');
    } else {
    echo'gagal';
    header('location:index.php');
    }
    
};

if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['deskripsi'];
    $qty=$_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from masuk where idmasuk ='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty',keterangan='$deskripsi' where idmasuk='$idm'"); 
        if ($kurangistocknya&&$updatenya) {
            header('location:masuk.php');
        } else {
            echo'gagal';
            header('location:masuk.php');
            
        }
    } else {
            $selisih = $qtyskrg-$qty;
            $kurangin = $stockskrg + $selisih;
            $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn,"update masuk set qty='$qty',keterangan='$deskripsi' where idmasuk='$idm'"); 
            if ($kurangistocknya&&$updatenya) {
                header('location:masuk.php');
            } else {
                echo'gagal';
                header('location:masuk.php');
                
            }

        };
    }

if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn,"update stock set stock ='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk ='$idm'");

    if ($update&&$hapusdata) {
        header('location:masuk.php');
    } else {
        echo'gagal';
        header('location:masuk.php');
    }

};
//ubah data keluar 
if (isset($_POST['updatebarangkeluar'])) {
    $idk = $_POST['idk'];
    $idm = $_POST['idm'];
    $penerima = $_POST['penerima'];
    $qty=$_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from keluar where idkeluar ='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk'"); 
        if ($kurangistocknya&&$updatenya) {
            header('location:masuk.php');
        } else {
            echo'gagal';
            header('location:masuk.php');
            
        }
    }   else{
            $selisih = $qtyskrg-$qty;
            $kurangin = $stockskrg + $selisih;
            $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn,"update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk'"); 
            if ($kurangistocknya&&$updatenya) {
                header('location:keluar.php');
            } 
            else {
                echo'gagal';
                header('location:keluar.php');
                
            }

        }

    }
    if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idbarang'];
    $qty = $_POST['kty'];
    $idk = $_POST['idkeluar'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock+$qty;

    $update = mysqli_query($conn,"update stock set stock ='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if ($update&&$hapusdata) {
        header('location:keluar.php');
    } else {
        echo'gagal';
        header('location:keluar.php');
    }

}
?>