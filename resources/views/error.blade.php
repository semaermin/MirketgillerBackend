<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yetkiniz Yok - Mirketgiller</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f59e0b, #e68a00);
            background-size: cover;
            color: white;
        }

        .error-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 50px 60px;
            text-align: center;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
            max-width: 700px;
            width: 100%;
        }

        .error-card h1 {
            font-family: 'Roboto', sans-serif;
            font-size: 60px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #333; /* Başlık rengi koyulaştırıldı */
        }

        .error-card p {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 400;
            color: #555;
            margin-bottom: 30px;
        }

        .btn-back {
            background-color: #f59e0b;
            color: white;
            border-radius: 50px;
            padding: 18px 40px;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 18px;
            border: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background-color: #e68a00;
            transform: translateY(-3px);
        }

        .btn-back:focus {
            outline: none;
        }

        @media (max-width: 768px) {
            .error-card h1 {
                font-size: 40px;
            }

            .error-card p {
                font-size: 20px;
            }

            .btn-back {
                font-size: 16px;
                padding: 15px 35px;
            }
        }
    </style>
</head>

<body>

    <div class="error-container">
        <div class="error-card">
            <h1>Yetkiniz Yok</h1>
            <p>Bu sayfaya erişim izniniz bulunmamaktadır. Lütfen giriş yapın veya ana sayfaya dönün.</p>
            <a href="{{ url('admin/login') }}" class="btn btn-back">Giriş Yap</a>
            <a href="{{ url('/') }}" class="btn btn-back mt-3">Ana Sayfaya Dön</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
