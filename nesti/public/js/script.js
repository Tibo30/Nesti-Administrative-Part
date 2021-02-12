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