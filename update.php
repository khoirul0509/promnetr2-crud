<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah id kontak ada, misalnya update.php?id=1 akan mendapatkan kontak dengan id 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Bagian ini mirip dengan create.php, tetapi kami memperbarui rekaman dan tidak menyisipkan
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $telepon = isset($_POST['telepon']) ? $_POST['telepon'] : '';
        $jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';
        $tgl = isset($_POST['tgl']) ? $_POST['tgl'] : date('Y-m-d');
        // Memperbarui catatan
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, nama = ?, email = ?, telepon = ?, jabatan = ?, tgl = ? WHERE id = ?');
        // var_dump($stmt); die();
        $stmt->execute([$id, $nama, $email, $telepon, $jabatan, $tgl, $_GET['id']]);
        $msg = 'Updated Successfully!';
        echo '<script>window.location.href = "read.php";</script>';
    }
    // Mendapatkan kontak dari tabel kontak
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
    <h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama">nama</label>
        <input type="text" name="id" placeholder="" value="<?=$contact['id']?>" id="id">
        <input type="text" name="nama" placeholder="" value="<?=$contact['nama']?>" id="nama">
        <label for="email">email</label>
        <label for="telepon">telepon</label>
        <input type="text" name="email" placeholder="" value="<?=$contact['email']?>" id="email">
        <input type="text" name="telepon" placeholder="" value="<?=$contact['telepon']?>" id="telepon">
        <label for="jabatan yang dilamar">jabatan yang dilamar</label>
        <label for="absen">absen</label>
        <input type="text" name="jabatan" placeholder="" value="<?=$contact['jabatan']?>" id="jabatan yang dilamar">
        <input type="date" name="tgl" value="<?php $contact['tgl'] ?>" id="Tanggal Melamar">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>