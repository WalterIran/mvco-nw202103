<?php

    namespace Controllers\Scores;

use Controllers\PrivateController;

/*
* Listado del WW para administrar las Partituras que estaran desplegadas en 
el catalogo.

/**
 * 
 * @category Public
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @version  CVS:1.0.0
 * @link     http://
 * 
 */ 
 


class Scores extends PrivateController{
    
    /**
     * Ejecuta el controlador de Scores
     * 
     * @return void 
     */
    

    public function run():void{

        $viewData = array();
        \Views\Renderer::render("scores/scores",$viewData);

    }
}

?>