<!doctype html>
<html lang="pl">
<?php require __DIR__ . '/includes/head.php'; ?>

<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<?php
if (isset($contentFileVar) && is_file($contentFileVar)) {
  include $contentFileVar;
} else {
  echo '<p>Brak zawartości</p>';
}
?>

<?php require __DIR__ . '/includes/scripts.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>

