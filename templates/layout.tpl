<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$pageTitle|default:'Блог'} — Blogy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="/" class="header__logo">Blogy.</a>
        </div>
    </header>

    <main class="main">
        <div class="container">
            {block name=content}{/block}
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>Copyright &copy; {$smarty.now|date_format:"%Y"}. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
