<?php

/**
 * Composant Modal pour l'ajout/édition d'une referentiel
 * 
 * @param array $referentiels Liste des référentiels disponibles
 * @param array $errors Erreurs de validation
 * @param array $oldValues Valeurs précédemment soumises
 */
?>

<dialog id="addReferentielModal" class="modal <?= !empty($errors) ? 'modal-open' : '' ?>">
    <div class="modal-box w-full md:max-w-2xl lg:max-w-4xl">
        <div class="flex items-center">
            <span class="badge badge-primary">
                <i class="ri-group-line"></i>
                <?= isset($referentielToEdit) ? 'Modifier la referentiel' : 'Ajouter une nouvelle referentiel' ?>
            </span>
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-error mt-4 ml-4">
                    <i class="ri-error-warning-line"></i>
                    <span><?= htmlspecialchars($errors['general']) ?></span>
                </div>
            <?php endif; ?>
        </div>
        <!-- Formulaire -->
        <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data" class="mt-4 space-y-4">
            <?php if (isset($referentielToEdit)): ?>
                <input type="hidden" name="referentiel_id" value="<?= $referentielToEdit['id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nom de la promotion -->
                <div class="form-control">
                    <label class="label font-medium">Nom de la referentiel</label>
                    <input type="text" placeholder="Entrez nom du referentiel" name="nom" value="<?= htmlspecialchars($oldValues['nom'] ?? $referentielToEdit['nom'] ?? '') ?>"
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

                <div class="form-control">
                    <label class="label font-medium">Capacite</label>
                    <input type="text" placeholder="entrez la capacite du referentiel" name="capacite" value="<?= htmlspecialchars($oldValues['capacite'] ?? $referentielToEdit['capacite'] ?? '') ?>"
                        class="input input-bordered w-full <?= !empty($errors['capacite']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['capacite'])): ?>
                        <p class="text-red-500"><?= $errors['capacite'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Nombre d'apprenants -->
                <div class="form-control">
                    <label class="label font-medium">Nombre de session</label>
                    <select class="select w-full" name="session">
                        <option value="">Choisir un referentiel</option>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?= $session["id"] ?>" <?= isset($oldValues["session"]) == $session["id"] ? 'selected' : "" ?>><?= $session["nom"] ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (!empty($errors['session'])): ?>
                        <p class="text-red-500"><?= $errors['session'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Dates -->
            <div class="form-control flex flex-col">
                <label class="label font-medium">Description</label>
                <textarea name="description" placeholder="Description du referentiel" rows="4" class="w-full p-3"><?= htmlspecialchars($oldValues['description'] ?? $referentielToEdit['description'] ?? '') ?></textarea>
                <?php if (!empty($errors['description'])): ?>
                    <p class="text-red-500"><?= $errors['description'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Boutons -->
            <div class="modal-action">
                <button type="button" onclick="addReferentielModal.close()" class="btn btn-ghost">
                    Annuler
                </button>
                <button type="submit" name="<?= isset($referentielToEdit) ? 'update_referentiel' : 'add_referentiel' ?>" class="btn btn-primary">
                    <i class="ri-save-line mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>