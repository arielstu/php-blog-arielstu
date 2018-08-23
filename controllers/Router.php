<?php
class Router
{
    public $route;
    public $id;
    public static $root_home = 'http://localhost/arielstu/';
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['ok'])) $_SESSION['ok'] = false;

        if ($_SESSION['ok']) {
            $this->route = (isset($_GET['p'])) ? $_GET['p'] : 'home';
            $view = new ControllerView();
            switch ($this->route) {
                case 'home':

                    $view->load_view_on('home');
                    break;
                case 'articles':
                    $this->id = (isset($_GET['id'])) ? $_GET['id'] : '';
                    if ($this->id == '') {
                        $view::load_view_on('articles');
                    } else {
                        $view::load_view_on('single_on');
                    }
                    break;
                case 'logout':
                    if (isset($_POST['logout_si'])) {
                        session_start();
                        session_destroy();
                        header('location: ./');
                    }
                    $view->load_view_on('logout');
                    break;
                case 'user':
                    if ($_SESSION['role'] == 'admin') {
                        $view->load_view_on('user');
                    } else {
                        $view->load_view_on('user_normal');
                    }

                    break;
                case 'new-article':
                    if ($_SESSION['role'] == 'admin') {
                        $view->load_view_on('new-article');
                    } else {
                        header('Location:' . self::$root_home);
                    }
                    break;
                case 'actualizar-portada':

                    $this->id = (isset($_GET['id'])) ? $_GET['id'] : '';
                    $view::load_view_on('actualizar-portada');
                    break;
                case 'actualizar-img-perfil':
                    $this->id = (isset($_GET['id'])) ? $_GET['id'] : '';

                    if ($this->id == '') {
                        $view::load_view_on('404');
                    } else {
                        $view::load_view_on('actualizar-img-perfil');
                    }
                    break;
                case 'editar-articulo':
                    $this->id = (isset($_GET['id'])) ? $_GET['id'] : '';

                    if ($this->id == '') {
                        $view::load_view_on('404');
                    } else {
                        $view::load_view_on('editar-articulo');
                    }
                    break;
                case 'editar-user':
                    if (!isset($_POST['update-user'])) {
                        $view::load_view_on('editar-user');

                    } else {
                        $user = [];
                        $user['user_id'] = $_SESSION['user_id'];
                        $user['user_name'] = $_POST['user_name'];
                        $user['first_name'] = $_POST['first_name'];
                        $user['email'] = $_POST['email'];
                        $user['birthday'] = $_POST['birthday'];
                        $user['country'] = $_POST['country'];

                        $crl_user = new ControllerUser();
                        $mesage = $crl_user->upd($user);
                        if ($mesage !== true) {
                            $mesage = '<div class =
                        "mesage"> <ul class="error-list">' . $mesage . '</ul></div>';
                            $obj = $user;
                            $obj['mesage'] = $mesage;

                            $view::load_view_on('editar-user', $obj);
                        } else {
                            $model_user = new ModelUser();
                            $user_temp = $model_user->rea([':user_id' => $_SESSION['user_id']]);
                            $_SESSION['user_name'] = $user_temp[0]['user_name'];
                            $_SESSION['first_name'] = $user_temp[0]['first_name'];
                            $_SESSION['user_id'] = $user_temp[0]['user_id'];
                            $_SESSION['email'] = $user_temp[0]['email'];
                            $_SESSION['role'] = $user_temp[0]['role'];
                            $_SESSION['birthday'] = $user_temp[0]['birthday'];
                            $_SESSION['country'] = $user_temp[0]['country'];
                            $_SESSION['photo'] = $user_temp[0]['photo'];
                            $obj['mesage'] = '<h5 class =
                        "success-registro">Se a registrado correctamente<h5>';
                            $view::load_view_on('editar-user', $obj);
                        }
                    }
                    break;
                case 'buscar':
                    $view::load_view_on('buscar');
                    break;
                default:

                    $view->load_view_on('home');
            }
        } else {
            $this->route = (isset($_GET['p'])) ? $_GET['p'] : 'home';
            $view = new ControllerView();
            switch ($this->route) {
                case 'home':
                    $view::load_view_off('home');
                    break;
                case 'login':

                    if (!isset($_POST['user_name']) or !isset($_POST['pass'])) {

                        $view::load_view_off('login');
                    } else {
                        $user_name = [];
                        $user_name[':user_name'] = $_POST['user_name'];
                        $user_pass = $_POST['pass'];
                        $crl_user = new ControllerUser();
                        $obj = $crl_user->login($user_name, $user_pass);

                        if ($obj !== false) {
                            $_SESSION['ok'] = ture;
                            $_SESSION['user_name'] = $obj['user_name'];
                            $_SESSION['first_name'] = $obj['first_name'];
                            $_SESSION['user_id'] = $obj['user_id'];
                            $_SESSION['email'] = $obj['email'];
                            $_SESSION['role'] = $obj['role'];
                            $_SESSION['birthday'] = $obj['birthday'];
                            $_SESSION['country'] = $obj['country'];
                            $_SESSION['photo'] = $obj['photo'];

                            header('location:./');
                        } else {
                            $obj = [];
                            $obj['user_name'] = $_POST['user_name'];
                            $obj['mesage'] = '<div class =
                        "error-login"> <p> El usuario o contraseña no coincide </p></div>';
                            $view::load_view_off('login', $obj);
                        }
                    }
                    break;
                case 'registrarse':
                    if (!isset($_POST['registrarse'])) {
                        $view::load_view_off('registrarse');

                    } else {
                        $user = [];
                        $user['user_name'] = $_POST['user_name'];
                        $user['first_name'] = $_POST['first_name'];
                        $user['email'] = $_POST['email'];
                        $user['birthday'] = $_POST['birthday'];
                        $user['country'] = $_POST['country'];
                        $user['pass'] = $_POST['pass'];
                        $user['pass2'] = $_POST['pass2'];

                        $crl_user = new ControllerUser();
                        $mesage = $crl_user->cre($user);
                        if ($mesage !== true) {
                            $mesage = '<div class =
                        "mesage"> <ul class="error-list">' . $mesage . '</ul></div>';
                            $obj = $user;
                            $obj['mesage'] = $mesage;

                            $view::load_view_off('registrarse', $obj);
                        } else {
                            $obj['mesage'] = '<h5 class =
                        "success-registro">Se a registrado correctamente<h5>';
                            $view::load_view_off('registrarse', $obj);
                        }
                    }
                    break;
                case 'articles':
                    $this->id = (isset($_GET['id'])) ? $_GET['id'] : '';
                    if ($this->id == '') {
                        $view::load_view_off('articles');
                    } else {
                        $view::load_view_off('single_off');
                    }
                    break;
                case 'buscar':
                    $view::load_view_off('buscar');
                    break;
                default:
                    $view->load_view_off('home');
            }
        }
    }
} 