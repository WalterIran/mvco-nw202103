<?php

    namespace Dao\Mnt;

    use Dao\Table;

    class Usuarios extends Table
    {
        public static function getUsuarios()
        {
            $sqlStr = "SELECT * FROM usuarios;";
            return self::obtenerRegistros($sqlStr, array());
        }

        public static function getOneUsuario($usercod)
        {
            $sqlStr = "SELECT * FROM usuario WHERE usercod = :usercod;";
            return self::obtenerUnRegistro($sqlStr, array('usercod' => intval($usercod)));
        }

        static public function getRolesNotUser($userCod)
        {
            $sqlstr = "select
            rol.rolescod
            from roles_usuarios as user_rol
            right outer join roles as rol
            on rol.rolescod = user_rol.rolescod and user_rol.usercod = :usercod
            where user_rol.usercod is null;";
            $resultados = self::obtenerRegistros(
                $sqlstr,
                array(
                    "usercod" => $userCod
                )
            );
            return $resultados;
        }

        /* public static function createUsuario($useremail,$username,$userpswd,$userfching,$userpswdexp,$userest,$useractcod,$userpswdchg,$usertipo,) {
            $sqlStr = "INSERT INTO usuarios (useremail,username,userpswd,userfching,userpswdexp,userest,useractcod,userpswdchg,usertipo) VALUES (:useremail,:username,:userpswd,:userfching,:userpswdexp,:userest,:useractcod,:userpswdchg,:usertipo);";
            $parametros = array('useremail' => $useremail,'username' => $username,'userpswd' => $userpswd,'userfching' => $userfching,'userpswdexp' => $userpswdexp,'userest' => $userest,'useractcod' => $useractcod,'userpswdchg' => $userpswdchg,'usertipo' => $usertipo,);
            return self::executeNonQuery($sqlStr, $parametros);
        } */

        static private function _saltPassword($password)
        {
            return hash_hmac(
                "sha256",
                $password,
                \Utilities\Context::getContextByKey("PWD_HASH")
            );
        }

        static private function _hashPassword($password)
        {
            return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
        }

        public static function editUsuario(
            $usercod,
            $useremail,
            $username,
            $userpswd,
            $userpswdest,
            $userpswdexp,
            $userpswdchg,
            $userest,
            $usertipo
            ) {
            $sqlStr = 'UPDATE usuario 
            SET useremail = :useremail,
            username = :username,
            userpswd = :userpswd,
            userpswdest = :userpswdest,
            userpswdexp = :userpswdexp,
            userest = :userest,
            userpswdchg = :userpswdchg,
            usertipo = :usertipo
            WHERE usercod = :usercod;';
            $parametros = array(
            'usercod' => $usercod,
            'useremail' => $useremail,
            'username' => $username,
            'userpswd' => self::_hashPassword($userpswd),
            'userpswdexp' => $userpswdexp,
            'userest' => $userest,
            'userpswdchg' => $userpswdchg,
            'usertipo' => $usertipo,
            'userpswdest' => $userpswdest,
            );

            return self::executeNonQuery($sqlStr, $parametros);
        }

        public static function editUsuarioNoPswd(
            $usercod,
            $useremail,
            $username,
            $userpswdest,
            $userpswdexp,
            $userest,
            $usertipo
            ) {
            $sqlStr = 'UPDATE usuario 
            SET useremail = :useremail,
            username = :username,
            userpswdest = :userpswdest,
            userpswdexp = :userpswdexp,
            userest = :userest,
            usertipo = :usertipo
            WHERE usercod = :usercod;';
            $parametros = array(
            'usercod' => $usercod,
            'useremail' => $useremail,
            'username' => $username,
            'userpswdexp' => $userpswdexp,
            'userest' => $userest,
            'usertipo' => $usertipo,
            'userpswdest' => $userpswdest,
            );

            return self::executeNonQuery($sqlStr, $parametros);
        }

        public static function editUserRoles($usercod, $roles){
            $sqlStr = "DELETE FROM roles_usuarios WHERE usercod = :usercod";
            $parametros = array(
                'usercod' => $usercod,
            );
            self::executeNonQuery($sqlStr, $parametros);

            $roleuserest = 'ACT';
            $roleuserfch = date('Y-m-d H:i:s');
            $roleuserexp = date('Y-m-d H:i:s', strtotime('+10 years'));

            foreach ($roles as $role){
                $sqlStr = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch, roleuserexp) VALUES (
                    :usercod, :rolescod, :roleuserest, :roleuserfch, :roleuserexp
                );";

                $parametros = array(
                    'usercod' => $usercod,
                    'rolescod' => $role,
                    'roleuserest' => $roleuserest,
                    'roleuserfch' => $roleuserfch,
                    'roleuserexp' => $roleuserexp
                );
                self::executeNonQuery($sqlStr, $parametros);
            }

            return true;
        }

        public static function deleteUsuario($usercod) {
            $sqlStr = "DELETE FROM usuario WHERE usercod = :usercod;";
            $parametros = array(
                'usercod' => $usercod,
            );
            return self::executeNonQuery($sqlStr, $parametros);
        }
    }
?>