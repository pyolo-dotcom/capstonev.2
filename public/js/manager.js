document.addEventListener("DOMContentLoaded", function () {
    // Modal Management
    var modal = document.getElementById("tripModal");
    modal.style.display = "none";

    var btn = document.getElementById("openModal");
    var closeBtn = modal.querySelector(".close");

    btn.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});

// Fetch and Display Trip Counts on Plate Number Change
$(document).ready(function () {
    $("#plateNumberSelect").change(function () {
        var plateNo = $(this).val();

        $.ajax({
            url: "/get-trip-counts",
            type: "GET",
            data: { plate_no: plateNo },
            success: function (response) {
                $("#oneWayTripCount").text(response.oneWayTrip);
                $("#roundTripCount").text(response.roundTrip);
                $("#doorToDoorTripCount").text(response.doorToDoorTrip);
            },
            error: function () {
                alert("Error fetching data. Please try again.");
            },
        });
    });
});

// Filter Table Rows Based on Selected Plate Number
$(document).ready(function () {
    $("#tripTableBody tr").hide();

    $("#plateNumberSelect").on("change", function () {
        var selectedPlate = $(this).val().replace(/\s+/g, "");

        if (!selectedPlate) {
            $("#tripTableBody tr").hide();
            return;
        }

        $("#tripTableBody tr").hide();
        $("#tripTableBody tr").each(function () {
            let rowPlate = $(this).data("plate").toString().replace(/\s+/g, "");

            if (rowPlate === selectedPlate) {
                $(this).show();
            }
        });
    });
});

// Reset Button Functionality
$(document).ready(function () {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Open "Add Trip" Modal
    $("#openModal").click(function () {
        $("#tripModal").show();
    });

    // Close Modals
    $(".close").click(function () {
        $(".modal").hide();
    });

    // Submit "Add Trip" Form
    $("#tripForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: tripStoreUrl,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire("Success", response.message, "success");
                location.reload();
            },
            error: function (xhr) {
                Swal.fire("Error", "Failed to add trip.", "error");
            }
        });
    });

    // Reset Button
    $(".reset-btn").click(function () {
        let tripType = $(this).data("trip-type");
        let plateNo = $("#plateNumberSelect").val(); 

        if (!plateNo) {
            Swal.fire("Error", "Please select a plate number first.", "error");
            return;
        }

        plateNo = plateNo.replace(/\s+/g, ""); // Remove spaces from the plate number

        Swal.fire({
            title: "Are you sure?",
            text: `Reset all "${tripType}" trips for ${plateNo}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, reset it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/trips/reset",
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        plate_no: plateNo, // Send formatted plate number
                        trip_type: tripType
                    },
                    success: function (response) {
                        Swal.fire("Success", response.message, "success");
                        location.reload();
                    },
                    error: function (xhr) {
                        Swal.fire("Error", xhr.responseJSON.message || "Failed to reset trips.", "error");
                    }
                });
            }
        });
    });
});

// Filtering by Date (Weekly, Monthly, Annually)
document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".date-btn"); // Select all filter buttons
    const rows = document.querySelectorAll(".trip-table tbody tr"); // Select all table rows

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            filterButtons.forEach(btn => btn.classList.remove("active")); // Remove active class
            this.classList.add("active"); // Add active class to clicked button

            const filterType = this.textContent.toLowerCase(); // Get filter type: weekly, monthly, annually
            filterTable(filterType);
        });
    });

    function filterTable(filterType) {
        const today = new Date();
        rows.forEach(row => {
            const dateCell = row.querySelector(".trip-date"); // Get the date from trip-date class
            if (!dateCell) return; // Skip if no date cell found

            const rowDate = new Date(dateCell.textContent); // Convert to Date object

            let startDate, endDate;
            if (filterType === "weekly") {
                startDate = new Date();
                startDate.setDate(today.getDate() - today.getDay()); // Start of week (Sunday)
                endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 6); // End of week (Saturday)
            } else if (filterType === "monthly") {
                startDate = new Date(today.getFullYear(), today.getMonth(), 1); // First day of month
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0); // Last day of month
            } else if (filterType === "annually") {
                startDate = new Date(today.getFullYear(), 0, 1); // First day of year
                endDate = new Date(today.getFullYear(), 11, 31); // Last day of year
            }

            // Check if rowDate falls within startDate and endDate
            if (rowDate >= startDate && rowDate <= endDate) {
                row.style.display = ""; // Show row
            } else {
                row.style.display = "none"; // Hide row
            }
        });
    }
});

// Archive Trip Function
function archiveTrip(tripId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This trip will be archived and moved to the Archive Page.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Archive it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/manager/archive-trip/${tripId}`,
                type: "POST",
                data: {
                    _token: document.querySelector('meta[name="csrf-token"]').content
                },
                success: function(response) {
                    Swal.fire("Archived!", "The trip has been archived.", "success");
                    setTimeout(() => location.reload(), 1000); // Reload the page
                },
                error: function(error) {
                    Swal.fire("Error!", "Failed to archive trip.", "error");
                    console.log(error);
                }
            });
        }
    });
}
$(document).ready(function () {
    $(".update-btn").click(function () {
        let row = $(this).closest("tr");
    
        console.log("Row data attributes:", row[0].attributes); // Debugging
    
        let tripId = row.attr("data-id");  // Use `.attr()` instead of `.data()`
        console.log("Trip ID:", tripId); // Debugging
    
        if (!tripId || tripId === "undefined") {
            Swal.fire("Error", "Trip ID is missing from the row!", "error");
            return;
        }
    
        $("#trip_id").val(tripId);
        $("#update_plate_no").val(row.attr("data-plate").trim());
        $("#update_trip_type").val(row.attr("data-trip"));
        $("#update_num_trips").val(row.attr("data-num"));
    
        $("#updateModal").fadeIn();
    });
    
});
