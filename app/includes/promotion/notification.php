<div class="fixed top-5 right-5 space-y-4 transition transform duration-300 opacity-0 translate-y-2 z-50" id="alerter">
    <?php if ($success): ?>
        <div role="alert" class="alert alert-success text-white">
            <i class="ri-error-warning-line"></i>
            <span><?= $success ?></span>
        </div>
    <?php endif; ?>
</div>