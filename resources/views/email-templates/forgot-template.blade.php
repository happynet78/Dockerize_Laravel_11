<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding: 20px 0;
            background-color: #0073e6;
            color: #FFFFFF;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .email-body h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body p {
            margin-bottom: 20px;
        }
        .reset-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            padding: 15px;
            text-align: center;
            background-color: #0073e6;
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 5px;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            color: #999999;
        }
        a {
            text-decoration: none;
        }
        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
        /* Responsive styling */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                padding: 10px !important;
            }
            .reset-button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Reset Your Password</h2>
        </div>
        <div class="email-body">
            <h4>Hello, {{ $user->name }}</h4>
            <p>You requested to reset your passowrd. Click the button below to reset it.</p>
            <a href="{{ $actionlink }}" target="_blank" class="reset-button">Reset Password</a>
            <p>
                This link is valid for 15 minutes.
            </p>
            <p>If you did not request a password reset, Please ignore this email or contact support if you hae questions.</p>
            <p>Thanks, <b>The Support Team</b></p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Larablog. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
