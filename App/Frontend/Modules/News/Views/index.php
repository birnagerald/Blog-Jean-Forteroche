<?php
foreach ($listeNews as $news) {
    ?>
  <h2><a href="news-<?=$news['id']?>.html"><?=$news['titre']?></a></h2>
  <p><?=nl2br($news['contenu'])?></p>

<?php
}
?>

<nav aria-label="Page navigation example">
  <ul class="pagination">
  <?php

if ($currentPage == 1) {
    ?>
    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
    <?php
} else {
    ?>
    <li class="page-item"><a class="page-link" href="http://monsupersite/p-<?=($currentPage - 1)?>">Previous</a></li>
    <?php
}

foreach ($paginationLien as $page) {

    if ($currentPage == $page) {
        ?>
    <li class="page-item active"><a class="page-link" href="http://monsupersite/p-<?=$page?>"><?=$page?></a></li>
    <?php
}   else {
        ?>
    <li class="page-item"><a class="page-link" href="http://monsupersite/p-<?=$page?>"><?=$page?></a></li>

  <?php

    }

}

if ($currentPage == $lastPage) {
    ?>

  <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
  <?php
} else {
    ?>
  <li class="page-item"><a class="page-link" href="http://monsupersite/p-<?=$currentPage + 1?>">Next</a></li>
  <?php
}
?>
</ul>
</nav>