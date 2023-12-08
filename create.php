<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
    $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO mahasiswa VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $nama, $kelas, $jurusan]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create College</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="nama" id="nama">
        <label for="kelas">Kelas</label>
        <label for="jurusan">Jurusan</label>
        <input type="text" name="kelas" id="kelas">
        <input type="text" name="jurusan" id="jurusan">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>