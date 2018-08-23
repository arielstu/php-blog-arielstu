<?php
class ControllerUser
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelUser();
    }

    public function cre($user_data = array())
    {
        $validator = new ValidatorUser();
        $validator->validate_cre($user_data);
        if ($validator->error_num == 0) {
            $this->model->cre($validator->getUser());
            return true;
        } else {
            return $validator->error_list;
        }
    }

    public function upd($user_data = array())
    {
        $validator = new ValidatorUser();
        $validator->validate_upd($user_data);
        if ($validator->error_num == 0) {
            $this->model->upd($validator->getUser());
            return true;
        } else {
            return $validator->error_list;
        }
    }

    public function del($user_data = array())
    {
        $this->model->del($user_data);
    }

    public function rea($user_data = array())
    {
        return $this->model->rea($user_data);
    }

    public function login($user_name = array(), $user_pass)
    {
        $user_name[':user_name'] = trim($user_name[':user_name']);
        $user_pass = trim($user_pass);
        return $this->model->login($user_name, $user_pass);

    }
    public function total_likes($user_data = array())
    {
        return $this->model->total_likes($user_data);
    }
    public function total_comments($user_data = array())
    {
        return $this->model->total_comments($user_data);
    }
}