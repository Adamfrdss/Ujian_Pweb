<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ujian";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Create - Menambahkan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $umur = $_POST['umur'];
    
    $sql = "INSERT INTO biodata (nama, email, umur) VALUES ('$nama', '$email', '$umur')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Read - Membaca data
$sql = "SELECT * FROM biodata";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Nama: " . $row["nama"]. " - Email: " . $row["email"]. " - Umur: " . $row["umur"]. "<br>";
    }
} else {
    echo "0 hasil";
}

// Update - Memperbarui data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $idToUpdate = $_POST['id_to_update'];
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];
    $newUmur = $_POST['new_umur'];
    
    $sql = "UPDATE biodata SET nama='$newName', email='$newEmail', umur='$newUmur' WHERE id='$idToUpdate'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete - Menghapus data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $idToDelete = $_POST['id_to_delete'];
    
    $sql = "DELETE FROM biodata WHERE id='$idToDelete'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Form untuk menambahkan data baru
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Nama: <input type="text" name="nama"><br>
    Email: <input type="text" name="email"><br>
    Umur: <input type="text" name="umur"><br>
    <input type="submit" name="submit" value="Tambah Data">
</form>

<hr>

<!-- Form untuk mengupdate data -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    ID Data yang ingin diupdate: <input type="text" name="id_to_update"><br>
    Nama Baru: <input type="text" name="new_name"><br>
    Email Baru: <input type="text" name="new_email"><br>
    Umur Baru: <input type="text" name="new_umur"><br>
    <input type="submit" name="update" value="Update Data">
</form>

<hr>

<!-- Form untuk menghapus data -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    ID Data yang ingin dihapus: <input type="text" name="id_to_delete"><br>
    <input type="submit" name="delete" value="Hapus Data">
</form>

<?php
$conn->close();
?>
