<?php
class ValidatorArticle extends Validator
{
    public $article = [];

    public function validate_cre_upd($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = trim($data[$key]);
            if ($data[$key] == '') {
                $this->error_list .= "<li>Debe llenar el campo {$key}.</li>";
                $this->error_num++;
            }
        }

        $this->length_text($data['title'], 5, 150, 'Titulo');
        $this->length_text($data['intro'], 5, 400, 'Intro');
        $this->length_text($data['tags'], 5, 100, 'tags');

        $this->format('/^[a-zA-Z0-9,]+$/', $data['tags'], 'etiquetas');

        if (!isset($data['creation_date'])) $data['creation_date'] = $this->now();
        $data['update_date'] = $this->now();
        $data['plot'] = nl2br($data['plot']);
        if ($this->error_num == 0) {
            foreach ($data as $key => $value) {
                $this->article[':' . $key] = $value;
            }
            return true;
        }
        return false;
    }

    private function now()
    {
        return date('Y-m-d H:i:s', time());
    }
}