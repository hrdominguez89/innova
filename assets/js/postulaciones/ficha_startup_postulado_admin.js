window.addEventListener('load', () => {
        escucharSelectValidarPostulacion();
    });

    const escucharSelectValidarPostulacion = () => {
        let selectValidarPostulacion = document.getElementById('selectValidarPostulacion');
        selectValidarPostulacion.addEventListener('change', () => {
            if (selectValidarPostulacion.value == 2) {
                toggleDetalleRechazado(false);
            } else if (selectValidarPostulacion.value == 4) {
                toggleDetalleRechazado(true);
            }
        });
    }

    const toggleDetalleRechazado = (value) => {
        let divDetalleRechazado = document.getElementById('divDetalleRechazado');
        let textArea = document.getElementById('detalle_rechazo_cancelado');
        if (value) {
            divDetalleRechazado.style.display = "block";
            textArea.setAttribute('required', 'required');
        } else {
            divDetalleRechazado.style.display = "none";
            textArea.removeAttribute('required');
            textArea.value = '';
        }
    }