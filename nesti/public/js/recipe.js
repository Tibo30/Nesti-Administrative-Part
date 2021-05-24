 // hide the notification after a click
 var notifs = document.querySelectorAll(".notifications");
 notifs.forEach(element =>
     element.addEventListener('click', (function(e) {
         element.hidden = true;
     }))
 )

 function allRecipesDelete() {
     let idRecipe = event.target.getAttribute('data-id');
     const td = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.previousElementSibling; // get td of state for this recipe
     deleteRecipe(idRecipe).then((response) => {
         if (response) {
             if (response.success) {
                 td.innerHTML = response.state;
                 document.querySelector("#recipeDeletedSuccess").hidden = false;
             }
         }
         document.querySelector("#closeModalDelete" + idRecipe).click();
     })
 }


 /**
  * Ajax Request to delete the Recipe (change the status to blocked)
  * @param int idRecipe
  * @returns mixed
  */
 async function deleteRecipe(idRecipe) {

     var myHeaders = new Headers();

     let formData = new FormData();
     formData.append('idRecipe', idRecipe);
     var myInit = {
         method: 'POST',
         headers: myHeaders,
         mode: 'cors',
         cache: 'default',
         body: formData
     };

     // Use the fetch API to access the database (the method is called in the ArticleController)
     let response = await fetch(ROOT + 'recipe/delete', myInit);
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