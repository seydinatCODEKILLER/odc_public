<?php

/**
 * Composant Modal pour l'ajout/édition d'une promotion
 * 
 * @param array $referentiels Liste des référentiels disponibles
 * @param array $errors Erreurs de validation
 * @param array $oldValues Valeurs précédemment soumises
 */
?>

<dialog id="addPromotionModal" class="modal <?= !empty($errors) ? 'modal-open' : '' ?>">
    <div class="modal-box w-full md:max-w-2xl lg:max-w-4xl">
        <div class="flex items-center">
            <span class="py-1 px-2 rounded-3xl bg-red-200 text-red-500">
                <i class="ri-group-line"></i>
                <?= isset($promotionToEdit) ? 'Modifier la promotion' : 'Ajouter une nouvelle promotion' ?>
            </span>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-error mt-4 ml-4">
                    <i class="ri-error-warning-line"></i>
                    <span><?= htmlspecialchars($errors['general']) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulaire -->
        <form method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            <?php if (isset($promotionToEdit)): ?>
                <input type="hidden" name="promotion_id" value="<?= $promotionToEdit['id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nom de la promotion -->
                <div class="form-control">
                    <label class="label font-medium">Nom de la promotion</label>
                    <input type="text" placeholder="Entrez nom du promotion" name="nom" value="<?= htmlspecialchars($oldValues['nom'] ?? $promotionToEdit['nom'] ?? '') ?>"
                        class="input input-bordered w-full <?= !empty($errors['nom']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['nom'])): ?>
                        <p class="text-red-500"><?= $errors['nom'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Image -->
                <div class="form-control">
                    <label class="label font-medium">Image</label>
                    <input type="file" name="image" class="file-input file-input-bordered w-full <?= !empty($errors['image']) ? 'file-input-error' : '' ?>">
                    <?php if (!empty($errors['image'])): ?>
                        <p class="text-red-500"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Dates -->
                <div class="form-control">
                    <label class="label font-medium">Date de début</label>
                    <input type="date" name="date_debut" value="<?= htmlspecialchars($oldValues['date_debut'] ?? $promotionToEdit['date_debut'] ?? '') ?>"
                        class="input input-bordered w-full <?= !empty($errors['date_debut']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['date_debut'])): ?>
                        <p class="text-red-500"><?= $errors['date_debut'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-control">
                    <label class="label font-medium">Date de fin</label>
                    <input type="date" name="date_fin" value="<?= htmlspecialchars($oldValues['date_fin'] ?? $promotionToEdit['date_fin'] ?? '') ?>"
                        class="input input-bordered w-full <?= !empty($errors['date_fin']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['date_fin'])): ?>
                        <p class="text-red-500"><?= $errors['date_fin'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Nombre d'apprenants -->
                <div class="form-control">
                    <label class="label font-medium">Nombre d'apprenants</label>
                    <input type="number" placeholder="Entrez le nombre d'apprenant" name="nombre_apprenants" min="1"
                        value="<?= htmlspecialchars($oldValues['nombre_apprenants'] ?? $promotionToEdit['nombre_apprenants'] ?? '') ?>"
                        class="input input-bordered w-full <?= !empty($errors['nombre_apprenants']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['nombre_apprenants'])): ?>
                        <p class="text-red-500"><?= $errors['nombre_apprenants'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Référentiels -->
            <div class="form-control">
                <label class="label font-medium">Référentiels associés</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                    <?php foreach ($referentiels as $referentiel): ?>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="referentiels[]" value="<?= $referentiel['id'] ?>"
                                class="checkbox checkbox-primary"
                                <?= in_array($referentiel['id'], $oldValues['referentiels'] ?? $promotionToEdit['referentiels'] ?? []) ? 'checked' : '' ?>>
                            <span><?= htmlspecialchars($referentiel['nom']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($errors['referentiels'])): ?>
                    <p class="text-red-500"><?= $errors['referentiels'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Boutons -->
            <div class="modal-action">
                <button type="button" onclick="addPromotionModal.close()" class="btn btn-ghost">
                    Annuler
                </button>
                <button type="submit" name="<?= isset($promotionToEdit) ? 'update_promotion' : 'add_promotion' ?>" class="btn btn-primary">
                    <i class="ri-save-line mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>