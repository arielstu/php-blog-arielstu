<?php


if (isset($_POST['up-img-user'])) {

    $msj = '';
    if (empty($_FILES['img-user']['name'])) {
        $msj .= 'suba una imagen';
    } else {
        if ($_FILES['img-user']['size'] > 1048576) $msj .= '<li>La imagen debe pesar 1m o menos</li>';
        if ($_FILES['img-user']['type'] != 'image/jpeg') {
            $msj .= '<li>La imagen debe ser jpg</li>';
        } else {
            $dimentions = getimagesize($_FILES['img-user']['tmp_name']);
            if ($dimentions[0] < 500 or $dimentions[1] < 300) $msj .= '<li>la imagen debe tener 500px de ancho como minimo y 300px de alto como minimo</li>';
        }
    }


    if (empty($msj)) {
        $success = move_uploaded_file(
            $_FILES['img-user']['tmp_name'],
            'public/img/users/' . $_SESSION['user_id'] . '.jpg/'
        );
        $msj = '<ul class="ul-success-cover"><li>
                    La imagen se subio exitosamente.
                </li></ul>';
    } else {
        $msj = '<ul class="ul-error-cover">' . $msj . '</ul>';
    }
}
$img_user = self::$root_home . 'public/img/users/no-img.png';
if (file_exists('public/img/users/' . $_SESSION['user_id'] . '.jpg')) {
    $img_user = self::$root_home . 'public/img/users/' . $_SESSION['user_id'] . '.jpg';
}

?>
<main class="upd-cover">
<h1 class="h-upd-cover">actualizar imagen de usuario: <?= $_SESSION['user_name'] ?></h1>
<div class="img-user-actual">
    <img src="<?= $img_user ?>" alt="imagen actual" width="500px">
   
</div>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="img-user">
    <input type="submit" name="up-img-user" class="btn-up-img-user">
    <ul>
        <?= $msj ?? '' ?>
    </ul>
</form>
</main>



Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum totam labore a amet? Rem eligendi fuga dolorum quidem nam minus voluptatibus cupiditate quisquam, quam nobis velit molestias numquam beatae? Quae.lorem
Lorem ipsum dolor sit amet consectetur, adipisicing elit. Architecto, repudiandae. Nesciunt ipsa similique voluptate qui. Temporibus natus at quos quisquam, voluptates adipisci, amet tenetur maxime nobis ea neque perferendis nostrum.