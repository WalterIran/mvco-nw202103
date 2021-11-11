<?php
namespace Dao\Mnt;

use Dao\Table;

class Categorias extends Table
{
    //Obtener todos los registrros

    public static function obtenerCategorias()
    {
        $sqlStr = "Select * From categorias;";
        return self::obtenerRegistros($sqlStr,array());
    }

    public static function obtenerUnicaCategoria($catid)
    {
        $sqlStr = "Select * From categorias where catid =:catid;";
        return self::obtenerUnRegistro($sqlStr,array("catid"=>intval($catid)));
    }

    public static function crearCategoria($catnom,$catest){
        $sqlStr = "INSERT INTO categorias (catnom,catest) values (:catnom, :catest);";
        $parametros = array(
            "catnom" => $catnom,
            "catest" => $catest
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }

    public static function editarCategoria($catnom, $catest, $catid){
        $sqlStr = "UPDATE categorias set catnom=:catnom, catest=:catest where catid=:catid;";
        $parametros = array(
            "catnom" => $catnom,
            "catest" => $catest,
            "catid" => intval($catid)
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }

    public static function eliminarCategoria($catid)
    {
        $sqlStr = "DELETE FROM categorias where catid =:catid;";
        $parametros = array(
            "catid" => intval($catid)
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }
}

?>