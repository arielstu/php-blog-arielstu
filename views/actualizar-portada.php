<?php
$crl_article = new ControllerArticle();
$article = $crl_article->rea_for_user([':article_id' => $_GET['id']]);
$article = $article[0];

if (!empty($article)) {
    if ($article['author'] != $_SESSION['user_id']) {
        header('Locarion:' . self::$root_home);
    }
} else {
    header('Locarion:' . self::$root_home);
}
if (isset($_POST['up-cover'])) {

    $msj = '';
    if (empty($_FILES['cover']['name'])) {
        $msj .= 'suba una imagen';
    } else {
        if ($_FILES['cover']['size'] > 1048576) $msj .= '<li>La imagen debe pesar 1m o menos</li>';
        if ($_FILES['cover']['type'] != 'image/jpeg') {
            $msj .= '<li>La imagen debe ser jpg</li>';
        } else {
            $dimentions = getimagesize($_FILES['cover']['tmp_name']);
            if ($dimentions[0] < 500 or $dimentions[1] < 300) $msj .= '<li>la imagen debe tener 500px de ancho como minimo y 300px de alto como minimo</li>';
        }
    }

    if (empty($msj)) {
        $success = move_uploaded_file(
            $_FILES['cover']['tmp_name'],
            'public/img/articles/' . $article['article_id'] . '.jpg/'
        );
        $msj = '<ul class="ul-success-cover"><li>
                    La imagen se subio exitosamente.
                </li></ul>';
    } else {
        $msj = '<ul class="ul-error-cover">' . $msj . '</ul>';
    }
}
$img = self::$root_home . 'public/img/articles/no-cover.jpg';
if (file_exists('public/img/articles/' . $article['article_id'] . '.jpg')) {
    $img = self::$root_home . 'public/img/articles/' . $article['article_id'] . '.jpg';
}
?>
<main class="upd-cover">
<h1 class="h-upd-cover">actualizar portada del articulo: <?= $article['title'] ?></h1>
<div class="cover-actual">
    <img src="<?= $img ?>" alt="imagen actual" width="500px">
   
</div>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="cover">
    <input type="submit" name="up-cover" class="btn-up-cover">
    <ul>
        <?= $msj ?? '' ?>
    </ul>
</form>
</main>
