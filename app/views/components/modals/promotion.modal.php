<?php

/**
 * Composant Modal moderne pour l'ajout/édition d'une promotion
 */
?>

<dialog id="addPromotionModal" class="modal <?= !empty($errors) ? 'modal-open' : '' ?>">
    <div class="modal-box bg-gradient-to-br from-white to-gray-50 shadow-xl w-full md:max-w-2xl lg:max-w-4xl border border-gray-100 rounded-xl h-full md:h-[600px] overflow-y-auto">
        <!-- Header avec effet de dégradé rouge -->
        <div class="bg-gradient-to-r from-red-300 to-red-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="ri-team-line"></i>
                    <?= isset($promotionToEdit) ? 'Modifier la promotion' : 'Nouvelle promotion' ?>
                </h3>
                <button onclick="addPromotionModal.close()" class="btn btn-circle btn-ghost btn-sm ">
                    <i class="ri-close-line text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" enctype="multipart/form-data" class="px-6 py-4 space-y-6">
            <?php if (isset($promotionToEdit)): ?>
                <input type="hidden" name="promotion_id" value="<?= $promotionToEdit['id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom de la promotion avec icône -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Nom de la promotion</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-red-100 text-red-600"><i class="ri-hashtag"></i></span>
                        <input type="text" placeholder="Ex: Promotion 2024" name="nom"
                            value="<?= htmlspecialchars($oldValues['nom'] ?? $promotionToEdit['nom'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-red-500 <?= !empty($errors['nom']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['nom'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['nom'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Date de début avec icône -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Date de début</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-red-100 text-red-600"><i class="ri-calendar-event-line"></i></span>
                        <input type="date" name="date_debut"
                            value="<?= htmlspecialchars($oldValues['date_debut'] ?? $promotionToEdit['date_debut'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-red-500 <?= !empty($errors['date_debut']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['date_debut'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['date_debut'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Date de fin avec icône -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Date de fin</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-red-100 text-red-600"><i class="ri-calendar-check-line"></i></span>
                        <input type="date" name="date_fin"
                            value="<?= htmlspecialchars($oldValues['date_fin'] ?? $promotionToEdit['date_fin'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-red-500 <?= !empty($errors['date_fin']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['date_fin'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['date_fin'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Nombre d'apprenants avec icône -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Nombre d'apprenants</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-red-100 text-red-600"><i class="ri-user-line"></i></span>
                        <input type="number" placeholder="Ex: 25" name="nombre_apprenants" min="1"
                            value="<?= htmlspecialchars($oldValues['nombre_apprenants'] ?? $promotionToEdit['nombre_apprenants'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-red-500 <?= !empty($errors['nombre_apprenants']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['nombre_apprenants'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['nombre_apprenants'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upload d'image moderne -->
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

            <!-- Référentiels associés -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold text-gray-700">Référentiels associés</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <?php foreach ($referentiels as $referentiel): ?>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-red-300 cursor-pointer transition-colors">
                            <input type="checkbox" name="referentiels[]" value="<?= $referentiel['id'] ?>"
                                class="checkbox checkbox-primary checkbox-sm"
                                <?= in_array($referentiel['id'], $oldValues['referentiels'] ?? $promotionToEdit['referentiels'] ?? []) ? 'checked' : '' ?>>
                            <div class="flex items-center gap-2">
                                <?php if (!empty($referentiel['image'])): ?>
                                    <img src="<?= htmlspecialchars($referentiel['image']) ?>" alt="" class="w-6 h-6 object-cover rounded">
                                <?php else: ?>
                                    <div class="w-6 h-6 bg-red-100 text-red-600 rounded flex items-center justify-center">
                                        <i class="ri-book-2-line text-sm"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="text-gray-700"><?= htmlspecialchars($referentiel['nom']) ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($errors['referentiels'])): ?>
                    <label class="label">
                        <span class="label-text-alt text-red-500"><?= $errors['referentiels'] ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <!-- Boutons -->
            <div class="modal-action flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="addPromotionModal.close()"
                    class="btn btn-ghost hover:bg-gray-100 text-gray-600">
                    <i class="ri-close-line mr-2"></i> Annuler
                </button>
                <button type="submit" name="<?= isset($promotionToEdit) ? 'update_promotion' : 'add_promotion' ?>"
                    class="btn  bg-red-600 hover:bg-red-700 text-white">
                    <i class="ri-save-2-line mr-2"></i> <?= isset($promotionToEdit) ? 'Mettre à jour' : 'Créer' ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Fond du modal -->
    <form method="dialog" class="modal-backdrop bg-black/30 backdrop-blur-sm">
        <button>Fermer</button>
    </form>
</dialog>