<?php
include 'functions.php';
// Menyambungkan ke database MySQL
$pdo = pdo_connect_mysql();
// Dapatkan halaman melalui permintaan GET (URL param: halaman), jika tidak ada default halaman ke 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Jumlah rekaman yang akan ditampilkan di setiap halaman
$records_per_page = 5;
// Siapkan pernyataan SQL dan dapatkan catatan dari tabel kontak kami, LIMIT akan menentukan halaman
$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Ambil catatan sehingga kami dapat menampilkannya di templat kami.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Dapatkan jumlah total kontak, ini agar kami dapat menentukan apakah harus ada tombol berikutnya dan sebelumnya
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Contacts</h2>
	<a href="create.php" class="create-contact">Create Contact</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nama</td>
                <td>Email</td>
                <td>Telepon</td>
                <td>jabatan Yang Di Lamar</td>
                <td>Tanggal Melamar</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['id']?></td>
                <td><?=$contact['nama']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['telepon']?></td>
                <td><?=$contact['jabatan']?></td>
                <td><?=$contact['tgl']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$contact['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>