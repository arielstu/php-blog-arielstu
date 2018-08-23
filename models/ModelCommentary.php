<?php
class ModelCommentary extends Model
{
    public function rea($comment_data = array())
    {

        $this->query = 'select * from comments where article=:article_id order by creation_date desc';


        if ($this->get_query($comment_data)) if (!empty($this->rows)) return $this->rows;
        return false;
    }
    public function del($comment_data = array(), $article_id = '')
    {

        try {
            $this->query = 'delete from comments where commentary_id=:commentary_id and (author=:author_id or :flat)';
            $this->set_query($comment_data);
            $article = new ModelArticle();
            $article->less_comment($article_id);
        } catch (Exception $e) {
            return false;
        }
    }
    public function cre($comment_data = array())
    {
        try {
            $this->query = 'insert into comments (plot, author, article, creation_date,update_date) values 
        (:plot, :author_id, :article_id, :creation_date, :update_date)';
            $this->set_query($comment_data);
            $article = new ModelArticle();
            $article->plus_comment([':article_id' => $comment_data[':article_id']]);
        } catch (Exception $e) {
            return false;
        }
    }
    public function upd($comment_data = array())
    {
        $this->query = 'update comments set plot=:plot, update_date=:update_date where commentary_id=:commentary_id';
        $this->set_query($comment_data);
    }
}