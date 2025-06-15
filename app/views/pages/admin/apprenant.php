<div class="px-3 mt-20">
    <?= include_required('apprenant/banner', ['stats' => $stats]); ?>
    <div class="flex justify-between items-center mt-5">
        <div>
            <?= include_required('apprenant/filtered', [
                'filtered' => $filtered,
                'referentiels' => $referentiels
            ]); ?>
        </div>
        <div class="flex items-center gap-2">
            <?= include_required('apprenant/call_to_action'); ?>
            <?=
            include_component('modals/apprenant.modal', [
                'referentiels' => $referentiels,
                'errors' => $errors ?? [],
                'oldValues' => $_POST,
                'formAction' => 'admin/promotion',
                'apprenantToEdit' => $apprenantToEdit ?? null
            ]);
            ?>
        </div>
    </div>
    <div class="bg-white shadow-sm rounded mt-6 grid grid-cols-1 md:grid-cols-2">
        <?= include_required('apprenant/display_nav', ['stats' => $stats]); ?>
    </div>
    <div class="mt-5">
        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-red-500 to-pink-500 text-white">
                    <?= include_required('apprenant/table_header'); ?>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($apprenants as $apprenant): ?>
                        <?php display_list_row_apprenant($apprenant); ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <?= renderPagination($pagination) ?>
        </div>
    </div>
</div>

<script src="<?= ROOT_URL ?>assets/javascript/upload.js"></script>