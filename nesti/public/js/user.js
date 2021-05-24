// hide the notification after a click
var notifs = document.querySelectorAll(".notifications");
notifs.forEach(element =>
    element.addEventListener('click', (function(e) {
        element.hidden = true;
    }))
)

function allUserDelete() {
    let idUser = event.target.getAttribute('data-id');
    const td = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.previousElementSibling; // get td of state for this user
    deleteUser(idUser).then((response) => {
        if (response) {
            if (response.success) {
                td.innerHTML = response.state;
                document.querySelector("#userDeletedSuccess").hidden = false;
            }
        }
        document.querySelector("#closeModalDelete" + idUser).click();
    })
}


/**
 * Ajax Request to delete the User (change the status to blocked)
 * @param int idUser
 * @returns mixed
 */
async function deleteUser(idUser) {

    var myHeaders = new Headers();

    let formData = new FormData();
    formData.append('idUser', idUser);
    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };

    // Use the fetch API to access the database (the method is called in the UserController)
    let response = await fetch(ROOT + 'user/delete', myInit);
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