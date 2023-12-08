<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
        $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE mahasiswa SET id = ?, nama = ?, kelas = ?, jurusan = ? WHERE id = ?');
        $stmt->execute([$id, $nama, $kelas, $jurusan, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $college = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$college) {
        exit('College doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update College #<?=$college['id']?></h2>
    <form action="update.php?id=<?=$college['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="<?=$college['id']?>" id="id">
        <input type="text" name="nama" value="<?=$college['nama']?>" id="nama">
        <label for="kelas">Kelas</label>
        <label for="jurusan">Jurusan</label>
        <input type="text" name="kelas" value="<?=$college['kelas']?>" id="kelas">
        <input type="text" name="jurusan" value="<?=$college['jurusan']?>" id="jurusan">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>