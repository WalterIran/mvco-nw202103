<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Categoria extends PublicController{

    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_categorias",
            "Ocurrió algo inesperado. Intente Nuevamente."
        );
    }

    private function yeah()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_categorias",
            "Operación ejecutada Satisfactoriamente!"
        );
    }

    public function run() :void
    {
        $viewData = array(
            "mode_desc" => "",
            "mode" => "",
            "catid" => "",
            "catnom" => "",
            "catest_ACT" => "",
            "catest_INA" => "",
            "catest_PLN" => "",
            "hasErrors" => false,
            "Errors" => array(),
            "showaction" => true,
            "readonly" => false,
        );

        if ($this->isPostBack()){
            //Se ejecuta al dar click sobre guardar
            $viewData["mode"] = $_POST["mode"];
            $viewData["catid"] = $_POST["catid"] ;
            $viewData["catnom"] = $_POST["catnom"];
            $viewData["catest"] = $_POST["catest"];
            $viewData["xsrftoken"] = $_POST["xsrftoken"];

            //Validacion de XSRF token
            if(!isset($_SESSION["xsrftoken"]) || $viewData["xsrftoken"] !== $_SESSION["xsrftoken"]) {
                $this->nope();
            }

            //Validaciones de Errores
            if( \Utilities\Validators::IsEmpty($viewData["catnom"]) ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El nombre no puede ir vacío";
            }

            if ( $viewData["catest"] !== "INA" 
                && $viewData["catest"] !== "ACT" 
                && $viewData["catest"] !== "PLN" 
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "Estado de categoría incorrecto.";
            }

            if(!$viewData["hasErrors"]) {
                switch($viewData["mode"]){
                    case "INS":
                        if ( \Dao\Mnt\Categorias::crearCategoria($viewData["catnom"],$viewData["catest"]) ) 
                        {
                            $this->yeah();
                        }
                        break;
                    case "UPD":
                        if ( \Dao\Mnt\Categorias::editarCategoria($viewData["catnom"],$viewData["catest"],$viewData["catid"]) ) 
                        {
                            $this->yeah();
                        }
                        break;
                    case "DEL":
                        if ( \Dao\Mnt\Categorias::eliminarCategoria($viewData["catid"]) ) 
                        {
                            $this->yeah();
                        }
                        break;
                }
            }


        }else{
            //Se ejecuta si se refresca o viene la peticion
            //desde la lista
            if (isset($_GET["mode"])){
                $viewData["mode"] = $_GET["mode"];
            } else {
                $this->nope();
            }

            if (isset($_GET["catid"])) {
                $viewData["catid"] = $_GET["catid"];

            } else {
                if( $viewData["mode"] !== "INS" ) {
                    $this->nope();
                }
            }

        }
        
        //Hacer elementos en comun
        $modeDscArr = array(
            "INS" => "Nueva Categoría",
            "UPD" => "Editando Categoría (%s) %s",
            "DEL" => "Eliminando Categoría (%s) %s",
            "DSP" => "Detalle de Categoría (%s) %s",
        );

        if($viewData["mode"] === "INS") {
            $viewData["mode_desc"] = $modeDscArr["INS"];
        } else {
            $tmpCategoria = \Dao\Mnt\Categorias::obtenerUnaCategoria($viewData["catid"]);
            $viewData["catnom"] = $tmpCategoria["catnom"];
            //dd($tmpCategoria);
            $viewData["catest_ACT"] = $tmpCategoria["catest"] == "ACT" ? "selected" : "";
            $viewData["catest_INA"] = $tmpCategoria["catest"] == "INA" ? "selected" : "";
            $viewData["catest_PLN"] = $tmpCategoria["catest"] == "PLN" ? "selected" : "";
            $viewData["mode_dsc"] = sprintf(
                $modeDscArr[$viewData["mode"]],
                $viewData["catid"],
                $viewData["catnom"]
            );

            if( $viewData["mode"] == "DSP" ){
                $viewData["readonly"] = "readonly";
                $viewData["showaction"] = false;
            }
            if( $viewData["mode"] == "DSP" ){
                $viewData["readonly"] = "readonly";
            }
        
        }

        // Generar un token XSRF para evitar esos ataques
        $viewData["xsrftoken"] = md5("categoria" . random_int(10000,999999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];

        Renderer::render("mnt/categoria", $viewData);
    }

}

?>