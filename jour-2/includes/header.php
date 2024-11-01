<?php
$menu = [
    ['name' => 'Accueil', 'link' => '/', 'active' => $active === '/'],
];

if (LOGGED_IN) {
    $menu[] = ['name' => 'Pour vous', 'link' => '/pour-vous.php', 'active' => $active === '/pour-vous'];
    $menu[] = ['name' => 'Populaire', 'link' => '/populaire.php', 'active' => $active === '/populaire'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Accueil' ?> | Livre & Moi</title>
    <link rel="stylesheet" href="/index.css">
    <link rel="icon" href="/assets/favicon.svg">
</head>

<body>
    <header class="py-3 border-b border-gray-200">
        <div class="w-full max-w-5xl mx-auto">
            <div class="flex items-center justify-between">
                <a href="/">
                    <img class="h-6 w-auto" src="/assets/livre-et-moi.svg" width="87" height="16" />
                </a>
                <nav class="flex items-center space-x-3">
                    <?php foreach ($menu as $item): ?>
                        <div class="<?= $item['active'] ? 'bg-black ' : '' ?> px-2.5 py-1.5">
                            <a class="<?= $item['active'] ? 'text-brand font-bold' : '' ?>" href="<?= $item['link'] ?>"><?= $item['name'] ?></a>
                        </div>
                    <?php endforeach; ?>
                    <?php if (LOGGED_IN): ?>
                        <form action="/logout.php" method="post">
                            <button class="px-2.5 py-1.5 text-sm font-bold"><span class="text-brand">|</span> Se Déconnecter</button>
                        </form>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <div class="w-full max-w-5xl mx-auto py-3">