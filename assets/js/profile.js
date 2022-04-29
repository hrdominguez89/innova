window.addEventListener("load", () => {
  listenCategoriesCheckbox();
  $(".tipo_de_partner_select").on("change", function (evt, params) {
    if (params.selected == 8) {
      togleDivDescripcionOtroTipoDePartner("show");
    } else {
      togleDivDescripcionOtroTipoDePartner("hide");
    }
  });
});

const togleDivDescripcionOtroTipoDePartner = (estado) => {
  const descripcionOtroTipoDePartner = $("#descripcionOtroTipoDePartner");
  const descripcion_tipo_de_partner = $('#descripcion_tipo_de_partner');
  descripcion_tipo_de_partner.val('')
  if (estado == "show") {
      descripcionOtroTipoDePartner.show();
      descripcion_tipo_de_partner.attr('required','required');
    } else {
      descripcionOtroTipoDePartner.hide();
      descripcion_tipo_de_partner.removeAttr('required');
  }
};

const listenCategoriesCheckbox = () => {
  const categoriesCheckbox =
    document.getElementsByClassName("categoriesCheckbox");
  for (let i = 0; i < categoriesCheckbox.length; i++) {
    const categoryCheckbox = categoriesCheckbox[i];
    categoryCheckbox.addEventListener("change", () => {
      if (categoryCheckbox.checked) {
        showCategoryDescription(true, categoryCheckbox.value);
      } else {
        showCategoryDescription(false, categoryCheckbox.value);
      }
    });
  }
};

const showCategoryDescription = (checked, id) => {
  const divCategoryDescription = document.getElementById(
    `div_category_description_${id}`
  );
  const categoryDescription = document.getElementById(
    `category_description_${id}`
  );
  if (checked) {
    divCategoryDescription.classList.remove("d-none");
    divCategoryDescription.classList.add("d-block");
  } else {
    divCategoryDescription.classList.remove("d-block");
    divCategoryDescription.classList.add("d-none");
    categoryDescription.innerText = "";
  }
};
