<?php
session_start();
include 'includes/database.php';
/*
// Afficher les messages de succès/erreur
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">'.$_SESSION['success_message'].'</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['error_message'].'</div>';
    unset($_SESSION['error_message']);
}
*/
// Requête pour obtenir la liste des restaurants avec leurs notes moyennes
$sql_restaurant = "SELECT r.*,
    (SELECT AVG(nbre_etoiles) FROM avis WHERE id_restaurant = r.id_restaurant) as note_moyenne,
    (SELECT COUNT(*) FROM avis WHERE id_restaurant = r.id_restaurant) as nombre_avis
    FROM restaurant r";
$stmt_restaurant = $pdo->query($sql_restaurant);
$restaurants = $stmt_restaurant->fetchAll(PDO::FETCH_ASSOC);

// Requête pour obtenir la liste des utilisateurs
$sql_users = "SELECT u.*,
    (SELECT COUNT(*) FROM avis WHERE id_user = u.id_user) as nombre_avis
    FROM utilisateur u";
$stmt_users = $pdo->query($sql_users);
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Requête pour obtenir la liste des avis avec les informations des restaurants et utilisateurs
$sql_avis = "SELECT a.*,
    r.nom as nom_restaurant,
    CONCAT(u.nom, ' ', u.prenom) as nom_utilisateur
    FROM avis a
    JOIN restaurant r ON a.id_restaurant = r.id_restaurant
    JOIN utilisateur u ON a.id_user = u.id_user
    ORDER BY a.id_avis DESC";
$stmt_avis = $pdo->query($sql_avis);
$avis = $stmt_avis->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Restaurants</title>
  <link rel="stylesheet" href="dash.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
      <div class="logo">
        <img src="assets/images/logo.png" class="icon" alt="icon"></img>
        <span>Admin panel</span>
      </div>
      <ul class="nav-links">
        <li class="active" data-target="users">
          <a href="#users">
            <i class="fas fa-users"></i>
            <span>Utilisateurs</span>
          </a>
        </li>
        <li data-target="restaurants">
          <a href="#restaurants">
            <i class="fas fa-store"></i>
            <span>Restaurants</span>
          </a>
        </li>
        <li data-target="reviews">
          <a href="#reviews">
            <i class="fas fa-star"></i>
            <span>Avis</span>
          </a>
        </li>
        <li data-target="add-restaurant">
          <a href="#add-restaurant">
            <i class="fas fa-plus-circle"></i>
            <span>Ajouter Restaurant</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Main Content Area -->
    <main class="content">
      <!-- Users Section -->
      <section id="users" class="section active">
        <div class="section-header">
          <h2>Liste des Utilisateurs</h2>
          <div class="search-container">
            <input type="text" id="user-search" placeholder="Rechercher un utilisateur...">
            <i class="fas fa-search"></i>
          </div>
        </div>
        <div class="table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($users as $user): ?>
              <tr>
                  <td><?= htmlspecialchars($user['id_user']) ?></td>
                  <td><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td class="actions">
                     
                      <button class="btn-icon delete-user" data-id="<?= htmlspecialchars($user['id_user']) ?>"><i class="fas fa-trash"></i></button>
                  </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="pagination">
          <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
          <button class="btn-page active">1</button>
          <button class="btn-page">2</button>
          <button class="btn-page">3</button>
          <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
        </div>
      </section>

      <!-- Restaurants Section -->
      <section id="restaurants" class="section">
        <div class="section-header">
          <h2>Liste des Restaurants</h2>
          <div class="search-container">
            <input type="text" id="restaurant-search" placeholder="Rechercher un restaurant...">
            <i class="fas fa-search"></i>
          </div>
        </div>
        <div class="table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Adresse</th>
                <th>Note moyenne</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dans la section restaurants -->
<tbody>
    <?php foreach ($restaurants as $restaurant): ?>
    <tr>
        <td><?= htmlspecialchars($restaurant['id_restaurant']) ?></td>
        <td><?= htmlspecialchars($restaurant['nom']) ?></td>
        <td><?= htmlspecialchars($restaurant['categorie']) ?></td>
        <td><?= htmlspecialchars($restaurant['localisation']) ?></td>
        <td>
            <div class="rating">
                <?php
                $note = $restaurant['note_moyenne'] !== null ? round($restaurant['note_moyenne'], 1) : 0;
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $note) {
                        echo '<i class="fas fa-star"></i>';
                    } elseif ($i - 0.5 <= $note) {
                        echo '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                ?>
                <span><?= number_format($note, 1) ?></span>
            </div>
        </td>
        <td class="actions">
            <button class="btn-icon edit-restaurant" data-id="<?= htmlspecialchars($restaurant['id_restaurant']) ?>"><i class="fas fa-edit"></i></button>
            <button class="btn-icon delete-restaurant" data-id="<?= htmlspecialchars($restaurant['id_restaurant']) ?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
          </table>
        </div>
        <div class="pagination">
          <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
          <button class="btn-page active">1</button>
          <button class="btn-page">2</button>
          <button class="btn-page">3</button>
          <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
        </div>
      </section>

      <!-- Reviews Section -->
      <section id="reviews" class="section">
        <div class="section-header">
          <h2>Liste des Avis</h2>
          <div class="search-container">
            <input type="text" id="review-search" placeholder="Rechercher un avis...">
            <i class="fas fa-search"></i>
          </div>
        </div>
        <div class="table-container">
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Restaurant</th>
                <th>Note</th>
                <th>Commentaire</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dans la section avis -->
              <tbody>
                <?php foreach ($avis as $avis_item): ?>
                <tr>
                    <td><?= htmlspecialchars($avis_item['id_avis']) ?></td>
                    <td><?= htmlspecialchars($avis_item['nom_utilisateur']) ?></td>
                    <td><?= htmlspecialchars($avis_item['nom_restaurant']) ?></td>
                    <td>
                        <div class="rating">
                            <?php
                            $note = $avis_item['nbre_etoiles'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $note) {
                                    echo '<i class="fas fa-star"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span><?= $note ?></span>
                        </div>
                    </td>
                    <td class="comment"><?= htmlspecialchars($avis_item['contenu']) ?></td>
                    <td><?= isset($avis_item['date_creation']) ? date('d/m/Y', strtotime($avis_item['date_creation'])) : 'N/A' ?></td>
                    <td class="actions">
                        <button class="btn-icon edit-avis" data-id="<?= htmlspecialchars($avis_item['id_avis']) ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon delete-avis" data-id="<?= htmlspecialchars($avis_item['id_avis']) ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </tbody>
          </table>
        </div>
        <div class="pagination">
          <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
          <button class="btn-page active">1</button>
          <button class="btn-page">2</button>
          <button class="btn-page">3</button>
          <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
        </div>
      </section>

      <!-- Add Restaurant Section -->
      <!-- Ajoutez ceci juste après l'ouverture de la section add-restaurant -->
      <section id="add-restaurant" class="section">
          <div class="section-header">
              <h2>Ajouter un Restaurant</h2>
              <?php if (isset($_GET['success'])): ?>
                  <div class="alert alert-success">Restaurant ajouté avec succès!</div>
              <?php endif; ?>
              <?php if (isset($_GET['error'])): ?>
                  <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
              <?php endif; ?>
          </div>
          <div class="form-container">
            <form id="restaurant-form" action="restaurant-add.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="restaurant-name">Nom du Restaurant/café</label>
                <input type="text" id="restaurant-name" name="nom" required>
              </div>

              <div class="form-group">
                <label for="restaurant-location">Localisation</label>
                <input type="text" id="restaurant-location" name="localisation" required>
              </div>

              <div class="form-group">
                <label for="restaurant-category">entrer une catégorie</label>
                <input id="restaurant-category" name="categorie" required>

              </div>

              <div class="form-group">
                <label for="restaurant-description">Description</label>
                <input id="restaurant-description" name="description" rows="4" required>
              </div>

              <div class="form-group">
                <label for="restaurant-image">Image du Restaurant/café</label>
                  <input type="text" id="restaurant-image" name="image_url" >
                </div>


              <div class="form-actions">
                <button type="reset" class="btn btn-secondary">Annuler</button>
                <button type="submit" class="btn btn-primary">Ajouter Restaurant</button>
              </div>
            </form>
          </div>
        </section>
    </main>
  </div>

  <script src="dash.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la suppression d'utilisateur
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                const userId = this.getAttribute('data-id');
                fetch('includes/delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_user=' + userId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.closest('tr').remove();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                });
            }
        });
    });

    // Removed edit-user event handler

    // Gestion de la modification d'utilisateur
    document.querySelectorAll('.edit-user').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            const fullName = row.querySelector('td:nth-child(2)').textContent;
            const email = row.querySelector('td:nth-child(3)').textContent;

            // Séparer le nom et le prénom
            const nameParts = fullName.trim().split(' ');
            const nom = nameParts[0] || '';
            const prenom = nameParts.slice(1).join(' ') || '';

            // Remplir le formulaire de modification
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-user-nom').value = nom;
            document.getElementById('edit-user-prenom').value = prenom;
            document.getElementById('edit-user-email').value = email;

            // Afficher le modal de modification
            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        });
    });

    // Gestion de la suppression de restaurant
    document.querySelectorAll('.delete-restaurant').forEach(button => {
        button.addEventListener('click', function() {
            if(confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?')) {
                const restaurantId = this.getAttribute('data-id');
                fetch('includes/delete_restaurant.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_restaurant=' + restaurantId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.closest('tr').remove();
                    } else {
                        alert('Erreur lors de la suppression: ' + (data.error || 'Erreur inconnue'));
                    }
                });
            }
        });
    });

    // Gestion de la modification de restaurant
    document.querySelectorAll('.edit-restaurant').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            const nom = row.querySelector('td:nth-child(2)').textContent;
            const categorie = row.querySelector('td:nth-child(3)').textContent;
            const localisation = row.querySelector('td:nth-child(4)').textContent;

            // Remplir le formulaire de modification
            document.getElementById('edit-restaurant-id').value = id;
            document.getElementById('edit-restaurant-name').value = nom;
            document.getElementById('edit-restaurant-category').value = categorie;
            document.getElementById('edit-restaurant-location').value = localisation;

            // Afficher le modal de modification
            const editModal = new bootstrap.Modal(document.getElementById('editRestaurantModal'));
            editModal.show();
        });
    });

    // Gestion de la suppression d'avis
    document.querySelectorAll('.delete-avis').forEach(button => {
        button.addEventListener('click', function() {
            if(confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')) {
                const avisId = this.getAttribute('data-id');
                fetch('includes/delete_avis.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_avis=' + avisId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.closest('tr').remove();
                    } else {
                        alert('Erreur lors de la suppression: ' + (data.error || 'Erreur inconnue'));
                    }
                });
            }
        });
    });

    // Gestion de la modification d'avis
    document.querySelectorAll('.edit-avis').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            const utilisateur = row.querySelector('td:nth-child(2)').textContent;
            const restaurant = row.querySelector('td:nth-child(3)').textContent;
            const note = row.querySelector('.rating span').textContent;
            const contenu = row.querySelector('.comment').textContent;

            // Remplir le formulaire de modification
            document.getElementById('edit-avis-id').value = id;
            document.getElementById('edit-avis-note').value = note;
            document.getElementById('edit-avis-contenu').value = contenu;

            // Afficher le modal de modification
            const editModal = new bootstrap.Modal(document.getElementById('editAvisModal'));
            editModal.show();
        });
    });
});
</script>

<!-- Ajout du modal de modification de restaurant -->
<div class="modal fade" id="editRestaurantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le Restaurant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="includes/update_restaurant.php" method="post">
                    <input type="hidden" id="edit-restaurant-id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit-restaurant-name" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <input type="text" class="form-control" id="edit-restaurant-category" name="categorie" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Localisation</label>
                        <input type="text" class="form-control" id="edit-restaurant-location" name="localisation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ajout du modal de modification d'avis -->
<div class="modal fade" id="editAvisModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Avis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="includes/update_avis.php" method="post">
                    <input type="hidden" id="edit-avis-id" name="id_avis">
                    <input type="hidden" id="edit-avis-id-user" name="id_user">
                    <input type="hidden" id="edit-avis-id-restaurant" name="id_restaurant">

                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <div class="rating-edit">
                            <select class="form-control" id="edit-avis-note" name="nbre_etoiles" required>
                                <option value="1">1 étoile</option>
                                <option value="2">2 étoiles</option>
                                <option value="3">3 étoiles</option>
                                <option value="4">4 étoiles</option>
                                <option value="5">5 étoiles</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Commentaire</label>
                        <textarea class="form-control" id="edit-avis-contenu" name="contenu" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ajout du modal de modification d'utilisateur -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="includes/update_user.php" method="post">
                    <input type="hidden" id="edit-user-id" name="id_user">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit-user-nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="edit-user-prenom" name="prenom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-user-email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

