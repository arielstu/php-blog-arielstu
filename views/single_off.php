<?php
$crl_articles = new ControllerArticle();
$article = $crl_articles->rea([':article_id' => $_GET['id']]);
$article = (!empty($article)) ? $article[0] : '';
$crl_coments = new ControllerCommentary();
$comentarios = $crl_coments->rea([':article_id' => $article['article_id']]);
if ($comentarios === false) $comentarios = array();
$crl_author = new ControllerUser();
if ($article != '') {
    $author = $crl_author->rea([':user_id' => $article['author']]);
    $crl_articles->plus_views([':article_id' => $article['article_id']]);
    $img = self::$root_home . 'public/img/articles/no-cover.jpg';
    if (file_exists('public/img/articles/' . $article['article_id'] . '.jpg')) {
        $img = self::$root_home . 'public/img/articles/' . $article['article_id'] . '.jpg';
    }
}

$article = $crl_articles->rea([':article_id' => $_GET['id']]);
$article = (!empty($article)) ? $article[0] : '';
?>

<main class="single">
<?php if ($article == '') : ?>
    <h2>No se encontro el articulo.</h2>
<?php else : ?>

    <article class="article-single">
        <h1 class="title"><?= htmlentities($article['title']) ?? '' ?></h1>
        <span class="author">Autor: <?= htmlentities($author[0]['user_name']) ?? '' ?></span>
        <span class="fecha">Fecha: <?= strtok($article['creation_date'], ' ') ?></span>
        <section class="cont_cover">
            <img src="<?= $img ?>" alt="" class="cover">
        </section>
            <div class="parrafo-single">
            <?= $article['plot'] ?? '' ?>
        </div>
        
        <div class="puntuaciones">
            <span class="vistas fi-eye"> <?= $article['views'] ?></span>
            <span class="comentarios fi-comment"> <?= $article['comments'] ?></span>
            <span class="puntuacion fi-check"> <?= $article['score'] ?></span>
        </div>
    </article>
    

    <section class="sec-comentarios">
    <?php foreach ($comentarios as $key) : ?>
        <?php
        $user = $crl_author->rea([':user_id' => $key['author']]);
        ?>
            <article class="coment_ind">
            <div class="datos-user">
                    <h4 class="user-coment"><?= $user[0]['user_name'] ?? 'anonimo' ?></h4>
                    <?php
                    $img_user = self::$root_home . 'public/img/users/no-img.png';
                    if (file_exists('public/img/users/' . $user[0]['user_id'] . '.jpg')) {
                        $img_user = self::$root_home . 'public/img/users/' . $user[0]['user_id'] . '.jpg';
                    }
                    ?>
                    <img src="<?= $img_user ?>" alt="imagen del usuario" class="img-user-comentario">
                    
                    <span class="fecha-coment">
                        <?= strtok($key['creation_date'], ' ') ?? '---' ?>
                    </span>
                </div>
                <p class="plot-coment">
                    <?= $key['plot'] ?? '' ?>
                </p>
                
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>


</main>