<div class="px-3 mt-14">
    <div class="mt-4 max-w-7xl md:p-4">
        <div class="fixed bottom-5 left-5 space-y-4 transition transform duration-300 opacity-0 translate-y-2" id="alerter">
            <?= include_required('promotion/notification', [
                'success' => $success ?? null,
                'errors' => $errors ?? []
            ]); ?>
        </div>
        <div class="flex items-center justify-between">
            <?= include_required('referentiel/call_to_action'); ?>
            <?=
            include_component('modals/referentiel.modal', [
                'sessions' => $sessions,
                'errors' => $errors ?? [],
                'oldValues' => $_POST,
                'formAction' => '/admin/referentiel',
                'referentielToEdit' => $referentielToEdit ?? null
            ]);
            ?>
        </div>
        <div class="mt-10">
            <?= include_required('referentiel/filtered', ['search' => $_GET['search'] ?? '']); ?>
        </div>
        <div class="mt-10">
            <!-- Mode Grille -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($data["referentiels"]["data"] as $ref): ?>
                    <?php display_card_item($ref); ?>
                <?php endforeach ?>
                <div class="col-span-full">
                    <?= renderPagination($data["referentiels"]["pagination"]) ?>
                </div>
            </div>
        </div>
    </div>
</div>