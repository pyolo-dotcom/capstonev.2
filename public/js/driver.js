document.addEventListener("DOMContentLoaded", function () {
    // Get the assigned plate number from the page
    const plateNumber = $('#assignedPlateNumber').text().trim();
    
    // Ensure modal is hidden initially
    var modal = document.getElementById("tripModal");
    modal.style.display = "none";

    // Get the button that opens the modal
    var btn = document.getElementById("openModal");

    // Get the close button inside the modal
    var closeBtn = modal.querySelector(".close");

    // Open modal on button click
    btn.addEventListener("click", function () {
        // Check if plate number is assigned
        if (plateNumber === 'Not assigned') {
            Swal.fire({
                icon: 'error',
                title: 'No Plate Number Assigned',
                text: 'You cannot add trips without an assigned plate number',
            });
            return;
        }
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

    // Load initial trip counts if plate number is assigned
    if (plateNumber && plateNumber !== 'Not assigned') {
        fetchTripCounts(plateNumber);
    }
});

// Function to fetch trip counts
function fetchTripCounts(plateNo) {
    // Remove any spaces from plate number to match database format
    const formattedPlateNo = plateNo.replace(/\s+/g, '');
    
    $.ajax({
        url: '/get-trip-counts',
        type: 'GET',
        data: { 
            plate_no: formattedPlateNo 
        },
        success: function(response) {
            console.log('Trip counts loaded:', response);
            // Update the counts on the page
            $('.trip-card:nth-child(1) p').text(response.oneWayTrip || 0);
            $('.trip-card:nth-child(2) p').text(response.roundTrip || 0);
            $('.trip-card:nth-child(3) p').text(response.doorToDoorTrip || 0);
        },
        error: function(xhr) {
            console.error('Error fetching trip counts:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load trip counts',
            });
        }
    });
}

// AJAX form submission with jQuery and SweetAlert
$(document).ready(function () {
    $('#tripForm').submit(function (e) {
        e.preventDefault(); // Prevent page reload
        
        // Get the assigned plate number
        const plateNumber = $('#assignedPlateNumber').text().trim();
        
        if (plateNumber === 'Not assigned') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'You cannot add trips without an assigned plate number',
            });
            return;
        }

        // Prepare form data with the assigned plate number
        const formData = {
            plate_no: plateNumber.replace(/\s+/g, ''),
            trip_type: $('#trip_type').val(),
            num_trips: $('#num_trips').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: tripStoreUrl,
            method: "POST",
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Refresh trip counts after successful submission
                    fetchTripCounts(plateNumber);
                    // Reset form and close modal
                    $('#tripForm')[0].reset();
                    $('#tripModal').modal('hide');
                });
            },
            error: function (xhr) {
                let errorMessage = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                });
            }
        });
    });
});

// Disable "Add Trip" button if no plate number is assigned
$(document).ready(function() {
    const plateNumber = $('#assignedPlateNumber').text().trim();
    if (plateNumber === 'Not assigned') {
        $('#openModal').prop('disabled', true)
            .css('opacity', '0.7')
            .attr('title', 'You need an assigned plate number to add trips');
    }
});