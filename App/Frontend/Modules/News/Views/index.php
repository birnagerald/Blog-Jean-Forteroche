<?php
foreach ($listeNews as $news) {
    ?>
  <h2><a href="news-<?=$news['id']?>.html"><?=$news['titre']?></a></h2>
  <p><?=($news['contenu'])?></p>
  <hr>

<?php
}
?>

<nav aria-label="Index results pages">
  <ul class="pagination justify-content-center">
  <?php

if ($currentPage == 1) {
    ?>
    <li class="page-item disabled"><a class="page-link" href="#">Précédent</a></li>
    <?php
} else {
    ?>
    <li class="page-item"><a class="page-link" href="http://<?=$_SERVER['HTTP_HOST']?>/p-<?=($currentPage - 1)?>">Précédent</a></li>
    <?php
}

foreach ($paginationLien as $page) {

    if ($currentPage == $page) {
        ?>
    <li class="page-item active"><a class="page-link" href="http://<?=$_SERVER['HTTP_HOST']?>/p-<?=$page?>"><?=$page?></a></li>
    <?php
}   else {
        ?>
    <li class="page-item"><a class="page-link" href="http://<?=$_SERVER['HTTP_HOST']?>/p-<?=$page?>"><?=$page?></a></li>

  <?php

    }

}

if ($currentPage == $lastPage) {
    ?>

  <li class="page-item disabled"><a class="page-link" href="#">Suivant</a></li>
  <?php
} else {
    ?>
  <li class="page-item"><a class="page-link" href="http://<?=$_SERVER['HTTP_HOST']?>/p-<?=$currentPage + 1?>">Suivant</a></li>
  <?php
}
?>
</ul>
</nav>