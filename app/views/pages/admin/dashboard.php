<div class="px-3 mt-12">
    <div class="fixed bottom-5 left-5 space-y-4 transition transform duration-300 opacity-0 translate-y-2" id="alerter">
        <?php if (getFieldError('credentials')): ?>
            <div role="alert" class="alert alert-error text-white">
                <i class="ri-error-warning-line"></i>
                <span><?= getFieldError('credentials') ?></span>
            </div>
        <?php endif; ?>
    </div>
    <div class="flex flex-col justify-center items-center bg-white shadow-sm rounded p-6 mt-5">
        <img src="<?= ROOT_URL ?>assets/images/dashboard.jpg" class="h-96 object-cover" alt="">
        <p class="badge badge-soft badge-error py-4 font-medium text-md">Aucune donnee disponible pour le dashboard de l'admin <i class="ri-error-warning-line"></i></p>
    </div>
</div>