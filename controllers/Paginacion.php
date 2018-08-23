<?php
class Paginacion
{
    public $inicio;
    public $post_por_pagina;
    public $num_articulos;
    public $pagina_actual;
    public $paginas_totales;
    public $paginacion = '';

    public function __construct($route = 'home', $post_por_pagina = 5, $pagina_actual = 1, $link = 'http://localhost/arielstu/')
    {

        $this->pagina_actual = $pagina_actual;
        $this->post_por_pagina = $post_por_pagina;
        if ($route == 'home') {
            $this->num_articulos_home();
        } else if ($route == 'user') {
            $this->num_articulos_user();
        } else if ($route == 'like') {
            $this->num_articulos_user_like();
        } else if ($route == 'buscar') {
            $palabra = (isset($_GET['id'])) ? $_GET['id'] : '';
            $palabra = trim($palabra);

            $this->num_articulos_buscar($palabra);
        }

        $this->paginas_totales = ceil($this->num_articulos / $this->post_por_pagina);


        if (is_numeric($this->pagina_actual)) {
            $this->pagina_actual = (int)$this->pagina_actual;

        } else {
            $this->pagina_actual = 1;
        }
        $this->inicio = ($this->pagina_actual > 1) ? $this->pagina_actual * $this->post_por_pagina - $this->post_por_pagina : 0;

        $this->create_pagination($link);

    }

    public function num_articulos_home()
    {
        $model = new ModelArticle();
        $this->num_articulos = (int)$model->count_rea()[0]['len'];
    }
    public function num_articulos_user()
    {
        $model = new ModelArticle();
        $this->num_articulos = (int)$model->count_rea_for_user([':user_id' => $_SESSION['user_id']])[0]['len'];
    }
    public function num_articulos_user_like()
    {
        $model = new ModelArticle();
        $this->num_articulos = (int)$model->count_rea_for_user_like([':user_id' => $_SESSION['user_id']])[0]['len'];
    }
    public function num_articulos_buscar($palabra)
    {
        $model = new ModelArticle();
        $this->num_articulos = (int)$model->count_rea_buscar([':title' => $palabra])[0]['len'];
    }

    public function create_pagination($link = 'http://localhost/arielstu/')
    {
        $this->paginacion .= '<ul class="paginacion">';
        if ($this->paginas_totales <= 7) {
            if ($this->paginas_totales <= 1) {
                $this->paginacion = '';
            } else {
                for ($i = 1; $i <= $this->paginas_totales; $i++) {

                    if ($i == 1 && $this->pagina_actual != 1) {
                        $this->paginacion .= '<li class="li-paginacion"><a href="' . $link . ($this->pagina_actual - 1) . '" class="a-paginacion a-paginacion-act">&laquo;</a></li>';
                    } else if ($i == 1 && $this->pagina_actual = 1) {
                        $this->paginacion .= '<li class="li-paginacion li-paginacion-act">&laquo;</li>';
                    }


                    if ($this->pagina_actual == $i) {
                        $this->paginacion .= '<li class="li-paginacion li-paginacion-act">' . $i . '</li>';
                    } else {
                        $this->paginacion .= ' <li class =
                        "li-paginacion"> <a href = "' . $link . $i . '" class =
                        "a-paginacion"> ' . $i . ' </a> </li> ';
                    }


                    if ($i == $this->paginas_totales && $this->pagina_actual < $this->paginas_totales) {
                        $this->paginacion .= ' <li class =
                        "li-paginacion"> <a href = "' . $link . ($this->pagina_actual + 1) . '" class =
                        "a-paginacion a-paginacion-act">&raquo;
                        </a></li>';
                    } else if ($i == $this->paginas_totales && $this->pagina_actual >= $this->paginas_totales) {
                        $this->paginacion .= ' <li class =
                        "li-paginacion li-paginacion-act">&raquo;
                        </li>';
                    }
                }
            }
        } else {

            if ($this->pagina_actual <= 4) {
                if ($this->paginas_totales <= 1) {
                    $this->paginacion = '';
                } else {
                    for ($i = 1; $i <= 7; $i++) {

                        if ($i == 1 && $this->pagina_actual != 1) {
                            $this->paginacion .= '<li class="li-paginacion"><a href="' . $link . ($this->pagina_actual - 1) . '" class="a-paginacion a-paginacion-act">&laquo;</a></li>';
                        } else if ($i == 1 && $this->pagina_actual = 1) {
                            $this->paginacion .= '<li class="li-paginacion li-paginacion-act">&laquo;</li>';
                        }


                        if ($this->pagina_actual == $i) {
                            $this->paginacion .= '<li class="li-paginacion li-paginacion-act">' . $i . '</li>';
                        } else {
                            $this->paginacion .= ' <li class =
                            "li-paginacion"> <a href = "' . $link . $i . '" class =
                            "a-paginacion"> ' . $i . ' </a> </li> ';
                        }


                        if ($i == 7 && $this->pagina_actual != $this->paginas_totales) {
                            $this->paginacion .= ' <li class =
                            "li-paginacion"> <a href = "' . $link . ($this->pagina_actual + 1) . '" class =
                            "a-paginacion a-paginacion-act">&raquo;
                            </a></li>';
                        } else if ($i == $this->paginas_totales && $this->pagina_actual == $this->paginas_totales) {
                            $this->paginacion .= ' <li class =
                            "li-paginacion li-paginacion-act">&raquo;
                            </li>';
                        }
                    }
                }
            } else if ($this->pagina_actual > 4) {
                if (($this->pagina_actual + 3) >= $this->paginas_totales) {
                    for ($i = ($this->paginas_totales - 6); $i <= $this->paginas_totales; $i++) {

                        if ($i == ($this->paginas_totales - 6) && $this->pagina_actual != 1) {
                            $this->paginacion .= '<li class="li-paginacion"><a href="' . $link . ($this->pagina_actual - 1) . '" class="a-paginacion a-paginacion-act">&laquo;</a></li>';
                        } else if ($i == 1 && $this->pagina_actual = 1) {
                            $this->paginacion .= '<li class="li-paginacion li-paginacion-act">&laquo;</li>';
                        }


                        if ($this->pagina_actual == $i) {
                            $this->paginacion .= '<li class="li-paginacion li-paginacion-act">' . $i . '</li>';
                        } else {
                            $this->paginacion .= ' <li class =
                            "li-paginacion"> <a href = "' . $link . $i . '" class =
                            "a-paginacion"> ' . $i . ' </a> </li> ';
                        }


                        if ($i == $this->paginas_totales && $this->pagina_actual != $this->paginas_totales) {
                            $this->paginacion .= ' <li class =
                            "li-paginacion"> <a href = "' . $link . ($this->pagina_actual + 1) . '" class =
                            "a-paginacion a-paginacion-act">&raquo;
                            </a></li>';
                        } else if ($i == $this->paginas_totales && $this->pagina_actual == $this->paginas_totales) {
                            $this->paginacion .= ' <li class =
                            "li-paginacion li-paginacion-act">&raquo;
                            </li>';
                        }
                    }
                } else if (($this->pagina_actual + 3) < $this->paginas_totales) {
                    for ($i = ($this->pagina_actual - 3); $i <= ($this->pagina_actual + 3); $i++) {

                        if ($i == ($this->pagina_actual - 3) && $this->pagina_actual != 1) {
                            $this->paginacion .= '<li class="li-paginacion"><a href="' . $link . ($this->pagina_actual - 1) . '" class="a-paginacion a-paginacion-act">&laquo;</a></li>';
                        } else if ($i == 1 && $this->pagina_actual = 1) {
                            $this->paginacion .= '<li class="li-paginacion li-paginacion-act">&laquo;</li>';
                        }


                        if ($this->pagina_actual == $i) {
                            $this->paginacion .= '<li class="li-paginacion li-paginacion-act">' . $i . '</li>';
                        } else {
                            $this->paginacion .= ' <li class =
                            "li-paginacion"> <a href = "' . $link . $i . '" class =
                            "a-paginacion"> ' . $i . ' </a> </li> ';
                        }


                        if ($i == ($this->pagina_actual + 3) && $this->pagina_actual != $this->paginas_totales) {
                            $this->paginacion .= ' <li class =
                            "li-paginacion"> <a href = "' . $link . ($this->pagina_actual + 1) . '" class =
                            "a-paginacion a-paginacion-act">&raquo;
                            </a></li>';
                        } else if ($i == $this->paginas_totales && $this->pagina_actual == $this->paginas_totales) {
                            $this->paginacion .= ' <li class =
                            "li-paginacion li-paginacion-act">&raquo;
                            </li>';
                        }
                    }
                }
            }

        }
        $this->paginacion .= '</ul>';
    }

}
