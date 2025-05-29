// Fonction pour confirmer le changement de statut
function confirmToggleStatus(promotionId, currentStatus) {
  const modal = document.getElementById("confirmStatusModal");
  const title = document.getElementById("modalTitle");
  console.log(title);

  const message = document.getElementById("modalMessage");
  const idInput = document.getElementById("modalPromotionId");

  const newStatus = currentStatus === "active" ? "inactive" : "active";
  const actionVerb = newStatus === "active" ? "activer" : "désactiver";

  title.textContent = "Passer à " + newStatus;
  message.textContent =
    "Êtes-vous sûr de vouloir " + actionVerb + " cette promotion ?";
  idInput.value = promotionId;

  const form = document.getElementById("statusForm");
  form.action = "/admin/promotion/" + promotionId + "/toggle-status";
  modal.showModal();
}

// Gestion de la fermeture de la modal
function setupStatusModal() {
  const modal = document.getElementById("confirmStatusModal");
  if (modal) {
    modal.addEventListener("click", (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.close();
      }
    });
  }
}

// Initialisation quand le DOM est chargé
document.addEventListener("DOMContentLoaded", function () {
  setupStatusModal();
});
