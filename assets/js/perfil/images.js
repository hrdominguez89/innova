let imagePreview;
let resultadoDiv;
let imgResultado;
let originalProfileImg;
let inputFile;
let inputHiddenProfileImg;
let imgProfile
let cropper;

const option = {
    aspectRatio: 1 / 1,
    // background:false,
    crop(event) {
        updateFinalImage();
    },
};
window.addEventListener('load',()=>{
    originalProfileImg = document.getElementById('img-profile').src;
    imgProfile = document.getElementById('img-profile');
    inputHiddenProfileImg = document.getElementById('input-hidden-profile-img');
    listenInputFile();
});

const listenInputFile = ()=> {
    inputFile = document.getElementById('logo_imagen');
    inputFile.addEventListener('change',(event)=>{
        if(event.target.files[0]){
            activateModal();
            insertImagePreview(URL.createObjectURL(event.target.files[0]));
            listenModalBtns();
        }else{
            imgProfile.src = originalProfileImg;
            inputHiddenProfileImg.value = '';
        }
    });
};

const listenModalBtns = ()=>{
    const cancelBtnModal = document.getElementById('cancel-btn-modal');
    const saveBtnModal = document.getElementById('save-btn-modal');

    cancelBtnModal.addEventListener('click',()=>{
        imgProfile.src = originalProfileImg;
        inputFile.value = '';
        inputHiddenProfileImg.value = '';
    })
    saveBtnModal.addEventListener('click',()=>{
        const imgProfile = document.getElementById('img-profile');
        imgProfile.src = imgResultado.src;
        inputHiddenProfileImg.value = imgResultado.src;
        console.log(imgResultado.src);
    })
}

const activateModal = ()=>{
    $('#modalProfile').modal('show');
}

const insertImagePreview = (srcImage) => {
    imagePreview = document.createElement('img');
    imagePreview.setAttribute('src',srcImage);
    imagePreview.style.width ="100%";
    imagePreview.setAttribute('id','imagen');
    const divPreview = document.getElementById('preview');
    divPreview.innerHTML = "";
    divPreview.append(imagePreview);
    resultadoDiv = document.getElementById('resultado');
    createCropper();
}


const createCropper = ()=>{
    cropper = new Cropper(imagePreview, option);
}

const updateFinalImage = ()=>{
    resultadoDiv.innerHTML = '';
    imgResultado = document.createElement('img');
    imgResultado.setAttribute('src',cropper.getCroppedCanvas().toDataURL());
    imgResultado.setAttribute('class','rounded-circle border border-primary');
    imgResultado.setAttribute('id','imgResultado')
    imgResultado.style.width = "100%";
    resultadoDiv.appendChild(imgResultado);
}