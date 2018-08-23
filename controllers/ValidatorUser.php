<?php
class ValidatorUser extends Validator
{

    public $user = [];

    public function validate_cre($user_data = array())
    {
        foreach ($user_data as $key => $value) {
            $user_data[$key] = trim($user_data[$key]);
            if ($user_data[$key] == '') {
                $this->error_list .= "<li>Debe llenar el campo {$key}.</li>";
                $this->error_num++;
            }
        }
        $this->length_text($user_data['user_name'], 8, 15, 'nombre de usuario');
        $this->length_text($user_data['first_name'], 8, 15, 'primer nombre');
        $this->length_text($user_data['email'], 5, 100, 'email');

        $this->length_text($user_data['country'], 3, 50, 'pais');
        $this->length_text($user_data['pass'], 8, 15, 'contraseña');

        $this->characters_bad($user_data['user_name'], 'nombre de usuario');
        $this->characters_bad($user_data['first_name'], 'primer nombre');
        $this->characters_bad($user_data['email'], 'email');

        $this->characters_bad($user_data['country'], 'pais');
        $this->characters_bad($user_data['pass'], 'contraseña');

        $this->format('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $user_data['email'], 'email');
        $this->format('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $user_data['birthday'], 'fecha de nacimiento');
        $this->format('/^[a-zA-Z]+$/', $user_data['country'], 'pais');
        $this->format('/^[a-zA-Z]+$/', $user_data['first_name'], 'primer nombre');

        $user_data['pass'] = $this->validatePasswords($user_data['pass'], $user_data['pass2']);

        $user_data['creation_date'] = $this->now();
        $user_data['update_date'] = $this->now();
        if ($this->error_num == 0) {

            foreach ($user_data as $key => $value) {
                if ($key != 'pass2') $this->user[':' . $key] = $value;
            }

            $tempUser = new ModelUser();
            if ($tempUser->exist_user([':user_name' => $this->user[':user_name'], ':email' => $this->user[':email']]) != false) {
                $this->error_list .= "<li>EL (Nombre de usuario) o (email) ya existen.</li>";
                $this->error_num++;

            }
        }


    }

    public function validate_upd($user_data = array())
    {
        foreach ($user_data as $key => $value) {
            $user_data[$key] = trim($user_data[$key]);
            if ($user_data[$key] == '') {
                $this->error_list .= "<li>Debe llenar el campo {$key}.</li>";
                $this->error_num++;
            }
        }

        $this->length_text($user_data['user_name'], 8, 15, 'nombre de usuario');
        $this->length_text($user_data['first_name'], 8, 15, 'primer nombre');
        $this->length_text($user_data['email'], 5, 100, 'email');

        $this->length_text($user_data['country'], 3, 50, 'pais');


        $this->characters_bad($user_data['user_name'], 'nombre de usuario');
        $this->characters_bad($user_data['first_name'], 'primer nombre');
        $this->characters_bad($user_data['email'], 'email');

        $this->characters_bad($user_data['country'], 'pais');


        $this->format('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $user_data['email'], 'email');
        $this->format('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $user_data['birthday'], 'fecha de nacimiento');
        $this->format('/^[a-zA-Z]+$/', $user_data['country'], 'pais');
        $this->format('/^[a-zA-Z]+$/', $user_data['first_name'], 'primer nombre');
        $user_data['update_date'] = $this->now();
        foreach ($user_data as $key => $value) {
            $this->user[':' . $key] = $value;
        }
        $tempUser = new ModelUser();
        if ($tempUser->get_user_id([':user_id' => $this->user[':user_id']]) == false) {
            $this->error_list .= "<li>EL usuario no existe.</li>";
            $this->error_num++;
        } else {
            if ($tempUser->exist_user([':user_name' => $this->user[':user_name'], ':email' => $this->user[':email'], ':user_id' => $this->user[':user_id']]) != false) {
                $this->error_list .= "<li>EL (Nombre de usuario) o (email) ya existen.</li>";
                $this->error_num++;
            }
        }

    }

    private function validatePasswords($pass1, $pass2)
    {
        if ($pass1 == $pass2) {
            $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
            return $pass1;
        } else {
            $this->error_list .= "<li>Las contraseñas no coinsiden.</li>";
            $this->error_num++;
            return '';
        }
    }

    private function now()
    {
        return date('Y-m-d H:i:s', time());
    }

    public function getUser()
    {
        if ($this->error_num == 0) {
            return $this->user;
        }
    }
}