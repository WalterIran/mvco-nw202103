<?php
namespace Dao\Mnt;

use Dao\Table;

class Features extends Table{
    public static function getFeatures(){
        $sqlStr = "SELECT * FROM funciones;";
        return self::obtenerRegistros($sqlStr, array());
    }

    public static function obtenerUnicaFuncion($fncod)
    {
        $sqlStr = "Select * From funciones where fncod =:fncod;";
        return self::obtenerUnRegistro($sqlStr,array("fncod"=>$fncod));
    }


    
    public static function crearFunciones($fncod, $fndsc,$fnest,$fntyp){
        $sqlStr = "INSERT INTO funciones (
            fncod, fndsc, fnest, fntyp
        ) 
        VALUES (
            :fncod, :fndsc, :fnest, :fntyp
        );";
        $parametros = array(
            "fncod" => $fncod,
            "fndsc" => $fndsc, 
            "fnest" => $fnest,
            "fntyp" => $fntyp
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }

    public static function editarFuncion($fncod, $fndsc,$fnest,$fntyp){
        $sqlStr = "UPDATE funciones set fndsc=:fndsc, fnest=:fnest, fntyp =:fntyp where fncod=:fncod;";
        $parametros = array(
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
           
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }

    public static function eliminarFuncion($fncod)
    {
        $sqlStr = "DELETE FROM funciones_roles WHERE fncod = :fncod; DELETE FROM funciones where fncod =:fncod;";
        $parametros = array(
            "fncod" => $fncod
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }

   
}
?>