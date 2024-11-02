<?php
$title = 'Pour vous';
$active = '/pour-vous';

require __DIR__ . '/init.php';
require __DIR__ . '/includes/header.php';

$suggested_books = get_suggested_books($_SESSION['auth']['id']);
?>

<section class="py-10 space-y-8">
    <h1 class="text-3xl font-bold">Livres sélectionnés pour vous</h1>

    <div class="space-y-8">
        <?php if (empty($suggested_books)): ?>
            <p>Veuillez réserver quelques livres pour calculer votre suggestion.</p>

            <?php else:  foreach ($suggested_books as $item):
                $genre = $item['genre'];
                $books = $item['books'];
                $reserved_times = $item['reserved_times'];

                if (empty($books)) {
                    continue;
                }
            ?>
                <div class="space-y-4">
                    <div>
                        <h2 class="text-xl font-bold"><?= $genre ?></h2>
                        <p class="text-sm">Vous avez réservé <?= $reserved_times ?> livres dans ce genre.</p>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <?php require __DIR__ . '/includes/book-list.php' ?>
                    </div>
                </div>
        <?php endforeach;
        endif; ?>
    </div>
</section>

<?php
require __DIR__ . '/includes/footer.php';
?>