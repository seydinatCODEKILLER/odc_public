<form action="/admin/apprenant" class="flex items-center">
    <div class="relative">
        <input type="text" name="search" class="border rounded py-2 px-8 lg:w-[500px] bg-white" placeholder="Rechercher...">
        <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
            <i class="ri-search-line"></i>
        </span>
    </div>
    <select class="select border border-gray-200 bg-white" name="statut">
        <option value="">Tous</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <select class="select border border-gray-200 bg-white" name="referentiel">
        <option value="">Tous les référentiels</option>
        <?php foreach ($referentiels as $referentiel): ?>
            <option value="<?= $referentiel['id'] ?>" <?= $filtered['referentiel'] == $referentiel['id'] ? 'selected' : '' ?>>
                <?= $referentiel['nom'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-error text-white">
        <i class="ri-search-line"></i> Filtrez
    </button>
    <?php if ($filtered["search"] || !empty($filtered["statut"]) || !empty($filtered["referentiel"])): ?>
        <a href="/admin/apprenant" class="btn"><i class="ri-refresh-line"></i></a>
    <?php endif; ?>
</form>