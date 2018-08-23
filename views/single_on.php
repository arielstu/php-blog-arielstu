<?php
$crl_articles = new ControllerArticle();

$article = $crl_articles->rea_for_user([':article_id' => $_GET['id']]);
$article = (!empty($article)) ? $article[0] : '';

$crl_author = new ControllerUser();
if ($article != '') {
    if ($article['role'] == 'private' && ($_SESSION['user_id'] != $article['author'])) {
        header('Location:' . self::$root_home);
    }
    $author = $crl_author->rea([':user_id' => $article['author']]);
    $crl_coments = new ControllerCommentary();
    $comentarios = $crl_coments->rea([':article_id' => $article['article_id']]);
    if ($comentarios === false) $comentarios = array();

    $crl_point = new ControllerPoint();
    $like = $crl_point->rea([':article_id' => $article['article_id'], ':author_id' => $_SESSION['user_id']]);

    if (isset($_POST['like']) and $like === false) {
        $crl_articles->plus_score(
            [':article_id' => $article['article_id']],
            [':valor' => '1', ':author_id' => $_SESSION['user_id'], ':article_id' => $article['article_id'], ':creation_date' => date('Y-m-d H:i:s', time()), ':update_date' => date('Y-m-d H:i:s', time())],
            false
        );
        header('Location:' . $_SERVER['REQUEST_URI']);
    } else if (isset($_POST['like']) and $like !== false) {
        if ($like[0]['valor'] == 1) {
            $crl_articles->less_score(
                [':article_id' => $article['article_id']],
                [':valor' => '0', ':update_date' => date('Y-m-d H:i:s', time()), ':author_id' => $_SESSION['user_id'], ':article_id' => $article['article_id']]
            );
            header('Location:' . $_SERVER['REQUEST_URI']);
        } else {
            $crl_articles->plus_score(
                [':article_id' => $article['article_id']],
                [':valor' => '1', ':update_date' => date('Y-m-d H:i:s', time()), ':author_id' => $_SESSION['user_id'], ':article_id' => $article['article_id']],
                true
            );
            header('Location:' . $_SERVER['REQUEST_URI']);
        }
    }

    if (isset($_POST['coment'])) {
        $msj = $crl_coments->cre([
            'plot' => $_POST['plot'],
            'author_id' => $_SESSION['user_id'],
            'article_id' => $article['article_id']
        ]);
        if ($msj === true) header('Location:' . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['delete_coment'])) {

        $flat = ($article['author'] == $_SESSION['user_id']) ? 'true' : 'false';
        $crl_coments->del([
            ':commentary_id' => $_POST['commentary_id'],
            ':author_id' => $_SESSION['user_id'],
            ':flat' => $flat
        ], [':article_id' => $article['article_id']]);

        header('Location:' . $_SERVER['REQUEST_URI']);
    }
    if ($article['role'] == 'public') $crl_articles->plus_views([':article_id' => $article['article_id']]);
    $img = self::$root_home . 'public/img/articles/no-cover.jpg';
    if (file_exists('public/img/articles/' . $article['article_id'] . '.jpg')) {
        $img = self::$root_home . 'public/img/articles/' . $article['article_id'] . '.jpg';
    }
}

$article = $crl_articles->rea_for_user([':article_id' => $_GET['id']]);
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
            <span class="score fi-check"> <?= $article['score'] ?></span>

            <?php if ($article['role'] == 'public') : ?>
            <?php if ($like !== false) : ?>
                <?php if ($like[0]['valor'] == 1) : ?>
                <form action="" method="post" class="form-like">
                    <label for="like" class=" like"> !Ya no te gusta¡</label>
                    <input type="submit" name="like" class="input-like" id="like">
                    
                </form>
                <?php else : ?>
                <form action="" method="post" class="form-like">
                    <label for="like" class=" no-like"> Dale a like</label>
                    <input type="submit" name="like" class="input-like" id="like">
                    
                </form>
                <?php endif; ?>
            <?php else : ?>
            <form action="" method="post" class="form-like">
                <label for="like" class=" no-like"> Dale a like</label>
                <input type="submit" name="like" class="input-like" id="like">
                
            </form>
            <?php endif; ?>
            <?php endif; ?>

        </div>
    </article>
    <?php if ($article['role'] == 'public') : ?>
    <section class="sec-comentarios">
        <form action="" method="post" class="form-cometario">
            <textarea name="plot" class="text-coment"></textarea>
            <input type="submit" name="coment" class="btn-coment" value="Comentar">
        </form>
        <div class="msj-error">
            <?= $msj ?? '' ?>
        </div>

        <div class="list-coments">
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
                    
                    <?php if (($key['author'] == $_SESSION['user_id']) or ($article['author'] == $_SESSION['user_id'])) : ?>
                    <div class="config-coment">
                        <form action="" method="post" class="form-delete-coment">
                            <input type="submit" name="delete_coment" class="btn-delete-coment" id="delete_coment" value="Eliminar">
                            <input type="hidden" value="<?= $key['commentary_id'] ?? '-1' ?>" name="commentary_id">
                        </form>
                    </div>
                    <?php endif; ?>
                    
                </div>
                
                
                
                <p class="plot-coment">
                    <?= $key['plot'] ?? '' ?>
                </p>
                
            </article>
        <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    
<?php endif; ?>
</main>