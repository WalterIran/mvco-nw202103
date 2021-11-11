<?php
namespace Dao\Mnt;

use Dao\Table;

class Scores extends Table
{
    //Obtener todos los registrros

    public static function obtenerScores()
    {
        $sqlStr = "Select * From scores;";
        return self::obtenerRegistros($sqlStr,array());
    }

    public static function obtenerUnicaScore($scoreid)
    {
        $sqlStr = "Select * From scores where scoreid =:scoreid;";
        return self::obtenerUnRegistro($sqlStr,array("scoreid"=>intval($scoreid)));
    }

    public static function crearScore($scoredsc,$scoreauthor,$scoregenre,$scoreyear,$scoresales,$scoreprice,$scoredocurl,$scoreest){
        $sqlStr = "INSERT INTO scores (scoredsc,scoreauthor,scoregenre,scoreyear,scoresales,scoreprice,scoredocurl,scoreest)
         values (:scoredsc, :scoreauthor,:scoregenre,:scoreyear,:scoresales,:scoreprice,:scoredocurl,:scoreest);";
        $parametros = array(
            "scoredsc" => $scoredsc,
            "scoreauthor" => $scoreauthor,
            "scoregenre" => $scoregenre,
            "scoreyear" => $scoreyear,
            "scoresales" => $scoresales,
            "scoreprice" => $scoreprice,
            "scoredocurl" => $scoredocurl,
            "scoreest" => $scoreest,
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }

    public static function editarScores($scoredsc,$scoreauthor,$scoregenre,$scoreyear,$scoresales,$scoreprice,$scoredocurl,$scoreest,$scoreid){
        $sqlStr = "UPDATE scores set scoredsc=:scoredsc, scoreauthor=:scoreauthor, 
        scoregenre=:scoregenre, scoreyear=:scoreyear,
        scoresales=:scoresales, scoreprice=:scoreprice,
        scoredocurl=:scoredocurl, scoreest=:scoreest
        where scoreid=:scoreid;";

        $parametros = array(
            "scoredsc" => $scoredsc,
            "scoreauthor" => $scoreauthor,
            "scoregenre" => $scoregenre,
            "scoreyear" => intval($scoreyear),
            "scoresales" => intval($scoresales),
            "scoreprice" => floatval($scoreprice),
            "scoredocurl" => $scoredocurl,
            "scoreest" => $scoreest,
            "scoreid" => intval($scoreid)
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }

    public static function eliminarScores($scoreid)
    {
        $sqlStr = "DELETE FROM scores where scoreid =:scoreid;";
        $parametros = array(
            "scoreid" => intval($scoreid)
        );

        return self::executeNonQuery($sqlStr,$parametros);
    }
}

?>