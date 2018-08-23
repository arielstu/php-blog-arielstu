
<?php
if (isset($_POST['buscar'])) {
    header('Location:' . self::$root_home . 'buscar/' . trim($_POST['text-buscar']));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Ariel Alvarado">
    <meta name="keywords" content="cine,misica,game,tegnologia">
    <meta name="description" content="<?= $description ?? 'blog personal dedicado a subir contenido de mi interes y de temas barios como cine, viedo juegos, tegnologias, entretenimiento en general' ?>">
    <title>Arielstu</title>
    <link rel="stylesheet" href="<?= self::$root_home . 'public/css/css.css' ?>">
    <link rel="stylesheet" href="<?= self::$root_home . 'public/fonts/foundation-icons.css' ?>">
</head>
<body>
    <header class="header">
        <div class="container container-header">
        <div >
            <a href="<?= self::$root_home ?>">
                <h3 class="log">Arielstu</h3>
            </a>
        </div>
            <nav class="main-nav">
                <ul class="ul">
                <li class="li">
                        <form action="" method="post" class="form-header-buscar">
                            <input type="text" name="text-buscar" class="text-buscar">
                            <label for="buscar" class="a fi-magnifying-glass""></label>
                            <input type="submit" name="buscar" class="btn-header-buscar" id="buscar">
                        </form>
                    </li>
                    <li class="li">
                    <?php
                    $img_user = self::$root_home . 'public/img/users/no-img.png';

                    if (file_exists('public/img/users/' . $_SESSION['user_id'] . '.jpg')) {

                        $img_user = self::$root_home . 'public/img/users/' . $_SESSION['user_id'] . '.jpg';
                    }
                    ?>
                        <img src="<?= $img_user ?>" alt="imagen de perfil" class="img-perfil-header">
                
                        <a class="a fi-torso" href="<?= self::$root_home . 'user' ?>">
                            <?= $_SESSION['user_name'] ?>
                        </a>
                    </li>
                    <li class="li">
                        <a href="<?= self::$root_home . 'buscar' ?>" class="a fi-magnifying-glass">
                            Buscar
                        </a>
                    </li>
                    
                    <li class="li">
                        <a class="a fi-arrow-right" href="<?= self::$root_home . 'logout' ?>">
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    