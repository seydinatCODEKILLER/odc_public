<img src="<?= $apprenant["photo"] ?>" alt="" class="w-24 h-24 object-cover rounded-full border-2 border-red-500">
<p class="font-medium"><?= $apprenant["prenom"] ?> <?= $apprenant["nom"] ?></p>
<span class="p-2 rounded bg-pink-500 text-white"><?= $apprenant["referentiel"] ?></span>
<span class="badge badge-soft badge-<?= colorState($apprenant["statut"]) ?>"><?= $apprenant["statut"] ?></span>