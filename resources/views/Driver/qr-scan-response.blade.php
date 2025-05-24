<!DOCTYPE html>
<html>
<head>
    <title>QR Scan Response</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cargo = @json($cargo);
            
            // Format the cargo details for display
            let cargoDetails = `
                <div style="text-align: left;">
                    <p><strong>Plate No:</strong> ${cargo.plate_no}</p>
                    <p><strong>EIR No:</strong> ${cargo.eir_no}</p>
                    <p><strong>Container Van No:</strong> ${cargo.container_van_no}</p>
                    <p><strong>Size:</strong> ${cargo.size}</p>
                    <p><strong>Shipper/Consignee:</strong> ${cargo.shipper_consignee}</p>
                    <p><strong>Voyage Vessel:</strong> ${cargo.voyage_vessel}</p>
                    <p><strong>Voyage Number:</strong> ${cargo.voyage_no}</p>
                    <p><strong>Pickup Location:</strong> ${cargo.pickup_location}</p>
                    <p><strong>Delivery Location:</strong> ${cargo.delivery_location}</p>
                </div>
            `;
            
            Swal.fire({
                title: 'Cargo Details Stored!',
                html: cargoDetails,
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal-wide' // Optional: if you want to make the alert wider
                }
            }).then(() => {
                // Close the window/tab after user clicks OK
                window.close();
            });
        });
    </script>
    
    <style>
        .swal-wide {
            width: 600px !important;
        }
    </style>
</body>
</html>