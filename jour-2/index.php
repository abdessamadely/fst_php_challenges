<?php
$title = 'Accueil';
$active = '/';

require __DIR__ . '/init.php';
require __DIR__ . '/includes/header.php';
?>

<section class="py-10">
    <h1 class="text-3xl font-bold">Une bibliothèque pour vous</h1>
</section>

<?php if (empty($_SESSION['auth'])):
    require __DIR__ . '/includes/login-section.php';
else: ?>

<?php endif; ?>

<?php
require __DIR__ . '/includes/footer.php';
?>