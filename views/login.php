<main class="login">
    <section class="sec-login">
    
        <form action="" method="post" class="form_login" autocomplete="off">
        <h1 class="h-login">Ingresa con tus datos</h1>
            <div class="form-group">
                <label for="user_name" class="label-login">Nombre de usuario</label>
                <input  type="text" id="user_name" name="user_name" class="user-name-login inp-login" value="<?= $obj['user_name'] ?? '' ?>"  required autocomplete="off" placeholder="nombre de usuario">
            </div>
            <div class="form-group">
                <label for="pass" class="label-login">Contraseña</label>
                <input type="password" autocomplete="off" id="pass" class="pass-login inp-login" name="pass" required>
            </div>
            <input type="submit" name="login" value="Login" class="btn-login inp-login" >
        </form>
        <div class="sidebar-login">
            <div class="cont-sidebar-login">
                
            </div>
        </div>
        
    </section>
    <?= $obj['mesage'] ?? '' ?>
    <div class="opc-sub">
        
    <h3 class="h-sidebar-login">Si no estas registrado aun, ingresa en el siguiente link</h3>
                <a href="<?= self::$root_home ?>registrarse" class="a-sidebar-login">Registrate</a>
    </div>
</main>