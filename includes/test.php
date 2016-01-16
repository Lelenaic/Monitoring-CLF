

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>test</title>
  <link>
  <script></script>
</head>
<body>


 <?php

$requete ="SELECT * FROM `utilisateurs` ";
var_dump($requete);
$test = Connexion::query("$requete");

var_dump($test);


    ?>
</body>
</html>