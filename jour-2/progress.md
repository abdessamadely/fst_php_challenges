
2. Étape 1 : Analyse des Préférences de Lecture de l’Utilisateur

Lorsque l'utilisateur réserve un livre, l'algorithme doit :

Enregistrer le genre du livre dans les préférences utilisateur.

Compter le nombre de livres réservés par genre pour chaque utilisateur.

Code PHP (exemple de logique de calcul des préférences) :

function getUserPreferences($userId, $db) {
    $query = "
        SELECT books.genre, COUNT(*) as count
        FROM reservations
        INNER JOIN books ON reservations.id_book = books.id
        WHERE reservations.id_user = :userId
        GROUP BY books.genre
        ORDER BY count DESC;
    ";
    $stmt = $db->prepare($query);
$stmt->execute(['userId' => $userId]);
return $stmt->fetchAll(PDO::FETCH_ASSOC); // Renvoie les genres préférés avec un décompte
}

3. Étape 2 : Calcul de la Liste de Suggestions

Basé sur les genres favoris de l'utilisateur et les livres populaires, suggérer des livres pertinents.

1. Suggestions par Genre Favori :

Pour chaque genre favori de l'utilisateur, sélectionner les livres correspondants qui ne sont pas dans son historique de réservations.

2. Suggestions Basées sur la Popularité :

En plus des préférences de l’utilisateur, intégrer les livres populaires (les plus réservés du mois).

Code PHP (exemple de logique pour générer les suggestions)

function suggestBooks($userId, $db) {
    // Obtenir les genres préférés de l'utilisateur
    $userPreferences = getUserPreferences($userId, $db);
$suggestedBooks = [];

    // Suggérer des livres pour chaque genre préféré
    foreach ($userPreferences as $preference) {
        $genre = $preference['genre'];

        $query = "
            SELECT * FROM books
            WHERE genre = :genre
            AND id NOT IN (
                SELECT id_book FROM reservations WHERE id_user = :userId
            )
            ORDER BY popularity_score DESC
            LIMIT 5;
        ";
        $stmt = $db->prepare($query);
        $stmt->execute(['genre' => $genre, 'userId' => $userId]);

        $suggestedBooks = array_merge($suggestedBooks, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Ajouter les livres populaires dans la liste de suggestions (hors livres déjà réservés par l’utilisateur)
    $popularQuery = "
        SELECT * FROM books
        WHERE id NOT IN (SELECT id_book FROM reservations WHERE id_user = :userId)
        ORDER BY popularity_score DESC
        LIMIT 5;
    ";
    $popularStmt = $db->prepare($popularQuery);
    $popularStmt->execute(['userId' => $userId]);

    $suggestedBooks = array_merge($suggestedBooks, $popularStmt->fetchAll(PDO::FETCH_ASSOC));

    return $suggestedBooks;

}

4. Étape 3 : Amélioration de l’Efficacité

Indexation des Tables : Assurez-vous que les colonnes id, id_user, id_book, et genre sont bien indexées.

Mise à Jour du Score de Popularité : Mettre à jour les scores de popularité une fois par jour ou par semaine pour éviter de recalculer à chaque réservation.

5. Étape 4 : Interface Utilisateur et Affichage des Suggestions

1. Sur la page d’accueil de chaque utilisateur, afficher une section de "Suggestions pour Vous" avec les livres recommandés.

1. Pour chaque livre suggéré, afficher le titre, le genre, et un bouton "Réserver maintenant".

1. Documentation et Explication de l’Approche

Chaque étudiant doit fournir une courte documentation expliquant les choix d'algorithme et les mesures prises pour optimiser le code.

---

Critères d’Évaluation :

1. Pertinence des Suggestions : Les livres proposés doivent correspondre aux genres favoris de l'utilisateur.

2. Optimisation et Rapidité : L’algorithme doit être capable de gérer efficacement une grande base de données sans ralentir.

3. Qualité du Code : Utilisation de bonnes pratiques PHP, organisation modulaire, et clarté du code.

4. Explication et Justification de l'Approche : Documentation claire expliquant la logique de l’algorithme.
