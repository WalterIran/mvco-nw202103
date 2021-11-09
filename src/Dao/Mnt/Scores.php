<?php

    namespace Dao\Mnt;

    use Dao\Table;

    class Scores extends Table
    {
        public static function obtenerScores()
        {
            $sqlStr = "SELECT * FROM scores;";
            return self::obtenerRegistros($sqlStr, array());
        }

        public static function obtenerUnaScore($scoreid)
        {
            $sqlStr = "SELECT * FROM scores WHERE scoreid = :scoreid;";
            return self::obtenerUnRegistro($sqlStr, array("scoreid" => intval($scoreid)));
        }

        public static function crearScore(
            $scoredsc,
            $scoreauthor,
            $scoregenre,
            $scoreyear,
            $scoresales,
            $scoreprice,
            $scoredocurl,
            $scoreest) {
                
            $sqlStr = "INSERT INTO scores (scoredsc, scoreauthor, scoregenre, scoreyear, scoresales, scoreprice, scoredocurl, scoreest) VALUES(
                :scoredsc, 
                :scoreauthor, 
                :scoregenre, 
                :scoreyear, 
                :scoresales, 
                :scoreprice, 
                :scoredocurl, 
                :scoreest
            );";
            $parametros = array(
                "scoredsc" => $scoredsc, 
                "scoreauthor" => $scoreauthor, 
                "scoregenre" => $scoregenre, 
                "scoreyear" => $scoreyear, 
                "scoresales" => $scoresales, 
                "scoreprice" => $scoreprice, 
                "scoredocurl" => $scoredocurl, 
                "scoreest" => $scoreest
            );

            return self::executeNonQuery($sqlStr, $parametros);
        }

        public static function editarScore(
            $scoreid,
            $scoredsc,
            $scoreauthor,
            $scoregenre,
            $scoreyear,
            $scoresales,
            $scoreprice,
            $scoredocurl,
            $scoreest) {

            $sqlStr = "UPDATE scores 
            SET scoredsc = :scoredsc, 
                scoreauthor = :scoreauthor, 
                scoregenre = :scoregenre, 
                scoreyear = :scoreyear, 
                scoresales = :scoresales, 
                scoreprice = :scoreprice, 
                scoredocurl = :scoredocurl, 
                scoreest = :scoreest 
            WHERE scoreid = :scoreid;";
            $parametros = array(
                "scoredsc" => $scoredsc, 
                "scoreauthor" => $scoreauthor, 
                "scoregenre" => $scoregenre, 
                "scoreyear" => $scoreyear, 
                "scoresales" => $scoresales, 
                "scoreprice" => $scoreprice, 
                "scoredocurl" => $scoredocurl, 
                "scoreest" => $scoreest,
                "scoreid" => intval($scoreid),
            );

            return self::executeNonQuery($sqlStr, $parametros);
        }

        public static function eliminarScore ($scoreid) {
            $sqlStr = "DELETE FROM scores WHERE scoreid = :scoreid;";
            $parametros = array(
                "scoreid" => intval($scoreid),
            );
            return self::executeNonQuery($sqlStr, $parametros);
        } 
    }
?>