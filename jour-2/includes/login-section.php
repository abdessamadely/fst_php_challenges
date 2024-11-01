<?php
$users = $conn->query('SELECT * FROM users;')->fetch_all(MYSQLI_ASSOC);
?>

<section class="p-10 space-y-10 bg-brand/30">
    <h2 class="text-2xl font-bold">Pour utilise Livre & Moi, connecter avec un utilisateur</h2>

    <form class="bg-white space-y-5 p-4" action="/login.php" method="post">
        <div class="space-y-4">
            <h3 class="text-xl font-bold">Sélectionnez un utilisateur pour continuer</h3>

            <div class="flex flex-wrap gap-1.5">
                <?php foreach ($users as $user): ?>
                    <label class="flex-grow flex items-center space-x-3 rounded bg-brand/75 border border-brand/40 p-1">
                        <input required type="radio" name="user_id" value="<?= $user['id'] ?>">
                        <span class="whitespace-nowrap"><?= $user['name'] ?></span>
                    </label>
                <?php endforeach ?>
            </div>
        </div>

        <div>
            <button class="bg-black text-brand font-medium p-3" type="submit">Se connecter</button>
        </div>
    </form>
</section>