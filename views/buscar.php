<?php
$pagina_actual = (isset($_GET['pag'])) ? $_GET['pag'] : 1;


$palabra = (isset($_GET['id'])) ? $_GET['id'] : '';
$palabra = trim($palabra);
if (empty($palabra)) {
    header('Location:' . self::$root_home);
} else {
    $paginacion = new Paginacion('buscar', 4, $pagina_actual, self::$root_home . 'buscar/' . $palabra . '/');
}
$crl_article = new ControllerArticle();
$article = $crl_article->rea_buscar([':title' => $palabra], $paginacion->inicio, $paginacion->post_por_pagina);

?>
<main class="entradas">
<h1 class="h1">Resultados de <span><?= $_GET['id'] ?></span></h1>

<?php foreach ($article as $key) : ?>
<?php 

$crl_author = new ControllerUser();
$author = $crl_author->rea([':user_id' => $key['author']]);
$img = self::$root_home . 'public/img/articles/no-cover.jpg';
if (file_exists('public/img/articles/' . $key['article_id'] . '.jpg')) {
    $img = self::$root_home . 'public/img/articles/' . $key['article_id'] . '.jpg';
}

?>
<article class="entrada">
<div class="left">
    <a href="<?= self::$root_home . 'articles/' . $key['article_id'] ?>" class="">
        <h2 class="title"><?= htmlentities($key['title']) ?></h2>
    </a>
    <p class="intro"><?= $key['intro'] ?></p>
</div>
<a href="" class="center">
    <img src="<?= $img ?>" alt="img del articulo" class="cover">
</a>
<div class="right">
    <span class="author"><?= htmlentities($author[0]['user_name']) ?></span>
    <span class="fecha"><?= strtok($key['creation_date'], ' ') ?></span>
    <div class="puntuaciones">
        <span class="vistas fi-eye" > <?= $key['views'] ?></span>
        <br>
        <span class="comentarios fi-comment"> <?= $key['comments'] ?></span>
        <br>
        <span class="puntuacion fi-check"> <?= $key['score'] ?></span>
    </div>
</div>
</article>
<?php endforeach ?>
<?= $paginacion->paginacion ?>
</main >


