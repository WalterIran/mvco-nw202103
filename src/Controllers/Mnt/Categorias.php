<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

//Conflicto por tener el mismo nombre de la clase
//use Dao\Mnt\Categorias;

class Categorias extends PublicController{

    public function run():void{

        $viewData=array();
        $viewData["items"]=\Dao\Mnt\Categorias::obtenerCategorias();
        //$viewData["items"]=Categorias::obtenerCategorias();
        $viewData["new_enabled"] = true;
        $viewData["edit_enabled"] = true;
        $viewData["delete_enabled"] = true;
        
        
        Renderer::render("mnt/categorias",$viewData);
    }
}


?>


