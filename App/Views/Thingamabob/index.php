<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CRUDy</title>
    </head>
    <body>
        <ul>
            <?php foreach ($thingamabobs as $thingamabob): ?>
                <li><?= htmlspecialchars($thingamabob); ?></li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>