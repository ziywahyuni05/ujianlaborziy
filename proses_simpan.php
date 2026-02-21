<?php
include('koneksi.php');

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Ambil nilai dari form
	$nama_produk = $_POST['nama_produk'];
	$deskripsi = $_POST['deskripsi'];
	$harga_beli = $_POST['harga_beli'];
	$harga_jual = $_POST['harga_jual'];
	
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
			// Query untuk menyimpan data
			$query = "INSERT INTO produk (nama_produk, deskripsi, harga_beli, harga_jual, gambar_produk) 
					  VALUES ('$nama_produk', '$deskripsi', '$harga_beli', '$harga_jual', '".basename($_FILES["gambar_produk"]["name"])."')";
			
			$result = mysqli_query($koneksi, $query);
			
			if ($result) {
				// Jika berhasil, redirect ke index.php
				header("Location: index.php");
				exit;
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
			}
		} else {
			echo "Maaf, terjadi kesalahan saat mengupload file.";
		}
	}
	
	mysqli_close($koneksi);
}
?>
