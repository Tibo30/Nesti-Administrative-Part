document.addEventListener("DOMContentLoaded", function() {

    // -------------------------------- Display articles for an order --------------------------//  

    const myTable = document.querySelector("#allOrdersTable"); // get the table
    myTable.addEventListener('click', function() { // add event listener
        var orderId = event.target.parentNode.getAttribute('data-id'); // get the id of the parent node of the event target (td->tr)
        getOrderLines(orderId).then((response) => {
            if (response) {
                const divList = document.querySelector("#listOrderLines")
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
                document.querySelector("#idOrder").innerHTML = "N°: " + orderId;

            }
        });
    });

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
        let response = await fetch(ROOT + 'article/order', myInit);
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

});