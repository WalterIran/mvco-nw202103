<?php

namespace Controllers\Scores;

use Controllers\PrivateController;

/* 
*Listado del WW para administrar las Partituras que estarán desplegadas en el catálogo.
*/
class Scores extends PrivateController {
    
    /* 
        Ejecuta el Controlador de Scores

        @return void
    */
    public function run():void
    {
        $viewData = array();
        \Views\Renderer::render("scores/scores", $viewData);
    }
}

?>