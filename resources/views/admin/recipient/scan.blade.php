<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        #reader {
            width: 100%;
            height: auto;
            border: 2px dashed #007bff;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Scan QR Code</h1>
        <div id="reader"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('template_admin/js/html5-qrcode.min.js') }}"></script>
    <script src="{!! asset('css/app') !!}"></script>
    <script>
        let html5QrCode = new Html5Qrcode("reader");

        function startScanner() {
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess,
                onScanError
            ).catch((err) => {
                console.error("Tidak dapat memulai scanner: ", err);
            });
        }

        function stopScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    console.log("QR code scanner berhenti.");
                }).catch(err => {
                    console.log("Tidak dapat menghentikan scanner: " + err);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            try {
                $.ajax({
                    url: '/admin/qr-code/verification',
                    method: 'POST',
                    data: {
                        code: decodedText,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        let jsonData = JSON.parse(decodedText);
                        let idPenerima = jsonData["id penerima"];
                        if (response.status === 'success') {
                            $.ajax({
                                url: '/admin/qr-code/scanned/' + idPenerima,
                                method: 'POST',
                                data: {
                                    code: decodedText,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Verifikasi QR Code',
                                        text: 'QR Code berhasil diverifikasi!'
                                    }).then(() => {
                                        window.location.href =
                                            '{{ route('admin.log.recipient') }}';
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan!'
                        });
                    }
                });
            } catch (error) {
                console.error('Error:', error);
            }


            stopScanner();
        }

        let isErrorShown = false;

        function onScanError(errorMessage) {
            if (!isErrorShown) {
                console.error(`QR Code scan error: ${errorMessage}`);
                isErrorShown = true; // Tandai error telah ditampilkan
                setTimeout(() => {
                    isErrorShown = false; // Reset kondisi setelah beberapa waktu
                }, 3000); // 3000 ms = 3 detik
            }
        }

        window.onload = function() {
            startScanner();
        };
    </script>
</body>

</html>
