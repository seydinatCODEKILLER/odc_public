<?php

/**
 * Composant Modal moderne pour l'ajout/édition d'un référentiel
 * 
 * @param array $referentiels Liste des référentiels disponibles
 * @param array $errors Erreurs de validation
 * @param array $oldValues Valeurs précédemment soumises
 */
?>

<dialog id="addReferentielModal" class="modal <?= !empty($errors) ? 'modal-open' : '' ?>">
    <div class="modal-box bg-gradient-to-br from-white to-gray-50 shadow-xl w-full md:max-w-2xl lg:max-w-4xl border border-gray-100 rounded-xl h-full md:h-[600px] ">
        <!-- Header avec effet de dégradé -->
        <div class="bg-gradient-to-r from-blue-300 to-blue-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="ri-book-2-line"></i>
                    <?= isset($referentielToEdit) ? 'Modifier le référentiel' : 'Nouveau référentiel' ?>
                </h3>
                <a href="/admin/referentiel" class="btn btn-circle btn-ghost btn-sm">
                    <i class="ri-close-line text-lg"></i>
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data" class="px-6 py-4 space-y-6">
            <?php if (isset($referentielToEdit)): ?>
                <input type="hidden" name="referentiel_id" value="<?= $referentielToEdit['id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom du référentiel -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Nom du référentiel</span>
                    </label>
                    <input type="text" placeholder="Ex: Développement Web" name="nom"
                        value="<?= htmlspecialchars($oldValues['nom'] ?? $referentielToEdit['nom'] ?? '') ?>"
                        class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?= !empty($errors['nom']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['nom'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['nom'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Capacité -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Capacité</span>
                    </label>
                    <input type="text" placeholder="Ex: 25 places" name="capacite"
                        value="<?= htmlspecialchars($oldValues['capacite'] ?? $referentielToEdit['capacite'] ?? '') ?>"
                        class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['capacite']) ? 'input-error' : '' ?>">
                    <?php if (!empty($errors['capacite'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['capacite'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Session -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Session associée</span>
                    </label>
                    <select class="select select-bordered w-full focus:ring-2 focus:ring-blue-500" name="session">
                        <option disabled selected>Choisir une session</option>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?= $session["id"] ?>"
                                <?= (isset($oldValues["session"]) && $oldValues["session"] == $session["id"]) ? 'selected' : "" ?>>
                                <?= $session["nom"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <?php if (!empty($errors['session'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['session'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Description</span>
                    </label>
                    <textarea name="description" placeholder="Décrivez ce référentiel..." rows="4"
                        class="textarea textarea-bordered w-full focus:ring-2 focus:ring-blue-500 p-3"><?= htmlspecialchars($oldValues['description'] ?? $referentielToEdit['description'] ?? '') ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['description'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold text-gray-700">Image/Logo</span>
                </label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors <?= !empty($errors['image']) ? 'border-red-500' : '' ?>">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                            <i class="ri-image-add-line text-3xl text-gray-400 mb-2"></i>
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Cliquez pour uploader</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" name="image" class="hidden" />
                    </label>
                </div>
                <?php if (!empty($errors['image'])): ?>
                    <label class="label">
                        <span class="label-text-alt text-red-500"><?= $errors['image'] ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <!-- Boutons -->
            <div class="modal-action flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="addReferentielModal.close()"
                    class="btn btn-ghost hover:bg-gray-100 text-gray-600">
                    <i class="ri-close-line mr-2"></i> Annuler
                </button>
                <button type="submit" name="<?= isset($referentielToEdit) ? 'update_referentiel' : 'add_referentiel' ?>"
                    class="btn btn-primary text-white">
                    <i class="ri-save-2-line mr-2"></i> <?= isset($referentielToEdit) ? 'Mettre à jour' : 'Créer' ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Fond du modal -->
    <form method="dialog" class="modal-backdrop bg-black/30 backdrop-blur-sm">
        <button>Fermer</button>
    </form>
</dialog>