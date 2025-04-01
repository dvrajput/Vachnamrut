<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Your Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Your Feedback</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $name }},</p>
        
        <p>Thank you for reaching out to us with your feedback{{($songName ? ' regarding "' . $songName . '"' : '') .' kirtan'}}. We greatly appreciate your contribution to improving our service.</p>
        
        <p>Your input helps us enhance the experience for all users and make our platform better. We have reviewed your message and have taken appropriate action.</p>
        
        <p>If you have any other suggestions or concerns in the future, please don't hesitate to contact us again.</p>
        
        <p>Jay Swaminarayan,<br>
        The Kirtanavali Team</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>