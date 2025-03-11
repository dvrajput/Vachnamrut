<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Language selector -->
    <style>
        .language-selector {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 100;
        }
        
        .language-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 5px;
            transition: all 0.3s ease;
        }
        
        .language-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .language-btn.active {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="language-selector">
        <button class="language-btn" onclick="setLanguage('en')">EN</button>
        <button class="language-btn" onclick="setLanguage('gu')">ગુજ</button>
    </div>

    <div class="maintenance-container">
        <div class="maintenance-content">
            <div class="maintenance-icon">
                <i class="fas fa-tools"></i>
            </div>
            <h1 id="title">We'll be back soon!</h1>
            <div class="maintenance-message">
                <p id="message">
                    Sorry for the inconvenience. We're performing some maintenance at the moment. We'll be back online shortly!
                </p>
            </div>
            <p class="maintenance-footer" id="footer">
                — The SSGD Team
            </p>
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
    --border-color: rgba(215, 134, 27, 0.3);
    --timer-bg: #f8f8f8;
}

[data-theme="dark"] {
    --primary-color: #d7861b;
    --secondary-color: #2c3034;
    --text-color: #f8f9fa;
    --bg-gradient-start: #212529;
    --bg-gradient-end: #1a1d20;
    --shadow-color: rgba(0, 0, 0, 0.3);
    --border-color: rgba(215, 134, 27, 0.3);
    --timer-bg: #343a40;
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

.maintenance-container {
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
    padding: 20px;
    color: var(--text-color);
}

.maintenance-content {
    max-width: 700px;
    width: 90%;
    text-align: center;
    background-color: var(--secondary-color);
    padding: 50px 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px var(--shadow-color);
    position: relative;
    overflow: hidden;
}

.maintenance-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: var(--primary-color);
}

.maintenance-icon {
    font-size: 70px;
    color: var(--primary-color);
    margin-bottom: 25px;
    animation: pulse 2s infinite ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.maintenance-content h1 {
    font-size: clamp(28px, 5vw, 36px);
    color: var(--text-color);
    margin-bottom: clamp(20px, 3vw, 30px);
}

.maintenance-message {
    font-size: clamp(16px, 3vw, 18px);
    color: var(--text-color);
    opacity: 0.9;
    margin-bottom: clamp(30px, 4vw, 40px);
    padding: 0 15px;
    line-height: 1.6;
}

.maintenance-footer {
    font-style: italic;
    opacity: 0.7;
    margin-top: 20px;
    font-size: 16px;
}

@media (max-width: 480px) {
    .maintenance-container {
        padding: 15px;
    }
    
    .maintenance-content {
        width: 95%;
        padding: 30px 20px;
    }
    
    .language-selector {
        top: 10px;
        right: 10px;
    }
    
    .language-btn {
        padding: 6px 12px;
        font-size: 12px;
    }
}
</style>

<script>
// Check for saved theme preference or use light theme as default
document.addEventListener('DOMContentLoaded', function() {
    const theme = localStorage.getItem('theme') || 'light';
    
    if (theme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
    }
    
    // Set language based on saved preference or browser language
    const savedLang = localStorage.getItem('language');
    const browserLang = navigator.language || navigator.userLanguage;
    const lang = savedLang || (browserLang.startsWith('gu') ? 'gu' : 'en');
    
    setLanguage(lang);
    
    // Highlight active language button
    document.querySelectorAll('.language-btn').forEach(btn => {
        if (btn.innerText.toLowerCase() === lang) {
            btn.classList.add('active');
        }
    });
});

function setLanguage(lang) {
    const title = document.getElementById('title');
    const message = document.getElementById('message');
    const footer = document.getElementById('footer');
    
    // Store language preference
    localStorage.setItem('language', lang);
    
    // Update active button
    document.querySelectorAll('.language-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Find the button for the selected language and add active class
    if (lang === 'gu') {
        document.querySelector('.language-btn[onclick="setLanguage(\'gu\')"]').classList.add('active');
        // Gujarati content
        title.innerText = 'અમે જલ્દી પાછા આવીશું!';
        message.innerText = 'અસુવિધા બદલ અમે દિલગીર છીએ. અમે હાલમાં વેબસાઇટ અપડેટ કરી રહ્યા છીએ. અમે ટૂંક સમયમાં ફરી ઓનલાઇન થઈશું!';
        footer.innerText = '— SSGD ટીમ';
        document.documentElement.lang = 'gu';
    } else {
        document.querySelector('.language-btn[onclick="setLanguage(\'en\')"]').classList.add('active');
        // English content
        title.innerText = 'We\'ll be back soon!';
        message.innerText = 'Sorry for the inconvenience. We\'re performing some maintenance at the moment. We\'ll be back online shortly!';
        footer.innerText = '— The SSGD Team';
        document.documentElement.lang = 'en';
    }
}
</script>
</body>
</html>