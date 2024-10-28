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

        #result {
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Scan QR Code</h1>
        <div id="reader"></div>
        <div id="result" class="hidden">Hasil QR Code akan muncul disini</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('template_admin/js/html5-qrcode.min.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let html5QrCode = new Html5Qrcode("reader");

        // Fungsi untuk memulai scanner
        function startScanner() {
            html5QrCode.start({
                    facingMode: "environment"
                }, // Menggunakan kamera belakang
                {
                    fps: 10,
                    qrbox: 250
                }, // Pengaturan frame rate dan ukuran kotak QR
                onScanSuccess,
                onScanError
            ).catch((err) => {
                console.error("Tidak dapat memulai scanner: ", err);
            });
        }

        // Fungsi untuk menghentikan scanner
        function stopScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    console.log("QR code scanner berhenti.");
                }).catch(err => {
                    console.log("Tidak dapat menghentikan scanner: " + err);
                });
            }
        }

        // Fungsi yang dipanggil saat pemindaian berhasil
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('result').innerText = `Data Penerimaan Bantuan: ${decodedText}`;
            document.getElementById('result').classList.remove('hidden'); // Menampilkan hasil
            console.log(`Code scanned = ${decodedText}`, decodedResult);

            // AJAX untuk verifikasi QR code
            $.ajax({
                url: '/admin/qr-code/verification',
                method: 'POST',
                data: {
                    code: decodedText,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        axios.post('/admin/qr-code/scanned', {
                            code: decodedText
                        }).then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Verifikasi QR Code',
                                text: 'QR Code berhasil diverifikasi!'
                            });
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

            stopScanner(); // Hentikan scanner setelah pemindaian
        }

        // Fungsi yang dipanggil saat ada kesalahan saat pemindaian
        function onScanError(errorMessage) {
            console.error(`QR Code scan error: ${errorMessage}`);
        }

        // Memulai scanner saat halaman dimuat
        window.onload = function() {
            startScanner();
        };

        // Inisialisasi Pusher
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        // Berlangganan ke channel
        var channel = pusher.subscribe('qr-scanned');

        // Mendengarkan event broadcast 'qr-code-scanned'
        channel.bind('qr-code-scanned', function(data) {
            Swal.fire({
                icon: 'success',
                title: 'QR Code Dipindai',
                text: `QR Code ${data.code} berhasil diverifikasi!`
            }).then(() => {
                window.location.href = '{{ route('admin.recipient.index') }}';
            });
        });
    </script>
</body>

</html>
