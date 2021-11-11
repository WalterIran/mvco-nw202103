<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Usuario extends PublicController{

    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(

            "index.php?page=mnt_usuarios",
            "Ocurrió algo inesperado. Intente Nuevamente."
        );
    }

    private function yeah()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_usuarios",
            "Operación ejecutada Satisfactoriamente!"
        );
    }

    public function run() :void
    {
        $viewData = array(
            "mode_desc" => "",
            "mode" => "",
            'usercod' => '',
            'useremail' => '',
            'username' => '',
            'userpswd' => '',
            'userfching' => '',
            'userpswdexp' => '',
            'userest' => '',
            'useractcod' => '',
            'userpswdchg' => '',
            'userpswdrpt' => '',
            'usertipo' => '',
            "hasErrors" => false,
            "Errors" => array(),
            "showaction" => true,
            "readonly" => false,
        );

        if ($this->isPostBack()){
            $viewData["mode"] = $_POST["mode"]; //Form behavior mode
            $viewData['usercod'] = $_POST['usercod'] ; //User code
            $viewData['useremail'] = $_POST['useremail'] ; //User Email
            $viewData['username'] = $_POST['username'] ; //User Name
            $viewData['userpswd'] = $_POST['userpswd'] ; //User password
            $viewData['userpswdexp'] = $_POST['userpswdexp'] ; //User password expire
            $viewData['userest'] = $_POST['userest'] ; //User Status (ACT, INA,...)
            $viewData['usertipo'] = $_POST['usertipo'] ; //User type (PBL, ADM, AUDS)
            $viewData["userpswdest"] = $_POST['userpswdest'] ; //User password status
            $viewData["userpswdchg"] = date('Y-m-d H:i:s'); //User password change datetime
            $viewData["userroles"] = explode(',',$_POST["userAssignRoles"]); //User assigned roles
            $viewData["userpswdrpt"] = $_POST["userpswdrpt"]; //User password repeat

            if($viewData["userpswdrpt"] != $viewData["userpswd"]){
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "Contraseña y repetir contraseña deben ser iguales";
            }

            if(!$viewData["hasErrors"]){

                switch($viewData["mode"]){
                    case "INS":
                        if (\Dao\Security\Security::newUsuario($viewData['useremail'],$viewData['userpswd'],$viewData['username'],$viewData['userpswdexp'],$viewData["userpswdest"],$viewData['userest'],$viewData['usertipo']) ) 
                        {
                            $this->yeah();
                        }
                        break;
                    case "UPD":
                        if (isset($_POST["chgPswd"]) && \Dao\Mnt\Usuarios::editUsuario(
                            $viewData['usercod'],
                            $viewData['useremail'],
                            $viewData['username'],
                            $viewData['userpswd'],
                            $viewData["userpswdest"],
                            $viewData['userpswdexp'],
                            $viewData["userpswdchg"],
                            $viewData['userest'],
                            $viewData['usertipo']) 
                        
                            && \Dao\Mnt\Usuarios::editUserRoles($viewData['usercod'], $viewData["userroles"])
                        ) 
                        {
                            $this->yeah();
                        }else if(\Dao\Mnt\Usuarios::editUsuarioNoPswd(
                            $viewData['usercod'],
                            $viewData['useremail'],
                            $viewData['username'],
                            $viewData["userpswdest"],
                            $viewData['userpswdexp'],
                            $viewData['userest'],
                            $viewData['usertipo'])
                            && \Dao\Mnt\Usuarios::editUserRoles($viewData['usercod'], $viewData["userroles"])
                        ) 
                        {
                            $this->yeah();
                        }
                        break;
                    case "DEL":
                        if ( \Dao\Mnt\Usuarios::deleteUsuario($viewData['usercod']) ) 
                        {
                            $this->yeah();
                        }
                        break;
                }
            }
        } else {
            if (isset($_GET["mode"])){
                $viewData["mode"] = $_GET["mode"];
            } else {
                $this->nope();
            }
            if (isset($_GET['usercod'])) {
                $viewData['usercod'] = $_GET['usercod'];

            } else {
                if( $viewData["mode"] !== "INS" ) {
                    dd("No bicho");
                    $this->nope();
                }
            }
        }

        $modeDscArr = array(
            "INS" => "Nuevo usuario",
            "UPD" => "Editando usuario (%s)",
            "DEL" => "Eliminando usuario (%s)",
            "DSP" => "Detalle de usuario (%s)",
        );
        $tmpAvailableRoles = \Dao\Mnt\Usuarios::getRolesNotUser($viewData["usercod"]);
        if($viewData["mode"] === "INS") {
            $viewData["mode_dsc"] = $modeDscArr["INS"];
            $viewData["avaroles"] = $tmpAvailableRoles;
            $viewData["chgpswd"] = true;
        } else {
            $tmpUsuario = \Dao\Mnt\Usuarios::getOneUsuario($viewData['usercod']);
            $tmpUserRoles = \Dao\Security\Security::getRolesByUsuario($viewData["usercod"]);

            $viewData['useremail'] = $tmpUsuario['useremail'];
            $viewData['username'] = $tmpUsuario['username'];
            $viewData['userpswd'] = $tmpUsuario['userpswd'];
            $viewData['userfching'] = date("Y-m-d\TH:i:s",strtotime($tmpUsuario['userfching']));
            $viewData['userpswdexp'] = date("Y-m-d\TH:i:s",strtotime($tmpUsuario['userpswdexp']));
            $viewData['userest'] = $tmpUsuario['userest'];
            $viewData['useractcod'] = $tmpUsuario['useractcod'];
            $viewData['userpswdchg'] = $tmpUsuario['userpswdchg'];
            $viewData['usertipo'] = $tmpUsuario['usertipo'];
            $viewData["userroles"] = $tmpUserRoles;
            $viewData["avaroles"] = $tmpAvailableRoles;
            $viewData["chgpswd"] = false;

            $viewData["userest_ACT"] = $tmpUsuario["userest"] == "ACT" ? "selected" : "";
            $viewData["userest_INA"] = $tmpUsuario["userest"] == "INA" ? "selected" : "";
            $viewData["userest_SUS"] = $tmpUsuario["userest"] == "SUS" ? "selected" : "";
            $viewData["userest_BLQ"] = $tmpUsuario["userest"] == "BLQ" ? "selected" : "";
            
            $viewData["usertipo_PBL"] = $tmpUsuario["usertipo"] == "PBL" ? "selected" : "";
            $viewData["usertipo_ADM"] = $tmpUsuario["usertipo"] == "ADM" ? "selected" : "";
            $viewData["usertipo_AUD"] = $tmpUsuario["usertipo"] == "AUD" ? "selected" : "";
            
            $viewData["mode_dsc"] = sprintf(
                $modeDscArr[$viewData["mode"]],
                $viewData['usercod']
            );

            if( $viewData["mode"] == "DSP" ){
                $viewData["readonly"] = "readonly";
                $viewData["showaction"] = false;
            }
            if( $viewData["mode"] == "DSP" || $viewData["mode"] == "DEL"){
                $viewData["readonly"] = "readonly";
            }
        }
        Renderer::render("mnt/usuario", $viewData);
    }

}

?>