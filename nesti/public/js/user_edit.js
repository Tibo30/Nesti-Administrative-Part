// hide the notification after a click
var notifs = document.querySelectorAll(".notifications");
notifs.forEach(element =>
    element.addEventListener('click', (function (e) {
        console.log(e.target);
        if (e.target.getAttribute("id") == "userPasswordResetSuccess") {
            if (e.detail === 3) {
                element.hidden = true;;
            }
        } else {
            element.hidden = true;
        }
    }))
)

// -------------------------------- Edit user --------------------------// 

var formEditUser = document.querySelector("#editUserForm"); // get the form used to edit the user
// Event listener on the form
formEditUser.addEventListener('submit', (function (e) {
    event.preventDefault(); // stop the default action of the form
    const idUser = document.querySelector('#idUser').value;
    console.log(document.querySelector("#admin").checked);
    console.log(document.querySelector("#mod").checked);
    console.log(document.querySelector("#chief").checked);
    editUser(this, idUser).then((response) => {
        if (response) {
            if (response.success) {
                document.querySelector("#inputUserEditLastname").value = response.userLastname;
                document.querySelector("#inputUserEditFirstname").value = response.userFirstname;
                document.querySelector("#inputUserEditAddress1").value = response.userAddress1;
                document.querySelector("#inputUserEditAddress2").value = response.userAddress2;
                document.querySelector("#inputUserEditCity").value = response.userCity;
                document.querySelector("#inputUserEditPostcode").value = response.userPostcode;
                if (response.userRoles.indexOf('admin') != -1) {
                    document.querySelector("#admin").checked = true;
                }
                if (response.userRoles.indexOf('moderator') != -1) {
                    document.querySelector("#mod").checked = true;
                }
                if (response.userRoles.indexOf('chief') != -1) {
                    document.querySelector("#chief").checked = true;
                }
                if (response.userState == "a") {
                    document.querySelector("#userEditState").options.selectedIndex = 0;
                } else if (response.userState == "b") {
                    document.querySelector("#userEditState").options.selectedIndex = 1;
                } else if (response.userState == "w") {
                    document.querySelector("#userEditState").options.selectedIndex = 2;
                }


                document.querySelector("#errorUserEditLastname").innerHTML = "";
                document.querySelector("#errorUserEditFirstname").innerHTML = "";
                document.querySelector("#errorUserEditAddress1").innerHTML = "";
                document.querySelector("#errorUserEditAddress2").innerHTML = "";
                document.querySelector("#errorUserEditCity").innerHTML = "";
                document.querySelector("#errorUserEditPostcode").innerHTML = "";

                document.querySelector("#userEditSuccess").hidden = false;
            } else {
                document.querySelector("#errorUserEditLastname").innerHTML = response.errorMessages['userLastname'];
                document.querySelector("#errorUserEditFirstname").innerHTML = response.errorMessages['userFirstname'];;
                document.querySelector("#errorUserEditAddress1").innerHTML = response.errorMessages['userAddress1'];
                document.querySelector("#errorUserEditAddress2").innerHTML = response.errorMessages['userAddress2'];
                document.querySelector("#errorUserEditCity").innerHTML = response.errorMessages['userCity'];
                document.querySelector("#errorUserEditPostcode").innerHTML = response.errorMessages['userPostcode'];

                console.log(response.errorMessages)
            }
        }
        document.querySelector("#closeModalEdit").click();
    });
}))

/**
 * Ajax Request to edit the user
 * @param {form} obj, int idUser
 * @returns mixed
 */
async function editUser(obj, idUser) {
    var myHeaders = new Headers();

    let formData = new FormData(obj);
    formData.append('id_user', idUser);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'user/edituser', myInit);
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


// -------------------------------- Reset Password --------------------------// 


function resetPassword() {
    const idUser = event.target.getAttribute('data-id'); // get the id of the event target
    console.log(idUser);
    console.log(event.target)
    resetThePassword(idUser).then((response) => {
        if (response) {
            if (response.success) {
                document.querySelector("#userPasswordResetSuccess").hidden = false;
                document.querySelector("#userPasswordResetSuccess").innerHTML = "The new password is " + response.password + " ! Please, write it down before doing anything else ! (Triple click to close this window)";
            }
        }
        document.querySelector("#closeModalResetPassword").click();
    });
}

/**
 * Ajax Request to change state of a comment
 * @param int idUser
 * @returns mixed
 */
async function resetThePassword(idUser) {
    var myHeaders = new Headers();

    let formData = new FormData();
    formData.append('id_user', idUser);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'user/resetpassword', myInit);
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

// -------------------------------- Display articles for an order --------------------------//  

const myTable = document.querySelector("#allOrdersUserTable"); // get the table
if (myTable != null) {
    myTable.addEventListener('click', function () { // add event listener
        var orderId = event.target.parentNode.getAttribute('data-id'); // get the id of the parent node of the event target (td->tr)
        getOrderLines(orderId).then((response) => {
            if (response) {
                const divList = document.querySelector("#listOrderLinesUser")
                divList.innerHTML = "";
                if (response.success) {
                    response['articles'].forEach(element => {
                        const div = document.createElement("div");
                        div.innerHTML = element.all;
                        divList.appendChild(div); // add the articles lines to the divList
                    })
                } else {
                    const div = document.createElement("div");
                    div.innerHTML = "";
                    divList.appendChild(div); // if no response, empty the divList.
                }
                if (orderId == null) {
                    orderId = "";
                }
                document.querySelector("#idOrderUser").innerHTML = "N°: " + orderId;

            }
        });
    });
}

/**
 * Ajax Request to get the articles from the orderLines according to the order
 * @param int orderId
 * @returns mixed
 */
async function getOrderLines(orderId) {
    var myHeaders = new Headers();

    let formData = new FormData();
    formData.append('id_order', orderId);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'user/userorder', myInit);
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

// -------------------------------- Change state of a comment --------------------------//  

function changeState(state) {
    const idComment = event.target.getAttribute('data-id'); // get the id of the event target
    console.log(event.target);
    const td = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.previousSibling; // get td of state for this comment
    console.log(td);
    var btnclose; // get the btn close of the modal
    if (state == "a") {
        btnclose = document.querySelector("#closeModalApprove" + idComment);
    } else if (state == "b") {
        btnclose = document.querySelector("#closeModalBlock" + idComment);
    }

    changeStateComment(state, idComment).then((response) => {
        if (response) {
            if (response.success) {
                td.innerHTML = response.state;
                if (state == "a") {
                    document.querySelector("#commentApprovedSuccess").hidden = false;
                } else if (state == "b") {
                    document.querySelector("#commentBlockedSuccess").hidden = false;
                }
            }
        }
        btnclose.click();
    });
}

/**
 * Ajax Request to change state of a comment
 * @param int state, int idComment
 * @returns mixed
 */
async function changeStateComment(state, idComment) {
    var myHeaders = new Headers();

    let formData = new FormData();
    formData.append('state', state);
    formData.append('id_comment', idComment);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'user/usercomment', myInit);
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