window.addEventListener('load',()=>{
    listenCategoriesCheckbox();
});

const listenCategoriesCheckbox = ()=>{
    const categoriesCheckbox = document.getElementsByClassName('categoriesCheckbox');
    for (let i = 0; i < categoriesCheckbox.length; i++) {
        const categoryCheckbox = categoriesCheckbox[i];
        categoryCheckbox.addEventListener('change',()=>{
            if(categoryCheckbox.checked){
                showCategoryDescription(true,categoryCheckbox.value);
            }else{
                showCategoryDescription(false,categoryCheckbox.value);
            }
        });
    }
}

const showCategoryDescription = (checked, id)=>{
    const divCategoryDescription = document.getElementById(`div_category_description_${id}`);
    const categoryDescription = document.getElementById(`category_description_${id}`);
    if(checked){
        divCategoryDescription.classList.remove('d-none');
        divCategoryDescription.classList.add('d-block');
    }else{
        divCategoryDescription.classList.remove('d-block');
        divCategoryDescription.classList.add('d-none');
        categoryDescription.innerText='';
    }
}