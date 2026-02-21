<?php
include('koneksi.php');

// Cek apakah id ada
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	
	// Query untuk mengambil data produk
	$query = "SELECT * FROM produk WHERE id = $id";
	$result = mysqli_query($koneksi, $query);
	
	// Cek apakah data ditemukan
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$nama_produk = $row['nama_produk'];
		$deskripsi = $row['deskripsi'];
		$harga_beli = $row['harga_beli'];
		$harga_jual = $row['harga_jual'];
		$gambar_produk = $row['gambar_produk'];
	} else {
		echo "Data tidak ditemukan.";
		exit;
	}
} else {
	echo "ID tidak tersedia.";
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Produk - UKK SMK Maritim Nusantara 2022</title>
<style type="text/css">
* {
	font-family: "Trebuchet MS";
}
h1 {
	text-transform: uppercase;
	color: salmon;
}
button {
	background-color: salmon;
	color: #fff;
	padding: 10px;
	text-decoration: none;
	font-size: 12px;
	border: 0px;
	margin-top: 20px;
}
label {
	margin-top: 10px;
	float: left;
	text-align: left;
	width: 100%;
}
input, textarea {
	padding: 6px;
	width: 100%;
	box-sizing: border-box;
	background: #f8f8f8;
	border: 2px solid #ccc;
	outline-color: salmon;
}
textarea {
	resize: vertical;
	height: 100px;
}
div {
	width: 100%;
	height: auto;
}
.base {
	width: 400px;
	height: auto;
	padding: 20px;
	margin-left: auto;
	margin-right: auto;
	background: #ededed;
}
.gambar-lama {
	margin-top: 10px;
}
.gambar-lama img {
	width: 150px;
	border: 2px solid #ccc;
}
</style>
</head>
<body>
	<?php include "menu.php"; ?>
	<center>
		<h1>Edit Produk</h1>
	</center>
	<form method="POST" action="proses_edit.php" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="hidden" name="gambar_lama" value="<?php echo $gambar_produk; ?>">
		<section class="base">
			<div>
				<label>Nama Produk</label>
				<input type="text" name="nama_produk" value="<?php echo $nama_produk; ?>" autofocus="" required="" />
			</div>
			<div>
				<label>Deskripsi</label>
				<textarea name="deskripsi"><?php echo $deskripsi; ?></textarea>
			</div>
			<div>
				<label>Harga Beli</label>
				<input type="number" name="harga_beli" value="<?php echo $harga_beli; ?>" required="" />
			</div>
			<div>
				<label>Harga Jual</label>
				<input type="number" name="harga_jual" value="<?php echo $harga_jual; ?>" required="" />
			</div>
			<div>
				<label>Gambar Produk</label>
				<div class="gambar-lama">
					<img src="gambar/<?php echo $gambar_produk; ?>" alt="Gambar Produk">
					<p>Gambar saat ini</p>
				</div>
				<input type="file" name="gambar_produk" />
				<p style="font-size: 12px; color: #666;">Kosongkan jika tidak ingin mengubah gambar</p>
			</div>
			<div>
				<button type="submit">Update Produk</button>
			</div>
		</section>
	</form>
</body>
</html>
