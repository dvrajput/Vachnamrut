<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - {{ app()->getLocale() == 'gu' ? 'પૃષ્ઠ મળ્યું નથી' : 'Page Not Found' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="error-code">404</div>
            <h1>{{ app()->getLocale() == 'gu' ? 'પૃષ્ઠ મળ્યું નથી' : 'Page Not Found' }}</h1>
            <p class="error-message">
                {{ app()->getLocale() == 'gu' 
                    ? 'તમે જે પૃષ્ઠ શોધી રહ્યા છો તે અસ્તિત્વમાં નથી અથવા ખસેડવામાં આવ્યું છે.' 
                    : 'The page you\'re looking for doesn\'t exist or has been moved.' 
                }}
            </p>
            <a href="/" class="home-link">
                {{ app()->getLocale() == 'gu' ? 'હોમપેજ પર પાછા જાઓ' : 'Return to Homepage' }}
            </a>
        </div>
    </div>

<style>
:root {
    --primary-color: #d7861b;
    --secondary-color: #ffffff;
    --text-color: #333333;
    --bg-gradient-start: #ffffff;
    --bg-gradient-end: #f5f5f5;
    --shadow-color: rgba(215, 134, 27, 0.2);
}

[data-theme="dark"] {
    --primary-color: #d7861b;
    --secondary-color: #2c3034;
    --text-color: #f8f9fa;
    --bg-gradient-start: #212529;
    --bg-gradient-end: #1a1d20;
    --shadow-color: rgba(0, 0, 0, 0.3);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    height: 100%;
    width: 100%;
    overflow-x: hidden;
    font-family: 'Arial', sans-serif;
}

.error-container {
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
    padding: 20px;
    color: var(--text-color);
}

.error-content {
    max-width: 600px;
    width: 90%;
    text-align: center;
    background-color: var(--secondary-color);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px var(--shadow-color);
    position: relative;
    overflow: hidden;
}

.error-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: var(--primary-color);
}

.error-icon {
    font-size: 60px;
    color: var(--primary-color);
    margin-bottom: 20px;
}

.error-code {
    font-size: clamp(80px, 15vw, 120px);
    font-weight: bold;
    color: var(--primary-color);
    margin-bottom: clamp(10px, 2vw, 20px);
    line-height: 1;
    text-shadow: 3px 3px 0 var(--shadow-color);
}

.error-content h1 {
    font-size: clamp(24px, 5vw, 32px);
    color: var(--text-color);
    margin-bottom: clamp(10px, 2vw, 20px);
}

.error-message {
    font-size: clamp(16px, 3vw, 18px);
    color: var(--text-color);
    opacity: 0.8;
    margin-bottom: clamp(25px, 4vw, 35px);
    padding: 0 15px;
}

.home-link {
    display: inline-block;
    padding: clamp(12px, 2vw, 15px) clamp(25px, 4vw, 35px);
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(215, 134, 27, 0.3);
    font-size: clamp(14px, 2.5vw, 16px);
}

.home-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(215, 134, 27, 0.4);
}

.home-link:active {
    transform: translateY(0);
}

@media (max-width: 480px) {
    .error-container {
        padding: 15px;
    }
    
    .error-content {
        width: 95%;
        padding: 30px 20px;
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

<script>
// Check for saved theme preference or use system preference
document.addEventListener('DOMContentLoaded', function() {
    const theme = localStorage.getItem('theme') || 'light';
    
    if (theme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
    }
});
</script>
</body>
</html>