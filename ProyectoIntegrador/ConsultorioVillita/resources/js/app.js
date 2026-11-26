let indiceMedicamento = document.querySelectorAll('[data-medicamento-row]').length;

document.addEventListener('click', (event) => {
    const navToggle = event.target.closest('[data-nav-toggle]');
    if (navToggle) {
        document.querySelector('[data-nav-menu]')?.classList.toggle('hidden');
    }

    const sidebarToggle = event.target.closest('[data-sidebar-toggle]');
    if (sidebarToggle) {
        document.querySelector('[data-sidebar]')?.classList.toggle('-translate-x-full');
        document.querySelector('[data-sidebar-overlay]')?.classList.toggle('hidden');
    }

    const dismiss = event.target.closest('[data-dismiss]');
    if (dismiss) {
        dismiss.closest('[data-flash]')?.remove();
    }

    const agregar = event.target.closest('[data-add-medicamento]');
    if (agregar) {
        const plantilla = document.getElementById('medicamento-template');
        const contenedor = document.querySelector('[data-medicamentos]');

        if (plantilla && contenedor) {
            contenedor.insertAdjacentHTML(
                'beforeend',
                plantilla.innerHTML.replaceAll('__INDEX__', indiceMedicamento++)
            );
        }
    }

    const quitar = event.target.closest('[data-remove-medicamento]');
    if (quitar) {
        quitar.closest('[data-medicamento-row]')?.remove();
    }
});

document.addEventListener('change', (event) => {
    const select = event.target.closest('[data-consulta-select]');

    if (! select) {
        return;
    }

    const opcion = select.selectedOptions[0];
    const nombre = document.querySelector('[name="nombre_paciente"]');
    const edad = document.querySelector('[name="edad"]');

    if (nombre && ! nombre.value) {
        nombre.value = opcion?.dataset.nombre ?? '';
    }

    if (edad && ! edad.value) {
        edad.value = opcion?.dataset.edad ?? '';
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (form.matches('[data-confirm]') && !window.confirm(form.dataset.confirm)) {
        event.preventDefault();
    }
});
