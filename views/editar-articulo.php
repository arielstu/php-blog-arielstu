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
$article['plot'] = str_replace('<br />', '', $article['plot']);

if (isset($_POST['edit-article'])) {

    $msj = $crl_article->upd([
        'title' => $_POST['title'],
        'intro' => $_POST['intro'],
        'tags' => $_POST['tags'],
        'plot' => $_POST['plot'],
        'creation_date' => $article['creation_date'],
        'article_id' => $article['article_id']
    ]);

    if ($msj === true) {
        header('Location:' . $_SERVER['REQUEST_URI']);
    } else {
        $msj = '<ul class="error-list">' . $msj . '</ul>';
    }
}


?>
<main class="main-editar-articulo">
<h1 class="h-new-article">Crear nuevo <span class="h-ex">articulo</span></h1>

    <form action="" method="post" class="form-new-article">
        <div class="group-new-article">
            <label for="title" class="title-new-article">Titulo:</label>
            <input type="text" id="title" name="title" class="inp-new-article inp-title" value="<?= $_POST['title'] ?? $article['title'] ?>" autocomplete="off">
        </div>
        <div class="group-new-article">
        <label for="intro" class="intro-new-article">Intro:</label>
        <textarea name="intro" id="intro" class="inp-new-article inp-intro"><?= $_POST['intro'] ?? $article['intro'] ?></textarea>
        </div>
        <div class="group-new-article">
        <label for="tags" class="tags-new-article">Tags:</label>
        <input type="text" id="tags" name="tags" class="inp-new-article inp-tagas"  value="<?= $_POST['tags'] ?? $article['tags'] ?>" autocomplete="off">
        </div>
        <div class="group-new-article">
        <label for="plot" class="plot-new-article">Articulo:</label>
        <textarea name="plot" id="plot" class="inp-new-article inp-plot"><?= $_POST['plot'] ?? $article['plot'] ?></textarea>
        </div>
        <input type="submit" class="btn-new-article" name="edit-article">
    </form>
    <?= $msj ?? '' ?>
</main>
