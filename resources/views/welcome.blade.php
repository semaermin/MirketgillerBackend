<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirketgiller - Admin Panel</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Poppins', sans-serif; /* Poppins genel yazı tipi olarak belirlendi */
            margin: 0;
            padding: 0;
        }

        .welcome-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f59e0b, #e68a00);
            background-size: cover;
            color: white;
        }

        .welcome-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 50px 60px;
            text-align: center;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
            max-width: 700px; /* Kartın genişliği artırıldı */
            width: 100%;
            transition: transform 0.3s ease-in-out;
        }

        .welcome-card:hover {
            transform: scale(1.05);
        }

        .header-logo {
            color: #f59e0b;
            font-family: 'Roboto', sans-serif; /* Roboto başlıklar için kullanıldı */
            font-size: 50px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .lead {
            font-size: 20px;
            font-weight: 400;
            margin-top: 15px;
            color: #555;
        }

        .btn-custom {
            background-color: #f59e0b;
            color: white;
            border-radius: 50px;
            padding: 18px 40px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 20px;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-custom:hover {
            background-color: #e68a00;
            transform: translateY(-3px);
        }

        .btn-custom:focus {
            outline: none;
        }

        @media (max-width: 768px) {
            .header-logo {
                font-size: 36px;
            }

            h2 {
                font-size: 30px;
            }

            .lead {
                font-size: 18px;
            }

            .btn-custom {
                font-size: 18px;
                padding: 15px 35px;
            }
        }
    </style>
</head>

<body>

    <div class="welcome-container">
        <div class="welcome-card">
            <div class="header-logo">
                Mirketgiller Admin Panel
            </div>
            <h2>Hoşgeldiniz!</h2>
            <p class="lead">Admin paneline giriş yapmak için aşağıdaki butona tıklayın. Kolayca yönetim paneline ulaşın.</p>
            <a href="{{ url('admin/login') }}" class="btn btn-custom mt-4">Giriş Yap</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
