<p>Par <em><?= $news['auteur'] ?></em>, le <?= $news['dateAjout']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['titre'] ?></h2>
<p><?= nl2br($news['contenu']) ?></p>

<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
  <p style="text-align: right;"><small><em>Modifiée le <?= $news['dateModif']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } ?>
<hr textalign="center" width="100%" color="grey" size="1"> 
<h2>Commentaires</h2>

<br>
<?php
if (empty($comments))
{
?>
<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}
?>
<div class="container-comments">
<?php
foreach ($comments as $comment)
{
?>
<fieldset>
  <legend>
    <strong><?= htmlspecialchars($comment['auteur']) ?></strong><span class="comment_dot">•</span><?= $comment['date']->format('d/m/Y à H\hi') ?>
    <?php if ($user->isAuthenticated()) { ?><span class="comment_dot">•</span>
      <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a><span class="comment_dot">•</span>
      <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
    <?php } ?>
    <span class="comment_dot">•</span><a class="report-button" data-id="<?=$comment['id']?>">Signaler</a>
  </legend>
  <p class="comment_p" id="<?=$comment['id']?>"><?= htmlspecialchars(nl2br(($comment['contenu']))) ?></p>
</fieldset>
<hr textalign="center" width="100%" color="black" size="1.5">

<?php
}
?>
</div>
<h2>Ajouter un commentaire</h2>
<br>
<form action="" method="post">
  <div class="form-group">
    <?=$form?>
    <input type="submit" value="Commenter" class="btn btn-primary add-comment" data-id="<?=$news['id']?>" />
  </div>
</form>