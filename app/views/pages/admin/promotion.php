<div class="px-3 mt-16">
    <div class="mt-4 w-full lg:max-w-7xl p-4">
        <?= include_required('promotion/notification', [
            'success' => $success ?? null,
            'errors' => $errors ?? []
        ]); ?>
        <div class="flex items-center justify-between bg-white p-3 shdow-lg">
            <?= include_required('promotion/call_to_action'); ?>
            <?=
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
                <?= include_required('promotion/filtered', ['filtered' => $filtered]); ?>
                <?= include_required('promotion/display_view', ['display_mode' => $display_mode]); ?>
            </div>
        </div>
        <div class="mt-10">
            <?php if ($display_mode === 'grid'): ?>
                <!-- Mode Grille -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($data["promotions"]["data"] as $promotion): ?>
                        <?php display_grid_item($promotion); ?>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <!-- Mode Liste -->
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <?php include_required('promotion/table_header'); ?>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($data["promotions"]["data"] as $promotion): ?>
                                <?php display_list_row($promotion); ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
            <div class="mt-6">
                <?= renderPagination($data["promotions"]["pagination"]) ?>
            </div>
        </div>
        <div>
            <?= confirmStatusModal() ?>
        </div>
    </div>
</div>

<script src="<?= ROOT_URL ?>assets/javascript/upload.js"></script>