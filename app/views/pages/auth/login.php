<div class="max-w-3xl">
    <div class="w-full flex flex-col justify-center gap-5 relative bg-white shadow-lg rounded p-5">
        <div class="fixed bottom-5 left-5 space-y-4 transition transform duration-300 opacity-0 translate-y-2" id="alerter">
            <?php if (getFieldError('credentials')): ?>
                <div role="alert" class="alert alert-error text-white">
                    <i class="ri-error-warning-line"></i>
                    <span><?= getFieldError('credentials') ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="flex justify-start gap-3 items-center">
            <img src="assets/images/logo.png" alt="" class="h-10 object-cover">
            <h1 class="text-lg font-medium text-gray-700">Future is now</h1>
        </div>
        <p class="text-gray-500 w-full md:w-96 font-semibold text-sm">
            Bienvenue sur la plateforme de gestion scolaire ! Connectez-vous pour accéder à votre espace personnel
            <span class="text-red-500"><i class="ri-bubble-chart-fill"></i></span>
        </p>
        <form method="post" class="w-full md:w-[500px] mx-auto mt-4">
            <div class="mb-4">
                <label class="block text-sm text-gray-500 font-semibold mb-2">Email </label>
                <div class="relative">
                    <input
                        type="email"
                        name="email"
                        value="<?= $_POST['email'] ?? ''; ?>"
                        placeholder="Entrez votre email"
                        class="w-full px-4 shadow rounded py-3 border-b border-gray-200 bg-white focus:outline-none focus:border-red-500" />
                    <i class="ri-mail-ai-line absolute right-3 top-3"></i>
                </div>
                <span class="text-red-500"><?= getFieldError('email'); ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-500 font-semibold mb-2">Mot de passe</label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        value="<?= $_POST['password'] ?? ''; ?>"
                        placeholder="Entrez votre mot de passe"
                        class="w-full px-4 py-3 shadow rounded border-b border-gray-200 bg-white focus:outline-none focus:border-red-500" />
                    <i class="ri-lock-password-line absolute right-3 top-3"></i>
                </div>
                <span class="text-red-500"><?= getFieldError('password'); ?></span>
            </div>
            <button
                type="submit"
                class="w-full bg-red-500 text-white py-3 rounded hover:bg-red-600 font-semibold">
                Se connectez
            </button>
        </form>
        <div id="notifications" class="fixed top-4 right-4 space-y-2"></div>
    </div>
</div>