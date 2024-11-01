<div class="grid grid-cols-5 gap-3">
    <?php foreach ($books as $book): ?>
        <form class="flex flex-col justify-between bg-brand/10 border border-brand/50 rounded px-2 py-3" action="/actions/reserve.php" method="post">
            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

            <div class="mb-4 space-y-1.5">
                <h3 class="text-lg font-bold leading-snug text-zinc-700"><?= $book['title'] ?></h3>
                <div class="text-sm font-medium text-gray-600"><?= $book['genre'] ?></div>
            </div>
            <?php if (in_array($book['id'], RESERVED_BOOKS)): ?>
                <button class="bg-brand/50 font-medium text-sm rounded-sm px-2 py-1.5" disabled>Déjà réservé</button>
            <?php else: ?>
                <button class="bg-brand font-medium text-sm rounded-sm px-2 py-1.5" type="submit">Réserver maintenant</button>
            <?php endif; ?>
        </form>
    <?php endforeach; ?>
</div>