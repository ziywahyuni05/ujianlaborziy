<?php
include('koneksi.php');

// Cek apakah id ada
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	
	// Pertama, ambil nama gambar produk
	$query_get_gambar = "SELECT gambar_produk FROM produk WHERE id = $id";
	$result_get_gambar = mysqli_query($koneksi, $query_get_gambar);
	
	if (mysqli_num_rows($result_get_gambar) > 0) {
		$row = mysqli_fetch_assoc($result_get_gambar);
		$gambar_produk = $row['gambar_produk'];
		
		// Hapus data dari database
		$query = "DELETE FROM produk WHERE id = $id";
		$result = mysqli_query($koneksi, $query);
		
		if ($result) {
			// Hapus file gambar jika ada
			$target_dir = "gambar/";
			if (file_exists($target_dir . $gambar_produk) && $gambar_produk != "") {
				unlink($target_dir . $gambar_produk);
			}
			
			// Redirect ke index.php
			header("Location: index.php");
			exit;
		} else {
			echo "Error deleting record: " . mysqli_error($koneksi);
		}
	} else {
		echo "Data tidak ditemukan.";
	}
} else {
	echo "ID tidak tersedia.";
}

mysqli_close($koneksi);
?>
