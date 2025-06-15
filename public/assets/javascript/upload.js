document.addEventListener("DOMContentLoaded", dropZone);

function dropZone() {
  document
    .getElementById("dropzone-file")
    .addEventListener("change", function (e) {
      const fileName = e.target.files[0]?.name || "Aucun fichier sélectionné";
      const dropzone = e.target.closest("label");
      const infoText = dropzone.querySelector("p:first-of-type");

      if (e.target.files.length > 0) {
        infoText.innerHTML = `<span class="font-semibold text-green-600">${fileName}</span>`;
        dropzone.querySelector("i").className =
          "ri-checkbox-circle-line text-3xl text-green-500 mb-2";
      }
    });
}
