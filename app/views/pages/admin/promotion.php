<div class="px-3 mt-16">
    <div class="bg-white mt-4 shadow-sm w-full lg:max-w-7xl p-4">
        <div class="fixed bottom-5 left-5 space-y-4 transition transform duration-300 opacity-0 translate-y-2" id="alerter">
            <?php if ($success): ?>
                <div role="alert" class="alert alert-success text-white">
                    <i class="ri-error-warning-line"></i>
                    <span><?= $success ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-between">
            <div class="hidden md:flex flex-col">
                <h1 class="text-red-500 font-medium text-xl">Promotions</h1>
                <span class="text-gray-700">Gerer les promotions de l'ecole</span>
            </div>
            <button onclick="addPromotionModal.showModal()" class="text-white px-3 py-2 rounded bg-gradient-to-r from-red-500 to-pink-500">
                <i class="ri-add-line"></i>
                <span>Ajouter une promotion</span>
            </button>
            <?php
            include_component('modals/promotion.modal', [
                'referentiels' => $referentiels,
                'errors' => $errors ?? [],
                'oldValues' => $_POST,
                'formAction' => 'admin/promotion',
                'promotionToEdit' => $promotionToEdit ?? null
            ]);
            ?>
        </div>
        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            <?=
            display_stat_card($stats['nombre_apprenant'], 'Apprenants', 'ri-group-line');
            display_stat_card($stats['nombre_referentiel'], 'Referentiels', 'ri-book-line');
            display_stat_card($stats['nombre_promotions_active'], 'Promotions actives', 'ri-checkbox-circle-fill');
            display_stat_card($stats['nombre_promotions'], 'Promotions', 'ri-folder-6-line');
            ?>
        </div>
        <div class="mt-10">
            <div class="flex items-center justify-between">
                <form action="/admin/promotion" class="w-full flex items-center flex-col md:flex-row gap-3">
                    <div class="flex items-center">
                        <div class="relative">
                            <input type="text" name="search" class="border bg-gray-50 rounded py-2 px-8 lg:w-[500px]" placeholder="Rechercher...">
                            <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-search-line"></i>
                            </span>
                        </div>
                        <select class="select border bg-gray-50" name="statut">
                            <option value="">Tous</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <button type="submit" class="btn btn-error text-white">
                            <i class="ri-search-line"></i> Filtrez
                        </button>
                        <?php if (!empty($filtered["search"]) || !empty($filtered["statut"])): ?>
                            <a href="/admin/promotion" class="btn btn-outline"><i class="ri-refresh-line"></i></a>
                        <?php endif; ?>
                    </div>
                </form>
                <div class=" items-center hidden lg:flex">
                    <!-- Boutons de bascule -->
                    <a href="?mode=grid" class="btn <?= $display_mode === 'grid' ? 'btn-error text-white' : 'border border-gray-100 rounded text-gray-700' ?>">
                        <i class="ri-dashboard-line"></i>
                        <span>Grille</span>
                    </a>
                    <a href="?mode=list" class="btn <?= $display_mode === 'list' ? 'btn-error text-white' : 'border border-gray-100 rounded text-gray-700' ?>">
                        <i class="ri-list-check-3"></i>
                        <span>Liste</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <?php if ($display_mode === 'grid'): ?>
                <!-- Mode Grille -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($data["promotions"]["data"] as $promotion): ?>
                        <?php display_grid_item($promotion); ?>
                    <?php endforeach ?>
                    <div class="col-span-full">
                        <?= renderPagination($data["promotions"]["pagination"]) ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Mode Liste -->
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date debut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date fin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apprenants</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referentiels</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($data["promotions"]["data"] as $promotion): ?>
                                <?php display_list_row($promotion); ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?= renderPagination($data["promotions"]["pagination"]) ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>