<div class="px-3">
    <div class="bg-white mt-4 shadow-sm max-w-7xl p-4">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <h1 class="text-red-500 font-medium text-xl">Promotions</h1>
                <span class="text-gray-700">Gerer les promotions de l'ecole</span>
            </div>
            <button class="text-white btn btn-error">
                <i class="ri-add-line"></i>
                <span>Ajouter une promotion</span>
            </button>
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
                <form action="" class="w-[700px]">
                    <div class="relative">
                        <input type="text" class="border bg-gray-50 rounded py-2 px-8 w-full focus:outline-none focus:ring focus:ring-red-500" placeholder="Rechercher...">
                        <button type="submit" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="ri-search-line"></i>
                        </button>
                    </div>
                </form>
                <select class="select border border-1">
                    <option>Tous</option>
                    <option>Go</option>
                    <option>Rust</option>
                </select>
                <div class="flex items-center gap-3">
                    <!-- Boutons de bascule -->
                    <a href="?mode=grid" class="btn <?= $display_mode === 'grid' ? 'btn-error text-white' : 'btn-outline text-gray-700' ?>">
                        <i class="ri-dashboard-line"></i>
                        <span>Grille</span>
                    </a>
                    <a href="?mode=list" class="btn <?= $display_mode === 'list' ? 'btn-error text-white' : 'btn-outline text-gray-700' ?>">
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
                    <?php foreach ($stats["promotions"] as $promotion): ?>
                        <div class="p-3 rounded shadow-md">
                            <div class="flex justify-end items-center gap-3">
                                <span class="badge badge-soft badge-<?= colorState($promotion["statut"]) ?> font-medium text-md"><?= $promotion["statut"] ?></span>
                                <a href="" class="btn btn-soft btn-<?= colorBtnState($promotion["statut"]) ?> w-10 h-10 rounded-full flex justify-center items-center">
                                    <i class="ri-shut-down-line"></i>
                                </a>
                            </div>
                            <div class="mt-2 flex items-center gap-3">
                                <img src="<?= $promotion["image"] ?>" class="w-12 h-12 rounded-full object-cover" alt="">
                                <div class="flex flex-col">
                                    <p class="font-medium text-lg"><?= $promotion["promotion_nom"] ?></p>
                                    <span class="text-gray-500 font-medium"><i class="ri-calendar-line"></i> <?= format_date($promotion["date_debut"]) ?> - <?= format_date($promotion["date_fin"]) ?></span>
                                </div>
                            </div>
                            <div class="mt-4 p-2 rounded bg-gray-50 flex items-center gap-3 text-gray-800 font-medium">
                                <i class="ri-group-line"></i>
                                <span class="">
                                    <?= $promotion["nombre_apprenants"] ?> apprenants
                                </span>
                            </div>
                            <div class="flex justify-end mt-5 border-t-2 border-gray-200">
                                <a href="" class="text-red-500 py-2 ">
                                    <span>Voir details</span>
                                    <i class="ri-arrow-right-s-line"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
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
                            <?php foreach ($stats["promotions"] as $promotion): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium"><?= htmlspecialchars($promotion['promotion_nom']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= format_date($promotion["date_debut"]) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"> <?= format_date($promotion["date_fin"]) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= $promotion['nombre_apprenants'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <?php foreach (parsePostgresArray($promotion["referentiels"]) as $ref): ?>
                                                <span class="badge badge-soft badge-primary text-md font-medium "><?= $ref ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-md font-medium badge badge-soft badge-<?= colorState($promotion['statut']) ?>">
                                            <?= $promotion['statut']  ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="dropdown dropdown-end">
                                            <button type="button" tabindex="0" class="btn btn-ghost btn-sm">
                                                <i class="ri-more-2-fill text-gray-400 hover:text-gray-600"></i>
                                            </button>
                                            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-white rounded-box w-40 mt-1">
                                                <li>
                                                    <a href="" class="text-gray-700 hover:bg-gray-100">
                                                        <i class="ri-pencil-line text-gray-400"></i>
                                                        action
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>