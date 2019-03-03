<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>The BigLib</title>
    <link rel="stylesheet" href="src/ressources/style.css">
  </head>
  <body>
    <header>
      <h1>The BigLib</h1>
      <form action="index.html" method="post">
        <input type="text" name="search" value="" placeholder="Bare de racherche">
        <input type="submit" value="rechercher">
      </form>
      <ul>
        <li><a href="#">Connection</a></li>
        <li><a href="#">Inscription</a></li>
      </ul>
    </header>
    <main>
      <?php echo $title; ?>
      <?php echo $content; ?>
    </main>

    <footer>
      <ul>
        <li>A propos</li>
      </ul>

    </footer>
  </body>
</html>
