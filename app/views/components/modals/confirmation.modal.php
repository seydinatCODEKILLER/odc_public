<?php

function confirmStatusModal(): void
{
    echo <<<HTML
    <dialog id="confirmStatusModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="modalTitle">Confirmation</h3>
            <p class="py-4" id="modalMessage">Êtes-vous sûr de vouloir modifier le statut de cette promotion ?</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Annuler</button>
                </form>
                <form id="statusForm" method="POST">
                    <input type="hidden" name="promotion_id" id="modalPromotionId">
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </form>
            </div>
        </div>
    </dialog>
       
    HTML;
}
