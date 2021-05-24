 // hide the notification after a click
 var notifs = document.querySelectorAll(".notifications");
 notifs.forEach(element =>
     element.addEventListener('click', (function(e) {
         element.hidden = true;
     }))
 )

 // -------------------------------- Connect user --------------------------// 

 var connectionForm = document.querySelector("#formConnection"); // get the form used to connect the user
 // Event listener on the form
 connectionForm.addEventListener('submit', (function(e) {
     event.preventDefault(); // stop the default action of the form
     connectUser(this).then((response) => {
         if (response) {
             if (response.success) {
                 window.location = ROOT + "recipe";
             } else {
                 if (response.notif) {
                     document.querySelector("#accountNotActive").hidden = false;
                     document.querySelector("#accountNotActive").innerHTML = "<p>" + response.notif + "</p>";
                 }
                 document.querySelector("#errorEmailUsername").innerHTML = response.errorMessages['emailUsername'];
                 document.querySelector("#errorPassword").innerHTML = response.errorMessages['password'];
             }
         }
     });
 }))

 /**
  * Ajax Request to connect the user
  * @param {form} obj
  * @returns mixed
  */
 async function connectUser(obj) {
     var myHeaders = new Headers();

     let formData = new FormData(obj);

     var myInit = {
         method: 'POST',
         headers: myHeaders,
         mode: 'cors',
         cache: 'default',
         body: formData
     };
     let response = await fetch(ROOT + 'connection', myInit);
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