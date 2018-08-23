<?php
$crl_article = new ControllerArticle();
$article = $crl_article->rea_for_user([':author_id' => $_SESSION['user_id']]);
$n_articles = count($article);

if (isset($_POST['publicar'])) {
    if ($_POST['role'] == 'private') {
        $crl_article->publish([
            ':article_id' => $_POST['article_id'],
            ':author_id' => $_SESSION['user_id']
        ]);
        header('Location:' . $_SERVER['REQUEST_URI']);
    } else if ($_POST['role'] == 'public') {

        ?>
        <div class="sure">
            <h4 class="h-sure">Esta seguro de colocar en oculto el articulo</h4>
            <form action="" method="post" class="form-sure">
            <input type="submit" name="ocultar" value="si" class="btn-sisuer">
            <input type="hidden" name="article_id" value="<?= $_POST['article_id'] ?? '' ?>">
            </form>
            <a href="<?= $_SERVER['REQUEST_URI'] ?>" class="btn-nosure">No</a>
        </div>
        <?php

    }
}
if (isset($_POST['ocultar'])) {
    $crl_article->privatize([
        ':article_id' => $_POST['article_id'],
        ':author_id' => $_SESSION['user_id']
    ]);
    header('Location:' . $_SERVER['REQUEST_URI']);
}

$likes = 0;
$comments = 0;
$views = 0;
$public = 0;
$private = 0;
foreach ($article as $key) {
    $likes += $key['score'];
    $comments += $key['comments'];
    $views += $key['views'];
    if ($key['role'] == 'public') {
        $public++;
    } else {
        $private++;
    }
}
?>

<!--.......................... PANEL ARTICLE ..........................-->

<div class="panel-article">
<div class="cont-stadisticas">
    <h5 class="h-stadisticas">Estadisticas</h5>
    <span class="ind-stadist">articulos: <?= $n_articles ?></span>
    <span class="ind-stadist public">publico: <?= $public ?></span>
    <span class="ind-stadist private">privado: <?= $private ?></span>
    <span class="ind-stadist">puntos: <?= $likes ?></span>
    <span class="ind-stadist">comentarios: <?= $comments ?></span>
    <span class="ind-stadist">visitas: <?= $views ?></span>
</div>
<a href="<?= self::$root_home ?>new-article" class="btn-new-article">Crear articulo</a>
</div>
<!--.......................... PANEL ARTICLE ..........................-->

<!--.......................... PANEL user ..........................-->
<?php
$img_user = 'public/img/users/no-img.png';
if (file_exists('public/img/users/' . $_SESSION['user_id'] . '.jpg')) {
    $img_user = 'public/img/users/' . $_SESSION['user_id'] . '.jpg';
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
<h1 class="h1">Tus <span>entradas</span></h1>
<?php foreach ($article as $key) : ?>
<?php 
$crl_author = new ControllerUser();
$author = $crl_author->rea([':user_id' => $key['author']]);
$img = 'public/img/articles/no-cover.jpg';
if (file_exists('public/img/articles/' . $key['article_id'] . '.jpg')) {
    $img = 'public/img/articles/' . $key['article_id'] . '.jpg';
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


<!-- ................... PANEL_ENTRADA ................... .-->
<section class="panel-entrada">

    <a href="<?= self::$root_home ?>editar-articulo/<?= $key['article_id'] ?>" class="btn-editar-articulo ind-panel-entrada">editar</a>

    <a href="<?= self::$root_home ?>actualizar-portada/<?= $key['article_id'] ?>" class="btn-actialilar-portada ind-panel-entrada">actualizar portada</a>

    <form action="" method="post" class="form-publicar ind-panel-entrada">
        <input type="submit" name="publicar" class="btn-publicar" 
        value="<?php if ($key['role'] == 'public') echo 'Ocultar';
                else echo 'Publicar'; ?>">
        <input type="hidden" name="article_id" value="<?= $key['article_id'] ?>">
        <input type="hidden" name="role" value="<?= $key['role'] ?>">
    </form>

    <span class="span-public-date ind-panel-entrada">
    <?php
    if ($key['public_date'] == null) {
        echo '--.--.----';
    } else {
        echo strtok($key['public_date'], ' ');
    }
    ?>
    </span>


</section>
<!-- ................... PANEL_ENTRADA ................... .-->

<?php endforeach ?>
</main >

</div>