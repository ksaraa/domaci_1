<?php 
    class SessionUtil {
        public static function setToSession($key, $value) {
            self::startSession();
            $_SESSION[$key] = $value;
        }

        public static function getFromSession($key) {
            return self::getFromSessionOrDefault($key, null);
        }

        public static function getFromSessionOrDefault($key, $defaultValue){
            self::startSession();
            return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
        }

        private static function startSession(){
            if (session_id() === "") { 
                session_start(); 
            }
        }

        public static function endSession() {
            self::startSession();
            session_destroy();
        }
    }
?>