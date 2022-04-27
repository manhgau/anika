<?php
class keyEmail {
    private static $rand = NULL;
    
    public static function getRand() {
        if( is_null(self::$rand) ) {
            self::$rand = rand(pow(10, 6-1), pow(10, 6)-1);
        }
        return self::$rand;
    }

    public static function instanceMethodOne() {
        return self::getRand();
    }
}
