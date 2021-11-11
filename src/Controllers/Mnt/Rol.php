<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Utilities\Site;
use Views\Renderer;

class Rol extends PublicController{
    
    private function nope()
    {
        Site::redirectToWithMsg("index.php?page=mnt_roles", "Error inesperado. Intente nuevamente.");
    }

    private function yup()
    {
        Site::redirectToWithMsg("index.php?page=mnt_roles", "Acción realizada exitosamente.");
    }

    public function run(): void
    {
        $viewData = array(
            "mode_dsc" => "",
            "rolescod" => "",
            "rolesdsc" => "",
            "rolesest" => "",
            
            "rolesest_ACT" => "",
            "rolesest_INA" => "",
            "hasErrors" => false,
            "aErrors" => array(),
            "showaction" => true,
            "readonly" => false,
            "isINS" => false,
            "isDEL" => false,
        );

        $modeDscArr = array(
            "INS" => "Nuevo rol",
            "UPD" => "Editando rol (%s) %s",
            "DEL" => "Eliminando rol (%s) %s",
            "DSP" => "Detalle de rol (%s) %s",
        );

        if($this->isPostBack()){
            $viewData["mode"] = $_POST["mode"];
            //$viewData["rolescod"] = $_POST["rolescod"];
            $viewData["rolescod"] = $_POST["rolescod"];
            $viewData["rolesdsc"] = $_POST["rolesdsc"];
            $viewData["rolesest"] = $_POST["rolesest"];
            if($viewData["mode"] == 'UPD'){
                $viewData["fnarr"] = explode(',',$_POST["FunctionAssignRoles"]); //User assigned roles
            }
            
            switch($viewData["mode"]){
                case 'INS':
                    if(\Dao\Mnt\Roles::createRol($viewData["rolescod"],$viewData["rolesdsc"], $viewData["rolesest"])){
                        $this->yup();
                    }
                    break;
                    case 'UPD':
                        if(\Dao\Mnt\Roles::updateRol($viewData["rolesdsc"], $viewData["rolesest"], $viewData["rolescod"]) 
                        && \Dao\Mnt\Roles::updateRolv2($viewData['fnarr'], $viewData["rolescod"])){
                            $this->yup();
                        }
                        break;
                        case 'DEL':
                            if(\Dao\Mnt\Roles::deleteRol($viewData["rolescod"])){
                                $this->yup();
                            }
                            break;
                
            }
        } else{
            if (isset($_GET["mode"])) {
                if (!isset($modeDscArr[$_GET["mode"]])) {
                    $this->nope();
                }
                $viewData["mode"] = $_GET["mode"];
            } 
            else {
                $this->nope();
            }

            if (isset($_GET["rolescod"])) {
                $viewData["rolescod"] = $_GET["rolescod"];
            } else {
                if ($viewData["mode"] !== "INS") {
                    $this->nope();
                }
            }
        }

        $tmpAvailableFunction = \Dao\Mnt\Roles::getFunctionsNotRol($viewData["rolescod"]);
        if($viewData["mode"] === "INS"){
            $viewData["avafun"] = $tmpAvailableFunction;
            $viewData["mode_dsc"] = $modeDscArr["INS"];
            $viewData["isINS"] = true;
        } else{
            $tmpRol = \Dao\Mnt\Roles::getRol($viewData["rolescod"]);
            $tmpListRol = \Dao\Mnt\Roles::getFunctionsRol($viewData["rolescod"]);

            //print_r($tmpListRol);
            $viewData["rolescod"] = $tmpRol["rolescod"];
            $viewData["rolesdsc"] = $tmpRol["rolesdsc"];
            $viewData["rolesest_ACT"] = $tmpRol["rolesest"] == "ACT" ? "selected" : "";
            $viewData["rolesest_INA"] = $tmpRol["rolesest"] == "INA" ? "selected" : "";
            $viewData["rolesfunction"] = $tmpListRol;
            
            $viewData["avafun"] = $tmpAvailableFunction;

            $viewData["mode_dsc"] = sprintf($modeDscArr[$viewData["mode"]], $viewData["rolescod"], $viewData["rolesdsc"], $viewData["rolesest"]);
            if($viewData["mode"] == "DSP"){
                $viewData["showaction"] = false;
                $viewData["readonly"] = "readonly";
            }
            if ($viewData["mode"] == "DEL") {
                $viewData["readonly"] = "readonly";
                $viewData["isDEL"] = true;
            }
            
        }
        
        Renderer::render("mnt/rol", $viewData);
        
    }
}
