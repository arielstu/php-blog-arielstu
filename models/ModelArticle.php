<?php

class ModelArticle extends Model
{
    public function rea($article_data = array(), $inicio = 0, $post_por_pagina = 5)
    {

        $this->query = ($article_data != false) ?
            'select article_id, title, plot, intro, author, cover, score, views, comments, tags, creation_date, update_date, public_date from articles where article_id=:article_id and role="public"'
            :
            'select article_id, title, intro, author, cover, score, views, comments, tags, creation_date, update_date, public_date from articles where role="public" order by public_date desc limit ' . $inicio . ',' . $post_por_pagina . '';
        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }
    public function rea_buscar($article_data = array(), $inicio = 0, $post_por_pagina = 5)
    {



        $this->query = 'select * FROM articles WHERE title LIKE  "%":title"%" and role="public" limit ' . $inicio . ',' . $post_por_pagina . '';


        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }

    public function count_rea()
    {
        $this->query = 'select count(*) as len from articles where role="public"';
        if ($this->get_query(array())) return $this->rows;
        return false;
    }
    public function count_rea_buscar($article_data = '')
    {


        $this->query = 'select count(*) as len FROM articles WHERE title LIKE  "%":title"%" and role="public"';

        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }

    public function rea_for_user($article_data = array())
    {
        if (!isset($article_data[':article_id'])) {
            $this->query = 'select article_id, title, plot, intro, author, cover, score, views, comments,role ,tags, creation_date, update_date, public_date from articles where author=:author_id and role<>"ban" order by creation_date desc';
        } else {
            $this->query = 'select article_id, title, plot, intro, author, cover, score, views, comments,role ,tags, creation_date, update_date, public_date from articles where role<>"ban" and article_id=:article_id order by creation_date desc';

        }
        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }
    public function count_rea_for_user($article_data = array())
    {
        $this->query = 'select count(*) as len from articles from articles where author=:author_id and role<>"ban"';
        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }
    public function count_rea_for_user_like($article_data = array())
    {
        $this->query = 'select count(*) as len from articles where article_id in (select article from points where author=:user_id  and valor="1") and role="public"';
        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }

    public function upd($article_data = array())
    {
        $this->query =
            'update articles set title=:title, plot=:plot, intro=:intro, tags=:tags, update_date=:update_date, creation_date=:creation_date where article_id=:article_id';
        $this->set_query($article_data);
    }

    public function ban($article_data = array())
    {
        $this->query =
            'update articles set role="ban" where article_id=:article_id';
        $this->set_query($article_data);
    }

    public function del($article_data = array())
    {
        $this->query =
            'delete from articles where article_id=:article_id';
        $this->set_query($article_data);
    }

    public function cre($article_data = array())
    {
        $this->query =
            'insert into articles (title,plot,intro,author,tags,creation_date,update_date) values 
            (:title,:plot, :intro,:author,:tags,:creation_date,:update_date)';
        $this->set_query($article_data);
    }

    public function plus_score($article_data = array(), $point_data = array(), $flat = false)
    {
        try {
            $m_point = new ModelPoint();
            if ($flat == false) {
                $m_point->cre($point_data);
            } else {
                $m_point->upd($point_data);
            }
            $this->query = 'update articles set score=score+1 where article_id = :article_id';
            $this->set_query($article_data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function less_score($article_data = array(), $point_data = array())
    {
        try {
            $m_point = new ModelPoint();
            $m_point->upd($point_data);
            $this->query = 'update articles set score=score-1 where article_id = :article_id';
            $this->set_query($article_data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function plus_comment($article_data = array())
    {
        $this->query = 'update articles set comments=comments+1 where article_id = :article_id';
        $this->set_query($article_data);
    }

    public function less_comment($article_data = array())
    {
        $this->query = 'update articles set comments=comments-1 where article_id = :article_id';
        $this->set_query($article_data);
    }

    public function plus_views($article_data = array())
    {
        $this->query = 'update articles set views=views+1 where article_id = :article_id';
        $this->set_query($article_data);
    }

    public function publish($article_data = array())
    {
        $this->query = 'update articles set role="public", public_date=:public_date where article_id = :article_id and author=:author_id and role="private"';
        $this->set_query($article_data);
    }
    public function privatize($article_data = array())
    {
        $this->query = 'update articles set role="private" where article_id = :article_id and author=:author_id and role="public"';
        $this->set_query($article_data);
    }
    public function get_articles_for_like($article_data = array(), $inicio = 0, $post_por_pagina = 5)
    {
        $this->query = 'select * from articles where article_id in (select article from points where author=:user_id  and valor="1") and role="public" limit ' . $inicio . ',' . $post_por_pagina . '';
        if ($this->get_query($article_data)) return $this->rows;
        return false;
    }
}