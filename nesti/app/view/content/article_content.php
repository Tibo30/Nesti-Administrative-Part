<h1>Articles</h1>
<?php

foreach($articles as $article): ?>
<h2><?= $article->getIdProduct() ?></h2>
<time><?= $article->getCreationDate() ?> </time>
<?php endforeach; ?>
