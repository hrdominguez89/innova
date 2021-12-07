let dataBtn;

const btnOnOffCategory = (thisDataBtn)=>{
    dataBtn = thisDataBtn;

    const category_id = parseInt(dataBtn.dataset.target);
    
    const valueToChange = parseInt(dataBtn.dataset.status)? 0:1;
    
    if(changeValueOnDataBase(valueToChange,category_id)){ //SI DEVUELVE TRUE, CAMBIO DE COLOR BOTON.
        changeIcon(parseInt(dataBtn.dataset.status));//si el dataset-status tiene 0 paso de parametro FALSE, si es 1 pasa TRUE.
    }
}

const changeIcon = (value) =>{
    const icon  = document.createElement('i');
    icon.classList.add('cursor');
    if(value){ // cambia a false el boton
        icon.setAttribute('class','fas fa-toggle-off');
        dataBtn.dataset.status = 0;
        dataBtn.classList.remove('text-success');
        dataBtn.title='Activar categoría';
        dataBtn.classList.add('text-muted');
    }else{ //cambia a true el boton
        icon.setAttribute('class','fas fa-toggle-on');
        dataBtn.dataset.status = 1;
        dataBtn.classList.remove('text-muted');
        dataBtn.classList.add('text-success');
        dataBtn.title='Desactivar categoría';
    }
    dataBtn.innerHTML='';
    dataBtn.appendChild(icon);
}

const changeValueOnDataBase = async (value, category_id)=>{
    const data = new FormData();
    data.append('activo',value);
    data.append('id',category_id);
    const init = {
        method: 'POST',
        body: data
    };
    const promise = await fetch("./categories/enableDisableCategory", init);
    const response = await promise.json();
    return response;
}