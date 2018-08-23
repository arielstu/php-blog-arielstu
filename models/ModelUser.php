<?php
class ModelUser extends Model
{
    public function cre($user_data = array())
    {
        $this->query = 'insert into users (
            user_name,
            first_name,
            email,
            birthday,
            country,
            pass,
            creation_date,
            update_date
        ) values(
            :user_name,
            :first_name,
            :email,
            :birthday,
            :country,
            :pass,
            :creation_date,
            :update_date
        )';

        $this->set_query($user_data);
    }

    public function upd($user_data = array())
    {
        $this->query = 'update users set
            user_name = :user_name,
            first_name= :first_name,
            email= :email,
            birthday= :birthday,
            country= :country,
            update_date= :update_date
            where user_id= :user_id';

        $this->set_query($user_data);
    }

    public function ban($user_data = array())
    {
        $this->query = 'update users set
            role=:role,
            update_date= :update_date
            where user_id= :user_id';

        $this->set_query($user_data);
    }

    public function del($user_data = '')
    {
        $this->query = 'delete from users where id=:id';
        $this->set_query($user_data);
    }

    public function rea($user_data = array())
    {
        $this->query = ($user_data != false) ? 'select user_id, user_name, first_name, email, photo, birthday, creation_date, country, role from users where user_id=:user_id and role<>"ban" order by creation_date desc' :
            'select user_id, user_name, first_name, email, photo, creation_date, country, role from users order by creation_date desc';
        if ($this->get_query($user_data)) {
            return $this->rows;
        }
        return false;
    }

    public function login($user_name = '', $user_pass = '')
    {
        $this->query = 'select user_id, user_name, first_name, email, creation_date, country, role, birthday,pass from users where  user_name=:user_name order by creation_date desc';

        if ($user_name != '') {
            if ($this->get_query($user_name)) {

                if (!empty($this->rows[0])) {
                    if (password_verify($user_pass, $this->rows[0]['pass'])) {

                        $this->rows[0]['pass'] == '';
                        $user_pass = '';
                        return $this->rows[0];
                    } else {
                        $this->rows = '';
                    }
                }
            }
        }
        return false;
    }

    public function exist_user($user_data = '')
    {
        $this->query = 'select user_id from users where (user_name=:user_name  or email=:email) and user_id!=:user_id order by creation_date desc';
        if ($user_data != '') if ($this->get_query($user_data)) return $this->rows;
        return false;
    }

    public function get_user_id($user_data = '')
    {
        $this->query = 'select user_id from users where user_id=:user_id order by creation_date desc';
        if ($user_data != '') if ($this->get_query($user_data)) return $this->rows;
        return false;
    }

    public function total_likes($user_data = '')
    {

        $this->query = 'select count(*) as len from points where author=:user_id';
        if ($this->get_query($user_data)) return $this->rows;
        return false;
    }
    public function total_comments($user_data = '')
    {

        $this->query = 'select count(*) as len from comments where author=:user_id';
        if ($this->get_query($user_data)) return $this->rows;
        return false;
    }


}