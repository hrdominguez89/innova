let dataBtn;

const btnOnOffUser = (thisDataBtn)=>{
    dataBtn = thisDataBtn;

    let user_id = parseInt(dataBtn.dataset.target);
    
    let valueToChange;
    if(parseInt(dataBtn.dataset.status) == 4){
        valueToChange = 3;
    }else{
        valueToChange = 4;
    }
    if(changeValueOnDataBase(valueToChange,user_id)){ //SI DEVUELVE TRUE, CAMBIO DE COLOR BOTON.
        changeIcon(parseInt(dataBtn.dataset.status));//si el dataset-status tiene 0 paso de parametro FALSE, si es 1 pasa TRUE.
    }
}

const changeIcon = (value) =>{
    const icon  = document.createElement('i');
    icon.classList.add('cursor');
    if(value == 3){ // cambia a false el boton
        icon.setAttribute('class','fas fa-toggle-off');
        dataBtn.dataset.status = 4;
        dataBtn.classList.remove('text-success');
        dataBtn.title='Habilitar usuario';
        dataBtn.classList.add('text-muted');
    }else{ //cambia a true el boton
        icon.setAttribute('class','fas fa-toggle-on');
        dataBtn.dataset.status = 3;
        dataBtn.classList.remove('text-muted');
        dataBtn.classList.add('text-success');
        dataBtn.title='Deshabilitar usuario';
    }
    dataBtn.innerHTML='';
    dataBtn.appendChild(icon);
}

const changeValueOnDataBase = async (value, user_id)=>{
    const data = new FormData();
    data.append('status_user_id',value);
    data.append('id',user_id);
    const init = {
        method: 'POST',
        body: data
    };
    const promise = await fetch("./users/enableDisableUser", init);
    const response = await promise.json();
    return response;
}