<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Memeriksa apakah data POST tidak kosong
if (!empty($_POST)) {
    // Memposting data tidak kosong menyisipkan rekaman baru
    // Mengatur variabel yang akan dimasukkan, kita harus memeriksa apakah variabel POST ada jika tidak kita dapat default mereka kosong
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Periksa apakah variabel POST "name" ada, jika tidak default nilai kosong, pada dasarnya sama untuk semua variabel
    $name = isset($_POST['nama']) ? $_POST['nama'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['telepon']) ? $_POST['telepon'] : '';
    $title = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';
    $created = isset($_POST['tgl']) ? $_POST['tgl'] : date('Y-m-d H:i:s');
    // Menyisipkan catatan baru ke dalam tabel kontak
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $email, $phone, $title, $created]);
    // Pesan keluaran
    $msg = 'Created Successfully!';

    echo '<script>window.location.href = "read.php";</script>'; 
}
?>
<?=template_header('Create')?>

<div class="content update">
    <h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">nama</label>
        <input type="text" name="id" placeholder="id" value="" id="id">
        <input type="text" name="nama" placeholder="" id="nama">
        <label for="email">email</label>
        <label for="telepon">telepon</label>
        <input type="text" name="email" placeholder="" id="email">
        <input type="text" name="telepon" placeholder="" id="telepon">
        <label for="jabatan yang dilamar">jabatan Yang Di Lamar</label>
        <label for="Tanggal Melamar">Tanggal Melamar</label>
        <input type="text" name="jabatan">
        <input type="datetime-local" name="tgl" value="<?=date('Y-m-d h:i:s')?>">
        <input type="submit" value="Simpan">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>