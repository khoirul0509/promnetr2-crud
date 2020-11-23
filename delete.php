<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah ID kontak ada
if (isset($_GET['id'])) {
    // Pilih catatan yang akan dihapus
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Pastikan pengguna mengonfirmasi penghapusan beore
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Pengguna mengklik tombol "Ya", hapus rekaman
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the contact!';
            echo '<script>window.location.href = "read.php";</script>';
        } else {
            // Pengguna mengklik tombol "Tidak", mengarahkan mereka kembali ke halaman baca
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete Contact #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Are you sure you want to delete contact #<?=$contact['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$contact['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>