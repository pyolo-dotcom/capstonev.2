<!-- Modal Structure -->
<div id="tripModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeTripModal()">&times;</span>
        <h2>Edit Trip Details</h2>
        <form id="tripForm" method="POST" action="">
            @csrf
            @method('PUT')

            <input type="hidden" id="cargo_id" name="cargo_id">

            <div class="form-group">
                <label for="eir_no">EIR No.:</label>
                <input type="text" id="eir_no" name="eir_no" required>
            </div>

            <div class="form-group">
                <label for="container_van_no">Container Van No.:</label>
                <input type="text" id="container_van_no" name="container_van_no" required>
            </div>

            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" id="size" name="size" required>
            </div>

            <div class="form-group">
                <label for="shipper_consignee">Shipper/Consignee:</label>
                <input type="text" id="shipper_consignee" name="shipper_consignee" required>
            </div>

            <div class="form-group">
                <label for="voyage_vessel">Voyage Vessel:</label>
                <input type="text" id="voyage_vessel" name="voyage_vessel" required>
            </div>

            <div class="form-group">
                <label for="voyage_no">Voyage No.:</label>
                <input type="text" id="voyage_no" name="voyage_no" required>
            </div>

            <div class="form-group">
                <label for="pickup_location">Pickup Location:</label>
                <input type="text" id="pickup_location" name="pickup_location" required>
            </div>

            <div class="form-group">
                <label for="delivery_location">Delivery Location:</label>
                <input type="text" id="delivery_location" name="delivery_location" required>
            </div>

            <div class="form-row">
                <button type="submit">Update Trip</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Styles (CSS) -->
<style>
    /* Modal background */
    .modal {
        display: none;
        position: fixed;
        z-index: 10;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
    }

    /* Modal content */
    .modal-content {
        background-color: #fff;
        padding: 20px;
        width: 50%;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Close button */
    .close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 25px;
    color: #333;
    cursor: pointer;
}

.close-btn:hover {
    color: #000;
}

    /* Form styling */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #2f4156;
        font-size: 17px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
    }

    /* Submit button */
    .form-row {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }

    .form-row button {
        padding: 10px 20px;
        background-color: #004aad;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .form-row button:hover {
        background-color: #003a8c;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- jQuery & JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openTripModal(id, createdAt, eirNo, containerVanNo, size, shipperConsignee, voyageVessel, voyageNo, pickupLocation, deliveryLocation) {
        $("#cargo_id").val(id);
        $("#eir_no").val(eirNo);
        $("#container_van_no").val(containerVanNo);
        $("#size").val(size);
        $("#shipper_consignee").val(shipperConsignee);
        $("#voyage_vessel").val(voyageVessel);
        $("#voyage_no").val(voyageNo);
        $("#pickup_location").val(pickupLocation);
        $("#delivery_location").val(deliveryLocation);

        $("#tripForm").attr("action", `/manager/update-trip/${id}`);
        $("#tripModal").fadeIn();
    }

    function closeTripModal() {
        $("#tripModal").fadeOut();
    }

    // AJAX Form Submission
    $(document).ready(function () {
        $("#tripForm").submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            let formData = $(this).serialize();
            let formAction = $(this).attr("action");

            $.ajax({
                url: formAction,
                type: "POST",
                data: formData,
                success: function (response) {
                    Swal.fire("Success!", "Trip updated successfully!", "success");
                    closeTripModal();
                    setTimeout(() => location.reload(), 1000); // Reload table
                },
                error: function (error) {
                    Swal.fire("Error!", "Something went wrong!", "error");
                    console.log(error);
                }
            });
        });
    });
</script>
