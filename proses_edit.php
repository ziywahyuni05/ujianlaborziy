<?php
include('koneksi.php');

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Ambil nilai dari form
	$id = $_POST['id'];
	$nama_produk = $_POST['nama_produk'];
	$deskripsi = $_POST['deskripsi'];
	$harga_beli = $_POST['harga_beli'];
	$harga_jual = $_POST['harga_jual'];
	$gambar_lama = $_POST['gambar_lama'];
	
	// Default gambar yang akan digunakan
	$gambar_produk = $gambar_lama;
	
	// Cek apakah ada file gambar baru diupload
	if ($_FILES["gambar_produk"]["name"] != "") {
		// Proses upload gambar
		$target_dir = "gambar/";
		$target_file = $target_dir . basename($_FILES["gambar_produk"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		
		// Cek apakah file adalah gambar
		$check = getimagesize($_FILES["gambar_produk"]["tmp_name"]);
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			echo "File bukan gambar.";
			$uploadOk = 0;
		}
		
		// Cek jika $uploadOk adalah 0
		if ($uploadOk == 0) {
			echo "Maaf, file tidak berhasil diupload.";
		} else {
			// Coba upload file
			if (move_uploaded_file($_FILES["gambar_produk"]["tmp_name"], $target_file)) {
				// Hapus gambar lama jika ada
				if (file_exists($target_dir . $gambar_lama) && $gambar_lama != "") {
					unlink($target_dir . $gambar_lama);
				}
				$gambar_produk = basename($_FILES["gambar_produk"]["name"]);
			} else {
				echo "Maaf, terjadi kesalahan saat mengupload file.";
			}
		}
	}
	
	// Query untuk mengupdate data
	$query = "UPDATE produk SET 
			  nama_produk = '$nama_produk', 
			  deskripsi = '$deskripsi', 
			  harga_beli = '$harga_beli', 
			  harga_jual = '$harga_jual', 
			  gambar_produk = '$gambar_produk' 
			  WHERE id = $id";
	
	$result = mysqli_query($koneksi, $query);
	
	if ($result) {
		// Jika berhasil, redirect ke index.php
		header("Location: index.php");
		exit;
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
	}
	
	mysqli_close($koneksi);
}
?>
