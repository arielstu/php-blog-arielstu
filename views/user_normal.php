<?php
$crl_user = new ControllerUser();
$crl_article = new ControllerArticle();

$pagina_actual = (isset($_GET['id'])) ? $_GET['id'] : 1;
$paginacion = new Paginacion('like', 4, $pagina_actual, self::$root_home . 'user/');

$articles = $crl_article->get_articles_for_like([':user_id' => $_SESSION['user_id']], $paginacion->inicio, $paginacion->post_por_pagina);




$likes = 0;
$comments = 0;

$likes = $crl_user->total_likes([':user_id' => $_SESSION['user_id']])[0]['len'];
$comments = $crl_user->total_comments([':user_id' => $_SESSION['user_id']])[0]['len'];
?>

<!--.......................... PANEL ARTICLE ..........................-->
<div class="panel-article">
<div class="cont-stadisticas">
    <h5 class="h-stadisticas">Estadisticas</h5>
    <span class="ind-stadist">articulos que te gustan: <?= $likes ?></span>
    <span class="ind-stadist">comentarios que has dejado: <?= $comments ?></span>
</div>
</div>
<!--.......................... PANEL ARTICLE ..........................-->

<!--.......................... PANEL user ..........................-->
<?php
$img_user = self::$root_home . 'public/img/users/no-img.png';
if (file_exists('public/img/users/' . $_SESSION['user_id'] . '.jpg')) {
    $img_user = self::$root_home . 'public/img/users/' . $_SESSION['user_id'] . '.jpg';
}
$today = new DateTime();
$birthday = new DateTime($_SESSION['birthday']);
$edad = $today->diff($birthday);

?>
<div class="cont-user-entradas">
<aside class="aside-panel-user">
    
<div class="cont-img-name-user">
    <h1 class="h-name-user"><?= $_SESSION['user_name'] ?? 'Nombre de usuario' ?></h1>
    <img class="img-user" src="<?= $img_user ?>" alt="">
</div>
<div class="cont-a-span-h-user">
    <a href="<?= self::$root_home ?>actualizar-img-perfil/<?= $_SESSION['user_id'] ?>" class="a-user-ind">actualizar imagen</a>
    <h2 class="h-first-name"><?= $_SESSION['first_name'] ?></h2>
    <span class="span-edad-user span-user-ind">Edad: <?= $edad->y ?? '--' ?></span>
    <span class="span-country span-user-ind">pais: <?= $_SESSION['country'] ?></span>
    <span class="span-role span-user-ind">role: <?= $_SESSION['role'] ?></span>
    <a href="<?= self::$root_home ?>editar-user" class="a-user-ind">editar datos</a>
</div>
</aside>
<!--.......................... PANEL user ..........................-->

<!--.......................... MAIN ENTRADAS ..........................-->
<main class="main-entradas-user">
<h1 class="h1">Las entradas <span>que te gustan</span></h1>

<?php foreach ($articles as $key) : ?>
<?php 
$crl_author = new ControllerUser();
$author = $crl_author->rea([':user_id' => $key['author']]);
$img = self::$root_home . 'public/img/articles/no-cover.jpg';
if (file_exists(self::$root_home . 'public/img/articles/' . $key['article_id'] . '.jpg')) {
    $img = self::$root_home . 'public/img/articles/' . $key['article_id'] . '.jpg';
}
?>
<article class="entrada">
<div class="left">
    <a href="<?= self::$root_home . 'articles/' . $key['article_id'] ?>" class="">
        <h2 class="title"><?= htmlentities($key['title']) ?></h2>
    </a>
    
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
<?php endforeach; ?>
<?= $paginacion->paginacion ?>

</main>

</div>