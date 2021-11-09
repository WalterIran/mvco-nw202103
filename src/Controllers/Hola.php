<?php

    namespace Controllers;

    class Hola extends PublicController {

        public function run():void
        {
            $viewData = array("holaMundo"=>"Esto es Hola Mundo desde Controlador");
            \Views\Renderer::render("test/first",$viewData);
        }
    }

?>