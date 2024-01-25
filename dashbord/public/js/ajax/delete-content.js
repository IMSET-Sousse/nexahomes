function confirmContentDelete(id) {
    if (confirm("Are you sure you want to delete this product with ID " + id)) {
        deleteContent(id);
    }
}

function deleteContent(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "scripts/ajax/DeleteContent.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = xhr.responseText;

                if (response.trim() === 'true') { // Check if the response is 'true'
                    location.reload(true);
                } else {
                    alert("Error deleting product: " + response);
                }
            }
        }
    };
    xhr.send("productId=" + id);
}
