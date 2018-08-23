<?php

abstract class Validator
{
    public $error_list = '';
    public $error_num = 0;


    public function length_text($text = '', $min = 5, $max = 10, $campo = '')
    {
        $length = strlen($text);
        if ($length < $min or $length > $max) {
            $this->error_list .= "<li>El campo ({$campo}) debe tener entre {$min} y {$max} caracteres y tiene {$length}</li>";
            $this->error_num++;
        }
    }

    public function format($patron, $text, $campo)
    {
        if (!preg_match($patron, $text)) {
            $this->error_list .= "<li>El campo ({$campo}) posee un formato invalido</li>";
            $this->error_num++;
        }
    }

    public function characters_bad($text, $campo)
    {
        if (!(strpos($text, ';') === false)) {
            $this->error_list .= "<li>El campo ({$campo}) posee caracteres invalidos</li>";
            $this->error_num++;
        }
        if (!(strpos($text, "'") === false)) {
            $this->error_list .= "<li>El campo ({$campo}) posee caracteres invalidos</li>";
            $this->error_num++;
        }
        if (!(strpos($text, '"') === false)) {
            $this->error_list .= "<li>El campo ({$campo}) posee caracteres invalidos</li>";
            $this->error_num++;
        }
    }


}