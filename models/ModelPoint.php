<?php

class ModelPoint extends Model
{
    public function cre($point_data = array())
    {
        $this->query = 'insert into points (valor, author, article, creation_date, update_date) values 
        (:valor, :author_id, :article_id, :creation_date, :update_date)';
        $this->set_query($point_data);
    }

    public function rea($point_data = array())
    {
        $this->query = 'select valor from points where article=:article_id and author=:author_id';
        $this->get_query($point_data);
        return $this->rows;
    }

    public function upd($point_data = array())
    {
        $this->query = 'update points set valor=:valor, update_date=:update_date where author=:author_id and article=:article_id';

        $this->set_query($point_data);

    }
    public function del()
    {

    }
}