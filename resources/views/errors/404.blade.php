<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-code">404</div>
            <h1>Page Not Found</h1>
            <p class="error-message">The page you're looking for doesn't exist or has been moved.</p>
            <a href="/" class="home-link">Return to Homepage</a>
        </div>
    </div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    height: 100%;
    width: 100%;
    overflow-x: hidden;
}

.error-container {
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    font-family: 'Arial', sans-serif;
    padding: 20px;
}

.error-content {
    max-width: 600px;
    width: 90%;
    text-align: center;
}

.error-code {
    font-size: clamp(100px, 15vw, 150px);
    font-weight: bold;
    color: #2d3436;
    text-shadow: 4px 4px 0px rgba(0,0,0,0.1);
    margin-bottom: clamp(10px, 2vw, 20px);
    animation: float 6s ease-in-out infinite;
}

.error-content h1 {
    font-size: clamp(24px, 5vw, 36px);
    color: #2d3436;
    margin-bottom: clamp(10px, 2vw, 20px);
}

.error-message {
    font-size: clamp(16px, 3vw, 18px);
    color: #636e72;
    margin-bottom: clamp(20px, 4vw, 30px);
    padding: 0 15px;
}

.home-link {
    display: inline-block;
    padding: clamp(12px, 2vw, 15px) clamp(20px, 4vw, 30px);
    background: #0984e3;
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(9, 132, 227, 0.3);
    font-size: clamp(14px, 2.5vw, 16px);
}

.home-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(9, 132, 227, 0.4);
}

@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
    100% {
        transform: translateY(0px);
    }
}

@media (max-width: 480px) {
    .error-container {
        padding: 15px;
    }
    
    .error-content {
        width: 95%;
    }
}

@media (max-height: 600px) {
    .error-container {
        padding: 10px;
    }
    
    .error-code {
        margin-bottom: 10px;
    }
    
    .error-message {
        margin-bottom: 15px;
    }
}
</style>
</body>
</html>