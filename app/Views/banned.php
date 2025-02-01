<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banned user</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #ff4d4d;
        }

        p {
            font-size: 1rem;
            color: #333;
        }

        button {
            width: 300px;
            height: 30px;
            background-color: deepskyblue;
            border: none;
            color: #fff;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 1.5rem;
            }

            p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Banned</h1>
        <p>Maaf, akun anda sudah diblokir</p>
        <br>
        <a href="/logout">
        <button>Log Out</button>
        </a>
    </div>
</body>
</html>