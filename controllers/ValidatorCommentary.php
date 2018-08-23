<?php

class ValidatorCommentary extends Validator
{
    public $commet = [];
    public function validate_cre_upd($data)
    {
        $data['plot'] = trim($data['plot']);
        if ($data['plot'] == '') {
            $this->error_list .= "<li>tienes que ingresar un comentario.</li>";
            $this->error_num++;
        }
        $this->length_text($data['plot'], 0, 255, 'comentario');

        if (!isset($data['creation_date'])) $data['creation_date'] = $this->now();
        $data['update_date'] = $this->now();

        foreach ($data as $key => $value) {
            $this->comment[':' . $key] = $value;
        }

        if ($this->error_num != 0) return false;
        return true;

    }
    private function now()
    {
        return date('Y-m-d H:i:s', time());
    }
}