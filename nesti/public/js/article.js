// hide the notification after a click
var notifs = document.querySelectorAll(".notifications");
notifs.forEach(element =>
    element.addEventListener('click', (function(e) {
        element.hidden = true;
    }))
)

function allArticlesDelete() {
    let idArticle = event.target.getAttribute('data-id');
    const td = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.previousElementSibling.previousElementSibling; // get td of state for this article
    deleteArticle(idArticle).then((response) => {
        if (response) {
            if (response.success) {
                td.innerHTML = response.state;
                document.querySelector("#articleDeletedSuccess").hidden = false;
            }
        }
        document.querySelector("#closeModalDelete" + idArticle).click();
    })
}


/**
 * Ajax Request to delete the Article (change the status to blocked)
 * @param int idArticle
 * @returns mixed
 */
async function deleteArticle(idArticle) {

    var myHeaders = new Headers();

    let formData = new FormData();
    formData.append('idArticle', idArticle);
    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };

    // Use the fetch API to access the database (the method is called in the ArticleController)
    let response = await fetch(ROOT + 'article/delete', myInit);
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