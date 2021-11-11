<?php
namespace Dao\Mnt;

use Dao\Table;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class Roles extends Table{
    public static function getRoles(){
        $sqlStr = "SELECT * FROM roles;";
        return self::obtenerRegistros($sqlStr, array());
    }

    //C-create
    public static function createRol($rolescod, $rolesdsc, $rolesest){
        $sqlStr = "INSERT INTO roles (
            rolescod, rolesdsc, rolesest
        ) 
        VALUES (
            :rolescod, :rolesdsc, :rolesest
        );";
        $parametros = array(
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc, 
            "rolesest" => $rolesest
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }

    //R-read
    public static function getRol($rolescod){
        $sqlStr = "SELECT * FROM roles WHERE rolescod = :rolescod;";
        return self::obtenerUnRegistro($sqlStr, array("rolescod"=>$rolescod));
    }

    //U-update
    public static function updateRol($rolesdsc, $rolesest, $rolescod){
        $sqlStr = "UPDATE roles SET rolesdsc = :rolesdsc, rolesest = :rolesest
        WHERE rolescod = :rolescod;";
        $parametros = array(
            "rolesdsc" => $rolesdsc, 
            "rolesest" => $rolesest,
            "rolescod"=> $rolescod
        );
        return self::executeNonQuery($sqlStr, $parametros);

    }

    public static function updateRolv2($fncod, $rolescod)
    {
        
        $sqlStr = "DELETE FROM funciones_roles WHERE rolescod = :rolescod ;";
            $parametros = array(
                'rolescod' => $rolescod,
            );
            self::executeNonQuery($sqlStr, $parametros);

            $fnrolest = 'ACT';
           
            $fnexp = date('Y-m-d H:i:s', strtotime('+10 years'));
            
            foreach ($fncod as $fun){
                //dd('AQUI dentro');
                $sqlStr = "INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp) VALUES (
                    :rolescod, :fncod, :fnrolest, :fnexp
                );";

                $parametros = array(
                    'rolescod' => $rolescod,
                    'fncod' => $fun,
                    'fnrolest' => $fnrolest,
                    'fnexp' => $fnexp
                    
                );
                self::executeNonQuery($sqlStr, $parametros);
            }

            return true;
    }

    //D-delete
    public static function deleteRol($rolescod){
        $sqlStr = "DELETE FROM roles_usuarios WHERE rolescod = :rolescod; 
        DELETE FROM funciones_roles WHERE rolescod = :rolescod; 
        DELETE FROM roles WHERE rolescod = :rolescod;";
        $parametros = array(
            "rolescod"=> $rolescod
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }

    public static function getFunctionsRol($rolescod){
        $sqlStr = "SELECT fncod FROM funciones_roles WHERE rolescod = :rolescod;";
        $parametros = array(
            "rolescod" => $rolescod
        );
        //return self::executeNonQuery($sqlStr, $parametros);
        return self::obtenerRegistros($sqlStr,array("rolescod" => $rolescod));

    }

    static public function getFunctionsNotRol($rolescod)
        {
            $sqlstr = "select
            fun.fncod
            from funciones_roles as fun_rol
            right outer join funciones as fun
            on fun.fncod = fun_rol.fncod and fun_rol.rolescod = :rolescod
            where fun_rol.fncod is null;";
            $resultados = self::obtenerRegistros(
                $sqlstr,
                array(
                    "rolescod" => $rolescod
                )
            );
            return $resultados;
        }

    
}
?>