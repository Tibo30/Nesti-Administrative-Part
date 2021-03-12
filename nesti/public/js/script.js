document.addEventListener("DOMContentLoaded", function () {
    console.log("ok js");

    // -------------------------------------------js ad recipe content---------------------------------------------

    // var submitNewRecipe = document.querySelector("#submitNewRecipe");
    // if (submitNewRecipe!=null){
    //     submitNewRecipe.addEventListener('click', function () {
    //         var hiddenContent = document.querySelector("#hiddenContentAddRecipe");
    //         hiddenContent.classList.add("visible");
    //         hiddenContent.classList.remove("invisible");
    //     });
    // }
    
    var addParagraph = document.querySelector("#addParagraphNewRecipe");
    if (addParagraph!=null){
        addParagraph.addEventListener('click', function () {
            var paragraph = addParagraph.previousSibling.previousSibling;
            paragraph.innerHTML+='<textarea class="form-control mb-2" id="paragraph1" rows="5" style="resize: none;"></textarea>';
        });
    }

    // var deleteIngredient = document.querySelectorAll(".btn-remove-ingredients");
    // deleteIngredient.forEach(element=>{
    //     element.addEventListener('click',function(){
    //         var parent = element.parentNode.parentNode;
    //         parent.remove();
    //     })
    // })




});


function deleteIngredient(){
    var parent = event.target.parentNode.parentNode;
    parent.remove();
}

   // -------------------------------------------js article edit content --------------------------------------------- //

   function editArticlePicture(){
    console.log("test");
    deleteTag(id, id_tag).then((response) => {
        if (response) {
            if (response.success && response.csrf_token) {
                alert('Suppresion ok');
                // Raffraichissement du CSRF
                csrf.setAttribute('value', response.csrf_token);
                this.parentElement.remove();
            }
        }
    });
}

 /**
     * Requete Ajax pour supprimer un tag d'une recette
     * @param {int} id_recipe
     * @param {int} id_tag
     * @returns mixed
     */
  async function deleteTag( id_recipe, id_tag) {
    // Requete
    var myHeaders = new Headers();
    
    

    let formData = new FormData();
    formData.append('id_recipe', id_recipe);
    formData.append('id_tag', id_tag);
    formData.append(csrf.name, csrf.value);

    var myInit = {method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + '/tag/delete', myInit);
    try {
        if (response.ok) {
            return await response.json();
        } else {
            return false;
        }
    } catch (e) {
        console.error(e.message);
    }


}



