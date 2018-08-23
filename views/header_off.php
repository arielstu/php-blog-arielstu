
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
                            <input type="text" name="text-buscar" class="text-header-buscar">
                            <label for="buscar" class="a fi-magnifying-glass""></label>
                            <input type="submit" name="buscar" class="btn-header-buscar" id="buscar">
                        </form>
                    </li>
                    <li class="li"><a href="<?= self::$root_home . 'login' ?>" class="a fi-torso"> login</a></li>
                    <li class="li"><a href="<?= self::$root_home . 'registrarse' ?>" class="a fi-torsos"> Registrarse</a></li>
                </ul>
            </nav>
        </div>
    </header>