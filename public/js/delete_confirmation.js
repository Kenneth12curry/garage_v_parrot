// Dans votre fichier JavaScript (par exemple assets/js/delete_confirmation.js)

document.addEventListener('DOMContentLoaded', function() {
    var deleteLinks = document.querySelectorAll('.delete-link');

    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var confirmation = window.confirm("Êtes-vous sûr de vouloir supprimer cette demande ?");
            if (confirmation) {
                window.location.href = link.href;
            }
        });
    });
});
