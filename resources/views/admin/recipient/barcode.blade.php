<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: auto;
            text-align: center;
            margin-top: 50px;
        }

        #countdown {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 20px;
        }

        img {
            margin: 20px 0;
            width: 250px;
            height: 250px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Scan QR Code untuk Verifikasi</h1>
        <img src="{{ $qrCode }}" alt="QR Code">
        <p>Kode berlaku selama:</p>
        <p id="countdown"></p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Countdown timer
            const expiration = new Date("{{ $expiration->toIso8601String() }}");
            const countdownElement = document.getElementById('countdown');

            const countdownInterval = setInterval(() => {
                const now = new Date();
                const timeLeft = expiration - now;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    countdownElement.innerText = "00:00";
                    alert("Kode QR telah kedaluwarsa!");
                    return;
                }

                const minutes = Math.floor(timeLeft / 60000);
                const seconds = Math.floor((timeLeft % 60000) / 1000);
                countdownElement.innerText =
                    `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }, 1000);

            // Polling status transaksi setiap 3 detik
            const transactionId = "{{ $recipient->id }}";

            const transactionStatusInterval = setInterval(() => {
                axios.get(`/admin/qr-code/scanned/${transactionId}`)
                    .then(response => {
                        const status = response.data.status;
                        // Jika transaksi berhasil, alert dan redirect
                        if (status === 1) {
                            clearInterval(transactionStatusInterval);
                            alert('Transaksi berhasil!');
                            window.location.href = '/admin/log/recipient';
                        }
                    })
                    .catch(error => {
                        console.error('Error checking transaction status:', error);
                    });
            }, 3000); // Cek status setiap 3 detik
        });
    </script>
</body>

</html>
