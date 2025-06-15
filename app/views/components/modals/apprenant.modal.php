<?php

/**
 * Modal pour l'ajout/édition d'un apprenant
 */
?>

<dialog id="addApprenantModal" class="modal <?= !empty($errors) ? 'modal-open' : '' ?>">
    <div class="modal-box bg-gradient-to-br from-white to-gray-50 shadow-xl w-full md:max-w-2xl lg:max-w-4xl border border-gray-100 rounded-xl h-full md:h-[650px] overflow-y-auto">
        <!-- Header avec effet de dégradé bleu -->
        <div class="bg-gradient-to-r from-blue-300 to-blue-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="ri-user-add-line"></i>
                    <?= isset($apprenantToEdit) ? 'Modifier l\'apprenant' : 'Nouvel apprenant' ?>
                </h3>
                <button onclick="addApprenantModal.close()" class="btn btn-circle btn-ghost btn-sm hover:bg-white/10">
                    <i class="ri-close-line text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" enctype="multipart/form-data" class="px-6 py-4 space-y-6">
            <?php if (isset($apprenantToEdit)): ?>
                <input type="hidden" name="apprenant_id" value="<?= $apprenantToEdit['id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Photo de profil -->
                <div class="form-control row-span-2 flex flex-col items-center">
                    <div class="avatar mb-4">
                        <div class="w-32 h-32 rounded-full bg-blue-100 border-4 border-white shadow-lg relative">
                            <?php if (isset($apprenantToEdit) && !empty($apprenantToEdit['photo'])): ?>
                                <img src="<?= htmlspecialchars($apprenantToEdit['photo']) ?>" class="w-full h-full object-cover rounded-full">
                            <?php else: ?>
                                <i class="ri-user-line text-5xl text-blue-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex flex-col items-center w-full">
                        <label for="dropzone-photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors <?= !empty($errors['photo']) ? 'border-red-500' : '' ?>">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                <i class="ri-camera-line text-3xl text-gray-400 mb-2"></i>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Cliquez pour uploader</span> une photo
                                </p>
                                <p class="text-xs text-gray-500">JPG, PNG (MAX. 2MB)</p>
                            </div>
                            <input id="dropzone-photo" type="file" name="photo" accept="image/*" class="hidden" />
                        </label>
                        <?php if (!empty($errors['photo'])): ?>
                            <label class="label">
                                <span class="label-text-alt text-red-500"><?= $errors['photo'] ?></span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Nom -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Nom</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-user-line"></i></span>
                        <input type="text" placeholder="Dupont" name="nom"
                            value="<?= htmlspecialchars($oldValues['nom'] ?? $apprenantToEdit['nom'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['nom']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['nom'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['nom'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Prénom -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Prénom</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-user-2-line"></i></span>
                        <input type="text" placeholder="Jean" name="prenom"
                            value="<?= htmlspecialchars($oldValues['prenom'] ?? $apprenantToEdit['prenom'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['prenom']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['prenom'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['prenom'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Référentiel</span>
                    </label>
                    <select name="referentiel_id" class="select select-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['referentiel_id']) ? 'select-error' : '' ?>">
                        <option disabled selected>Choisir un référentiel</option>
                        <?php foreach ($referentiels as $referentiel): ?>
                            <option value="<?= $referentiel['id'] ?>"
                                <?= (isset($oldValues['referentiel_id']) && $oldValues['referentiel_id'] == $referentiel['id']) ||
                                    (isset($apprenantToEdit['referentiel_id']) && $apprenantToEdit['referentiel_id'] == $referentiel['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($referentiel['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['referentiel_id'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['referentiel_id'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Date de naissance -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Date de naissance</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-calendar-line"></i></span>
                        <input type="date" name="date_naissance"
                            value="<?= htmlspecialchars($oldValues['date_naissance'] ?? $apprenantToEdit['date_naissance'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['date_naissance']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['date_naissance'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['date_naissance'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Lieu de naissance -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Lieu de naissance</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-map-pin-line"></i></span>
                        <input type="text" placeholder="Paris, France" name="lieu_naissance"
                            value="<?= htmlspecialchars($oldValues['lieu_naissance'] ?? $apprenantToEdit['lieu_naissance'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['lieu_naissance']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['lieu_naissance'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['lieu_naissance'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Adresse -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Adresse</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-home-4-line"></i></span>
                        <input type="text" placeholder="123 Rue de l'Exemple, 75000 Paris" name="adresse"
                            value="<?= htmlspecialchars($oldValues['adresse'] ?? $apprenantToEdit['adresse'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['adresse']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['adresse'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['adresse'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Email</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-mail-line"></i></span>
                        <input type="email" placeholder="jean.dupont@example.com" name="email"
                            value="<?= htmlspecialchars($oldValues['email'] ?? $apprenantToEdit['email'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['email']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['email'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['email'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Téléphone -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-gray-700">Téléphone</span>
                    </label>
                    <label class="input-group">
                        <span class="bg-blue-100 text-blue-600"><i class="ri-phone-line"></i></span>
                        <input type="tel" placeholder="0612345678" name="telephone"
                            value="<?= htmlspecialchars($oldValues['telephone'] ?? $apprenantToEdit['telephone'] ?? '') ?>"
                            class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 <?= !empty($errors['telephone']) ? 'input-error' : '' ?>">
                    </label>
                    <?php if (!empty($errors['telephone'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-red-500"><?= $errors['telephone'] ?></span>
                        </label>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Boutons -->
            <div class="modal-action flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="addApprenantModal.close()"
                    class="btn btn-ghost hover:bg-gray-100 text-gray-600">
                    <i class="ri-close-line mr-2"></i> Annuler
                </button>
                <button type="submit" name="<?= isset($apprenantToEdit) ? 'update_apprenant' : 'add_apprenant' ?>"
                    class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white">
                    <i class="ri-save-2-line mr-2"></i> <?= isset($apprenantToEdit) ? 'Mettre à jour' : 'Enregistrer' ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Fond du modal -->
    <form method="dialog" class="modal-backdrop bg-black/30 backdrop-blur-sm">
        <button>Fermer</button>
    </form>
</dialog>

<script>
    // Script pour afficher la photo sélectionnée
    document.getElementById('dropzone-photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const avatar = document.querySelector('.avatar div');
        const icon = avatar.querySelector('i');

        if (file) {
            if (icon) icon.remove();

            const reader = new FileReader();
            reader.onload = function(event) {
                let img = avatar.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    img.className = 'w-full h-full object-cover rounded-full';
                    avatar.appendChild(img);
                }
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>