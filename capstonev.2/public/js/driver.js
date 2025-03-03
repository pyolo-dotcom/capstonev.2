// Get the modal
var modal = document.getElementById("addTripModal");

// Get the button that opens the modal
var btn = document.querySelector(".add-trip-btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// For delivery records modal
document.getElementById("openModal").addEventListener("click", function () {
    document.getElementById("tripModal").style.display = "block";
});

document.querySelector(".close").addEventListener("click", function () {
    document.getElementById("tripModal").style.display = "none";
});

// AJAX form submission with jQuery and SweetAlert
$(document).ready(function () {
    $('#tripForm').submit(function (e) {
        e.preventDefault(); // Prevent page reload

        $.ajax({
            url: tripStoreUrl, // Use the URL from the Blade template
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Reload the page after success
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON ? xhr.responseJSON.error : "Something went wrong!",
                });
            }
        });
    });
});
$(document).ready(function () {
    $("#plateNumberSelect").change(function () {
        var plateNo = $(this).val();

        $.ajax({
            url: "/get-trip-counts",
            type: "GET",
            data: { plate_no: plateNo },
            success: function (response) {
                $(".trip-summary .trip-card:nth-child(1) p").text(response.oneWayTrip);
                $(".trip-summary .trip-card:nth-child(2) p").text(response.roundTrip);
                $(".trip-summary .trip-card:nth-child(3) p").text(response.doorToDoorTrip);
            },
            error: function () {
                alert("Error fetching data. Please try again.");
            },
        });
    });
});