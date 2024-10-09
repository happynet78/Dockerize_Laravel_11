<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shodow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4caf50;
            color: white;
            padding: 10px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #888888;
            font-size: 12px;
            padding: 10px 0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Change Confirmation</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>Your password has successfully changed. Hero are your updated login details:</p>
            <p><strong>Email/Username:</strong> {{ $user->email }} or {{ $user->username }}</p>
            <p><strong>Password:</strong> {{ $new_password }}</p>
            <p>If you did not request this change. please contact our support team immediately. </p>
        </div>
        <div class="footer">
            <p> Thank you for using service</p>
            <p>&&copy; {{ date('Y') }} Larablog. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
