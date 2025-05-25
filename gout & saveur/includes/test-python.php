<?php
$query = escapeshellarg("pizza");
$commande = "python indexer.py $query";
$resultat = shell_exec($commande);

echo "<h3>Test recherche PHP vers Python :</h3>";
echo "<pre>$resultat</pre>";
?>
