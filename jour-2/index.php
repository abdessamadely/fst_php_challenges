<?php
$title = 'Accueil';
$active = '/';

require __DIR__ . '/init.php';
require __DIR__ . '/includes/header.php';
?>


<?php if (empty($_SESSION['auth'])): ?>
    <section class="py-10">
        <h1 class="text-3xl font-bold">Une bibliothèque</h1>
    </section>
<?php
    require __DIR__ . '/includes/login-section.php';
else: ?>
    <section class="py-10 space-y-8">
        <h1 class="text-3xl font-bold">Tous les livres</h1>

        <div class="space-y-8">
            <?php foreach (get_grouped_books() as $char => $books):
                if (empty($books)) {
                    continue;
                } ?>
                <div class="space-y-4">
                    <h2 class="text-xl uppercase"><strong><?= $char ?></strong> (<?= count($books) ?>)</h2>
                    <div class="grid grid-cols-5 gap-3">
                        <?php require __DIR__ . '/includes/book-list.php' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>

<?php
require __DIR__ . '/includes/footer.php';
?>