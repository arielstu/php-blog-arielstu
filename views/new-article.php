<?php
if (isset($_POST['new-article'])) {
    $crl_article = new ControllerArticle();
    $msj = $crl_article->cre([
        'title' => $_POST['title'],
        'intro' => $_POST['intro'],
        'tags' => $_POST['tags'],
        'author' => $_SESSION['user_id'],
        'plot' => $_POST['plot'],
    ]);
    if ($msj === true) {
        header('Location:' . self::$root_home . 'user');
    } else {
        $msj = '<ul class="error-list">' . $msj . '</ul>';
    }
}
?>


<main class="main-new-article">
    <h1 class="h-new-article">Crear nuevo <span class="h-ex">articulo</span></h1>

    <form action="" method="post" class="form-new-article">
        <div class="group-new-article">
            <label for="title" class="title-new-article">Titulo:</label>
            <input type="text" id="title" name="title" class="inp-new-article inp-title" value="<?= $_POST['title'] ?? '' ?>" autocomplete="off">
        </div>
        <div class="group-new-article">
        <label for="intro" class="intro-new-article">Intro:</label>
        <textarea name="intro" id="intro" class="inp-new-article inp-intro"><?= $_POST['intro'] ?? '' ?></textarea>
        </div>
        <div class="group-new-article">
        <label for="tags" class="tags-new-article">Tags:</label>
        <input type="text" id="tags" name="tags" class="inp-new-article inp-tagas"  value="<?= $_POST['tags'] ?? '' ?>" autocomplete="off">
        </div>
        <div class="group-new-article">
        <label for="plot" class="plot-new-article">Articulo:</label>
        <textarea name="plot" id="plot" class="inp-new-article inp-plot"><?= $_POST['plot'] ?? '' ?></textarea>
        </div>
        <input type="submit" class="btn-new-article" name="new-article">
    </form>
    
        <?= $msj ?? '' ?>
    
</main>