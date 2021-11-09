<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Score extends PublicController{

    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_scores",
            "Ocurrió algo inesperado. Intente Nuevamente."
        );
    }

    private function yeah()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_scores",
            "Operación ejecutada Satisfactoriamente!"
        );
    }

    public function run() :void
    {
        $viewData = array(
            "mode_dsc" => "",
            "mode" => "",
            "scoreid" => "",
            "scoredsc" => "",
            "scoreauthor" => "",
            "scoreyear" => "",
            "scoresales" => 0,
            "scoreprice" => 0.00,
            "scoredocurl" => "",
            "scoreest_ACT" => "",
            "scoreest_INA" => "",
            "scoreest_PLN" => "",
            "hasErrors" => false,
            "aErrors" => array(),
            "showaction" => true,
            "readonly" => false,
        );
        /* $viewData = \Dao\Mnt\Categorias::obtenerUnaCategoria($_GET["catid"]);
        $viewData["mode_dsc"] = $_GET["mode"];

        if($_GET["mode"] === "DSP"){
            $viewData["readonly"] = "disabled";
        } */

        if ($this->isPostBack()){
            //Se ejecuta al dar click sobre guardar
            $viewData["mode"] = $_POST["mode"];
            $viewData["scoreid"] = $_POST["scoreid"];
            $viewData["scoredsc"] = $_POST["scoredsc"];
            $viewData["scoreauthor"] = $_POST["scoreauthor"];
            $viewData["scoregenre"] = $_POST["scoregenre"];
            $viewData["scoreyear"] = (int)$_POST["scoreyear"];
            $viewData["scoresales"] = (int)$_POST["scoresales"];
            $viewData["scoreprice"] = (float)$_POST["scoreprice"];
            $viewData["scoredocurl"] = $_POST["scoredocurl"];
            $viewData["scoreest"] = $_POST["scoreest"];
            
            //Validaciones de Errores
            switch($viewData["mode"]){
                case "INS":
                    if ( \Dao\Mnt\Scores::crearScore(
                        $viewData["scoredsc"],
                        $viewData["scoreauthor"],
                        $viewData["scoregenre"],
                        $viewData["scoreyear"],
                        $viewData["scoresales"],
                        $viewData["scoreprice"],
                        $viewData["scoredocurl"],
                        $viewData["scoreest"]
                    ) ) 
                    {
                        $this->yeah();
                    }
                    break;
                case "UPD":
                    if ( \Dao\Mnt\Scores::editarScore(
                        $viewData["scoreid"],
                        $viewData["scoredsc"],
                        $viewData["scoreauthor"],
                        $viewData["scoregenre"],
                        $viewData["scoreyear"],
                        $viewData["scoresales"],
                        $viewData["scoreprice"],
                        $viewData["scoredocurl"],
                        $viewData["scoreest"]
                    ) ) 
                    {
                        $this->yeah();
                    }
                    break;
                case "DEL":
                    if ( \Dao\Mnt\Scores::eliminarScore($viewData["scoreid"]) ) 
                    {
                        $this->yeah();
                    }
                    break;
            }

        }else{
            //Se ejecuta si se refresca o viene la peticion
            //desde la lista
            if (isset($_GET["mode"])){
                $viewData["mode"] = $_GET["mode"];
            } else {
                $this->nope();
            }

            if (isset($_GET["scoreid"])) {
                $viewData["scoreid"] = $_GET["scoreid"];

            } else {
                if( $viewData["mode"] !== "INS" ) {
                    $this->nope();
                }
            }

        }
        
        //Hacer elementos en comun
        $modeDscArr = array(
            "INS" => "Nueva Partitura",
            "UPD" => "Editando Partitura (%s) %s",
            "DEL" => "Eliminando Partitura (%s) %s",
            "DSP" => "Detalle de Partitura (%s) %s",
        );

        if($viewData["mode"] === "INS") {
            $viewData["mode_dsc"] = $modeDscArr["INS"];
        } else {
            $tmpScore = \Dao\Mnt\Scores::obtenerUnaScore($viewData["scoreid"]);
            $viewData["scoredsc"] = $tmpScore["scoredsc"];
            $viewData["scoreauthor"] = $tmpScore["scoreauthor"];
            $viewData["scoregenre"] = $tmpScore["scoregenre"];
            $viewData["scoreyear"] = (int)$tmpScore["scoreyear"];
            $viewData["scoresales"] = (int)$tmpScore["scoresales"];
            $viewData["scoreprice"] = (float)$tmpScore["scoreprice"];
            $viewData["scoredocurl"] = $tmpScore["scoredocurl"];
            $viewData["scoreest"] = $tmpScore["scoreest"];
            //dd($tmpCategoria);
            $viewData["scoreest_ACT"] = $tmpScore["scoreest"] == "ACT" ? "selected" : "";
            $viewData["scoreest_INA"] = $tmpScore["scoreest"] == "INA" ? "selected" : "";
            $viewData["scoreest_PLN"] = $tmpScore["scoreest"] == "PLN" ? "selected" : "";
            $viewData["mode_dsc"] = sprintf(
                $modeDscArr[$viewData["mode"]],
                $viewData["scoreid"],
                $viewData["scoredsc"]
            );

            if( $viewData["mode"] == "DSP" ){
                $viewData["readonly"] = "readonly";
                $viewData["showaction"] = false;
            }
            if( $viewData["mode"] == "DSP" || $viewData["mode"] == "DEL"){
                $viewData["readonly"] = "readonly";
            }
        
        }

        Renderer::render("mnt/score", $viewData);
    }

}

?>