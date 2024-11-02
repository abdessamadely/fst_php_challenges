<?php
$title = 'Populaire';
$active = '/populaire';
$show_reserved_times_notice = true;

require __DIR__ . '/init.php';
require __DIR__ . '/includes/header.php';

$books = get_popular_books($_SESSION['auth']['id'], '30 days', 100);
?>

<section class="py-10 space-y-8">
    <div>
        <h1 class="text-3xl font-bold">Livres populaires</h1>
        <p>Les plus réservés au cours des 30 derniers jours.</p>
    </div>

    <div class="space-y-8">
        <?php if (empty($books)): ?>
            <p>Aucun livre n'a été réservé au cours des 30 derniers jours.</p>

        <?php else: ?>
            <div class="grid grid-cols-3 gap-3">
                <?php require __DIR__ . '/includes/book-list.php' ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
require __DIR__ . '/includes/footer.php';
?>