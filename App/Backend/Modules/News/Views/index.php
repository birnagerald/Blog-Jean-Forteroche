<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>

<table class="minimalistBlack">
  <thead class="minimalistBlack">
    <tr class="minimalistBlack"><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
  </thead>
<?php
foreach ($listeNews as $news)
{
  echo '<tr><td>', $news['auteur'], '</td><td>', $news['titre'], '</td><td>le ', $news['dateAjout']->format('d/m/Y à H\hi'), '</td><td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi')), '</td><td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
}
?>
</table>
<hr>
<?php if ($user->hasFlash()) {
    echo '<p style="text-align: center;">', $user->getFlash(), '</p>';
}
?>
<p style="text-align: center">Il y a actuellement <?= $nombreCommentsReport ?> commentaires en attente de modération. En voici la liste :</p>

<table class="minimalistBlack">
  <thead class="minimalistBlack">
    <tr class="minimalistBlack"><th>Auteur</th><th>Contenu</th><th>Action</th></tr>
  </thead>
<?php
foreach ($listeCommentsReport as $comment)
{
  echo '<tr><td>', $comment['auteur'], '</td><td>', htmlspecialchars($comment['contenu']), '</td><td><a href="comment-update-', $comment['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="comment-delete-', $comment['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a> <a href="comment-valid-', $comment['id'], '.html"><img src="/images/valid.png" alt="Valider" /></a></td></tr>', "\n";
}
?>
</table>