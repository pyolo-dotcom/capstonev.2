document.addEventListener("DOMContentLoaded", function () {
    // Ensure modal is hidden initially
    var modal = document.getElementById("tripModal");
    modal.style.display = "none";

    // Get the button that opens the modal
    var btn = document.getElementById("openModal");

    // Get the close button inside the modal
    var closeBtn = modal.querySelector(".close");

    // Open modal on button click
    btn.addEventListener("click", function () {
        modal.style.display = "flex"; // Show modal
    });

    // Close modal when clicking the close button
    closeBtn.addEventListener("click", function () {
        modal.style.display = "none"; // Hide modal
    });

    // Close modal when clicking outside the modal content
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
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