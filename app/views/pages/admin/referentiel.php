<div class="px-3 mt-14">
    <div class="mt-4 max-w-7xl p-4">
        <div class="fixed bottom-5 left-5 space-y-4 transition transform duration-300 opacity-0 translate-y-2" id="alerter">
            <?php if ($success): ?>
                <div role="alert" class="alert alert-success text-white">
                    <i class="ri-error-warning-line"></i>
                    <span><?= $success ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <h1 class="text-red-500 font-medium text-xl">Toutes les referentiels</h1>
                <span class="text-gray-700">Liste complete des referentiels de la formation</span>
            </div>
            <button onclick="addReferentielModal.showModal()" class="text-white px-3 py-2 rounded bg-gradient-to-r from-red-500 to-pink-500 shadow-sm">
                <i class="ri-add-line"></i>
                <span>Creer un referentiels</span>
            </button>
            <?php
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
            <form action="/admin/referentiel" class="w-full flex items-center gap-2">
                <div class="relative">
                    <input name="search" type="text" class="border bg-white rounded py-2 px-8 w-96" placeholder="Rechercher...">
                    <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="ri-search-line"></i>
                    </span>
                </div>
                <button type="submit" class="btn btn-error text-white">Rechercher</button>
                <?php if (isset($_GET["search"])): ?>
                    <a href="/admin/referentiel" class="btn btn-outline"><i class="ri-refresh-line"></i></a>
                <?php endif; ?>
            </form>
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