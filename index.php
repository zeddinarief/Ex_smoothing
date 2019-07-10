<?php
session_start();
include 'db.php';
$db= new db();
include 'exponential_smoothing.php';
$exponentialSmoothing= new exponential_smoothing($db);
$page='home.php';
$result=NULL;
if(isset($_GET['page'])){
    include "view/alert.php";
    if(isset($_GET['prediksi']) && $_GET['prediksi']=="single"){
        if(isset($_POST['alpha'])){
            $alpha=$_POST['alpha'];
            $bulan=$_POST['bulan'];
            $result=$exponentialSmoothing->doSingleSmoothing($alpha,$bulan);
        }else{
            $_SESSION['alert']=error('Perhitungan Gagal, harap masukkan input yg dibutuhkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }else if(isset($_GET['prediksi']) && $_GET['prediksi']=="double"){
        // echo "double";die();
        if(isset($_POST['alpha'])){
            $alpha=$_POST['alpha'];
            $bulan=$_POST['bulan'];
            $result=$exponentialSmoothing->doDoubleSmoothing($alpha,$bulan);
        }else{
            $_SESSION['alert']=error('Perhitungan Gagal, harap masukkan input yg dibutuhkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }else if(isset($_GET['prediksi']) && $_GET['prediksi']=="triple"){
        if(isset($_POST['alpha']) && isset($_POST['beta']) && isset($_POST['gamma'])){
            $alpha=$_POST['alpha'];
            $beta=$_POST['beta'];
            $gamma=$_POST['gamma'];
            $bulan=$_POST['bulan'];
            $result=$exponentialSmoothing->doTripleSmoothing($alpha,$beta,$gamma,$bulan);
        }else{
            $_SESSION['alert']=error('Perhitungan Gagal, harap masukkan input yg dibutuhkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }
    if(isset($_GET['pengujian']) && $_GET['pengujian']=="single"){
        if(isset($_POST['alpha'])){
            $alpha=$_POST['alpha'];
            $result=$exponentialSmoothing->doMapeSingleSmoothing($alpha);
        }else{
            $_SESSION['alert']=error('Perhitungan Gagal, harap masukkan input yg dibutuhkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }else if(isset($_GET['pengujian']) && $_GET['pengujian']=="double"){
        // echo "double";die();
        if(isset($_POST['alpha'])){
            $alpha=$_POST['alpha'];
            $result=$exponentialSmoothing->doMapeDoubleSmoothing($alpha);
        }else{
            $_SESSION['alert']=error('Perhitungan Gagal, harap masukkan input yg dibutuhkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }else if(isset($_GET['pengujian']) && $_GET['pengujian']=="triple"){
        if(isset($_POST['alpha']) && isset($_POST['beta']) && isset($_POST['gamma'])){
            $alpha=$_POST['alpha'];
            $beta=$_POST['beta'];
            $gamma=$_POST['gamma'];
            $result=$exponentialSmoothing->doMapeTripleSmoothing($alpha,$beta,$gamma);
        }else{
            $_SESSION['alert']=error('Perhitungan Gagal, harap masukkan input yg dibutuhkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }
    if(isset($_GET['delete'])){
        $id=$_GET['delete'];
        $delete=$db->deleteData($_GET['page'],$id);
        if($delete){
            $_SESSION['alert']=success('Data Berhasil Dihapus');
            header("Location: ?page=".$_GET['page']);
            die();
        }else{
            $_SESSION['alert']=error('Gagal Hapus Data');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }
    if(isset($_GET['add'])){
        if(isset($_POST['input_tgl'])){
            $data['tgl']=$_POST['input_tgl'];
        }
        if(isset($_POST['input_hasil_penjualan'])){
            $data['hasil_penjualan']=$_POST['input_hasil_penjualan'];
        }
        $add=$db->addData($_GET['page'],$data);
        if($add){
            $_SESSION['alert']=success('Data Berhasil Ditambahkan');
            header("Location: ?page=".$_GET['page']);
            die();
        }else{
            $_SESSION['alert']=error('Gagal Tambah Data');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }
    if(isset($_GET['edit'])){
        if(isset($_POST['input_tgl'])){
            $data['tgl']=$_POST['input_tgl'];
        }
        if(isset($_POST['input_hasil_penjualan'])){
            $data['hasil_penjualan']=$_POST['input_hasil_penjualan'];
        }
        $edit=$db->editData($_GET['page'],$data,$_GET['edit']);
        if($edit){
            $_SESSION['alert']=success('Update Data Berhasil');
            header("Location: ?page=".$_GET['page']);
            die();
        }else{
            $_SESSION['alert']=error('Gagal Update Data');
            header("Location: ?page=".$_GET['page']);
            die();
        }
    }
    $page=$_GET['page'].".php";
}
include "view/base.php";

// echo json_encode($singleSmoothingResult);
// $doubleSmoothingResult=$exponentialSmoothing->doDoubleSmoothing();
// $tripleSmoothingResult=$exponentialSmoothing->doTripleSmoothing();
?>