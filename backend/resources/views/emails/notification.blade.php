<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            color: #333333;
        }
        .email-container {
            background-color: #ffffff;
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            border: 1px solid #e4e4e4;
            border-radius: 5px;
        }
        .email-header {
            text-align: center;
            padding: 10px 0;
            background-color: #7b2cca;
            color: white;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 20px;
        }
        .button {
            display: inline-block;
            background-color: #7b2cca;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }
        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            padding: 20px;
            border-top: 1px solid #e4e4e4;
        }
        .email-footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h1>{{ $subject }}</h1>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <p>Hi {{ $user->name }},</p>
            <p>{{ $messageBody }}</p>

            @isset($transaction)
                <p><strong>Pickup:</strong> {{ $transaction['pickup'] }}</p>
                <p><strong>Delivery:</strong> {{ $transaction['delivery'] }}</p>
                <p><strong>Truck Size:</strong> ₦ {{ $transaction['truck_size'] }}</p>
                <p><strong>Weight:</strong> {{ $transaction['weight'] }}</p>
            @endisset

            <!-- Button -->
            @isset($actionUrl)
            <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
            @endisset
        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Rodudapp.com All rights reserved.</p>
            <p>If you did not request this, please ignore this email or contact support.</p>
        </div>
    </div>
</body>
</html>
