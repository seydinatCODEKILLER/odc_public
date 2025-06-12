<div class="px-3 mt-20">
    <?= include_required('details-apprenant/details_heading'); ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-5">
        <div class="p-3 bg-white flex flex-col gap-5">
            <?= include_required("details-apprenant/back-link") ?>
            <div class="flex flex-col gap-5">
                <div class="flex justify-center items-center flex-col gap-2">
                    <?= include_required("details-apprenant/info-apprenant", ["apprenant" => $apprenant]) ?>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <?= display_list("ri-phone-line", $apprenant["telephone"], "info") ?>
                    <?= display_list("ri-map-pin-2-line", $apprenant["adresse"], "success") ?>
                    <div class="col-span-full">
                        <?= display_list("ri-ancient-pavilion-line", $apprenant["promotion"], "warning") ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <?= display_stat_card($stat["presence"], "Presentiels", "ri-group-line", "info") ?>
                <?= display_stat_card($stat["retard"], "Retard", "ri-group-line", "warning") ?>
                <?= display_stat_card($stat["absence"], "Absence", "ri-group-line")  ?>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 mt-8">
                <?= include_required("details-apprenant/display_nav", ["apprenant" => $apprenant, "display_mode" => $display_mode]) ?>
            </div>
            <div class="mt-10">
                <?php if ($display_mode === "module"): ?>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <?php foreach ($modules as $module): ?>
                            <?= display_grid_module($module); ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <?php include_required('details-apprenant/table_header'); ?>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($absences)): ?>
                                    <?php foreach ($absences as $absence): ?>
                                        <?= display_list_absence($absence); ?>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <?= display_empty_table("/assets/images/recherche.png", "Aucune absence disponible", 5) ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        <?= renderPagination($pagination) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>