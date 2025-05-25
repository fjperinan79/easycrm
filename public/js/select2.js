document.addEventListener('DOMContentLoaded', function () {
    const contactoSelect = document.getElementById('contacto_id');
    if (contactoSelect) {
        $(contactoSelect).select2({
            placeholder: "Seleccione un contacto",
            width: 'resolve'
        });
    }
});
