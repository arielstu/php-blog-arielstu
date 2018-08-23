<main class="main-registrarse">
    <form action="" class="form_registro" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_name" class="lab-form-registro">Nombre de usuario</label>
        <input type="text" name="user_name" class="user_name-registro inp-form-registro" id="user_name" placeholder="nombre de usuario" value="<?= $obj['user_name'] ?? $_SESSION['user_name'] ?>" required >
    </div>
    <div class="form-group">
        <label for="first_name" class="lab-form-registro">Primer nombre</label>
        <input type="text" id="first_name" name="first_name" class="first_name-registro inp-form-registro" placeholder="primer nombre" value="<?= $obj['first_name'] ?? $_SESSION['first_name'] ?>" required>
    </div>
    <div class="form-group">
        <label for="email" class="lab-form-registro">Correo</label>
        <input type="email" id="email" class="email-registro inp-form-registro" name="email" placeholder="correo" value="<?= $obj['email'] ?? $_SESSION['email'] ?>" required>
    </div>
    
    <div class="form-group">
        <label for="birthday" class="lab-form-registro">Fecha nacimiento</label>
        <input type="date" id="birthday" class="birthday-registo inp-form-registro" name="birthday" value="<?= $obj['birthday'] ?? $_SESSION['birthday'] ?>" required>
    </div>
    <div class="form-group">
        <label for="country" class="lab-form-registro">Pais</label>
        <input type="text" id="country" class="country-registro inp-form-registro" name="country" placeholder="pais" value="<?= $obj['country'] ?? $_SESSION['country'] ?>" required>
    </div>
    <input type="submit" name="update-user" class="btn-registrarse" value="Actualizar">
    <?= $obj['mesage'] ?? '' ?>
    </form>

</main>