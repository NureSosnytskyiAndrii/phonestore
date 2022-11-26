<?php

class  App
{

    /**
     * @param $property string Config Property
     * @return false|object|stdClass|null Object with config fields
     */
    private static function getConfigProp($property){
        global $mysqli;
        $config = $mysqli->query("SELECT * FROM user WHERE user_id = 1");
        $config_obj = $config->fetch_object();
        return $config_obj->$property;
    }


    public static function getName(){
        return self::getConfigProp('sitename');
    }
    public static function getSlogan(){
        return self::getConfigProp('slogan');
    }
    public static function getEmail(){
        return self::getConfigProp('site_email');
    }
    public static function getPhone(){
        return self::getConfigProp('site_phone');
    }
    public static function getAddress(){
        return self::getConfigProp('site_address');
    }

}