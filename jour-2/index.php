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

                    <div class="grid grid-cols-4 gap-3">
                        <?php foreach ($books as $book): ?>
                            <form class="flex flex-col justify-between bg-brand/10 border border-brand/50 rounded px-2 py-3" action="" method="post">
                                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                <div class="mb-4 space-y-1.5">
                                    <h3 class="text-lg font-bold leading-snug text-zinc-700"><?= $book['title'] ?></h3>
                                    <div class="text-sm font-medium text-gray-600"><?= $book['genre'] ?></div>
                                </div>
                                <button class="bg-brand font-medium text-sm rounded-sm px-2 py-1.5" type="submit">Réserver maintenant</button>
                            </form>
                        <?php endforeach; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>

<?php
require __DIR__ . '/includes/footer.php';
?>