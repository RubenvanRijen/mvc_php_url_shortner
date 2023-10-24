<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/head.php'; ?>
<body>
<?php include __DIR__ . '/header.php'; ?>

<?= $content ?? '' ?>

<?php include __DIR__ . '/footer.php'; ?>

</body>
<script defer type="module" src="/public/js/index.js"></script>
</html>