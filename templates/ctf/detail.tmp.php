<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>CTF Detail Page from Template.</h2>

<ul>
    <li>
        Title: <?php assert(is_string($title)); $escape($title) ?>
    </li>
    <li>
        Status: <?php assert(is_string($status)); $escape($status) ?>
    </li>
</ul>
</body>
</html>
