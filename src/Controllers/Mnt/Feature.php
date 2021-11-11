<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Feature extends PublicController{

    private function nope(){
        \Utilities\Site::redirectToWithMsg("index.php?page=mnt_features","Ocurrio algo inesperado. Intente nuevamente");
    }

    private function yeah($message){
        \Utilities\Site::redirectToWithMsg("index.php?page=mnt_features",$message);
    }
    public function run():void{

        $viewData=array(
            "mode_dsc"=>"",
            "mode"=>"",
            "fncod"=>"",
            "fndsc"=>"",
            "fnest" =>"",
            "fnest_ACT"=>"",
            "fnest_INA"=>"",
            "fntyp_CRT"=>"",
            "fntyp_PCR"=>"",
            "hasErrors"=>false,
            "Errors"=>array(),
            "showaction"=>true,
            "readonly"=>false,
            "isINS" => false,
            
        );

        $modeDscArr = array(
            "INS" => "Nueva Funcion",
            "UPD" => "Editando Funcion (%s) ",
            "DEL" => "Eliminando Funcion (%s) ",
            "DSP" => "Detalle de  Funcion (%s) ",
        );

        if($this->isPostBack()){
            //Se ejecuta al dar click sobre guardar
            $viewData["mode"]= $_POST["mode"];
            $viewData["fncod"]= $_POST["fncod"];
            $viewData["fndsc"]= $_POST["fndsc"];
            $viewData["fnest"]= $_POST["fnest"];
            $viewData["fntyp"]= $_POST["fntyp"];
           //dd($_POST);
            
            //Validaciones de Errores
            if(\Utilities\Validators::IsEmpty($viewData["fndsc"])){
                $viewData["hasErrors"]=true;
                $viewData["Errors"][] = "Descripcion no puede ir vacio!";
            }
/*
            if(($viewData["fnest"]=="INA" || $viewData["fnest"]=="ACT" ) ==false){
                $viewData["hasErrors"]=true;
                $viewData["Errors"][] = "Estado de Funcion Incorrecto";
             }
*/
            if(!$viewData["hasErrors"]){

                switch($viewData["mode"])
                {
                    case "INS":
                            if(\Dao\Mnt\Features::crearFunciones( $viewData["fncod"],$viewData["fndsc"],$viewData["fnest"],$viewData["fntyp"]))
                            {
                                $this->yeah("Funcion Creada");
                            }
                        break;

                    case "UPD":
                        if(\Dao\Mnt\Features::editarFuncion( $viewData["fncod"],$viewData["fndsc"],$viewData["fnest"],$viewData["fntyp"]))
                            {
                                $this->yeah("Funcion Actualizada");
                            }

                        break;

                    case "DEL":
                        if(\Dao\Mnt\Features::eliminarFuncion($viewData["fncod"]))
                            {
                                $this->yeah("Funcion Eliminada");
                            }
                        
                        break;
                            
                }
            }
            

        }
        else{
            //se ejecuta si se refresca o viene la peticcion desde la lista
            if(isset($_GET["mode"])){
                if(!isset($modeDscArr[$_GET["mode"]]))
                {
                    $this->nope();
                }
                $viewData["mode"]=$_GET["mode"];

            }
            else{
                //Redirigir si no viene algun mode
                $this->nope();//Funcion creada para redirigir
                //\Utilities\Site::redirectToWithMsg("index.php?page=mnt_categorias","Ocurrio algo inesperado. Intente nuevamente");
            }

            if(isset($_GET["fncod"])){
                $viewData["fncod"]=$_GET["fncod"];
                
            }
            else{
                if($viewData["mode"]!="INS"){
                    $this->nope();
                }
            }
        }

        //Hacer elementos en comun

       

        if($viewData["mode"]=="INS"){
            $viewData["mode_dsc"] = $modeDscArr["INS"];
            $viewData["isINS"] = true;
        }
        else
        {
            $tmpFuncion = \Dao\Mnt\Features::obtenerUnicaFuncion($viewData["fncod"]);
            /*
            print_r($tmpCategoria);
            die();
            */
            $viewData["fncod"]= $tmpFuncion["fncod"];
            $viewData["fndsc"]= $tmpFuncion["fndsc"];
            $viewData["fnest_ACT"]= $tmpFuncion["fnest"]=="ACT"?"selected":"";
            $viewData["fnest_INA"]= $tmpFuncion["fnest"]=="INA"?"selected":"";
            $viewData["fntyp_CRT"]= $tmpFuncion["fntyp"]=="CRT"?"selected":"";
            $viewData["fntyp_PCR"]= $tmpFuncion["fntyp"]=="PCR"?"selected":"";
            
            $viewData["mode_dsc"] = sprintf($modeDscArr[$viewData["mode"]],$viewData["fncod"]);

            if($viewData["mode"]=="DSP"){
                $viewData["showaction"]=false;
                $viewData["readonly"]="readonly";
            }

            if($viewData["mode"]=="DEL"){
                
                $viewData["readonly"]="readonly";
            }

            
        }

        
        Renderer::render("mnt/feature",$viewData);
    }
}


?>


