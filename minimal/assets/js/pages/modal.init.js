var varyingcontentModal = document.getElementById("varyingcontentModal");
varyingcontentModal && varyingcontentModal.addEventListener("show.bs.modal", function(t) {
    var e = t.relatedTarget.getAttribute("data-bs-whatever"),
        n = varyingcontentModal.querySelector(".modal-title"),
        t = varyingcontentModal.querySelector(".modal-body input");
    n.textContent = "New message to " + e, t.value = e
});