<?php

class Connection{

     /*===============================
        INFO DE LA BASE DE DATOS
    ================================*/
    static public function infoDatabase(){

        $infoDB = array(
            'database' => 'serenacc_users_sea_list',
            'user' => 'serenacc_admin',
            'pass' => 'bd$6vyuqHMFv'
        ); 
        return $infoDB;
    }

    static function connect(){
        try{
            $link = new PDO(
                'mysql:host=localhost;dbname='.Connection::infoDatabase()['database'],
                Connection::infoDatabase()['user'],
                Connection::infoDatabase()['pass']
            );
        }catch (PDOException $e){

            die('Error:'.$e->getMessage());

        }
        return $link;
    }

    /*======================================
        VALIDAR EXISTENCIA DE TABLA EN BD
    ======================================*/

    static public function getColumnsData($table, $columns){


        /*===============================
        TRAER NOMBRE DE BD Y TABLAS
         ================================*/
        $database =  Connection::infoDatabase()['database'];
        $validate =  Connection::connect()
           ->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")
           ->fetchAll(PDO::FETCH_OBJ);
        /*===============================
        VALIDAR EXISTENCIA DE TABLA
         ================================*/
        if(empty($validate)){
            return null;
        }else{
            /*===============================
            AJUSTE DE SELECCION DE * COLUMNAS
            ================================*/
            if($columns[0]=='*'){
                array_shift($columns);
            }
            
            /*===============================
            VALIDAR EXISTENCIA DE COLUMNAS
            ================================*/
            $sum = 0;
            foreach($validate as $key => $value){
                $sum +=in_array($value->item , $columns );
            }
            return $sum == count($columns) ? $validate : null;
        }
    }

    /*======================================
        GENERAR TOKEN DE AUTENTICACION
    ======================================*/

    static public function jwt($id, $email){
        $time = time();
        $token = array(
            "iat" => $time,//tiempo en q inicia el token
            "exp" => $time + (60*60), //tiempo en que expirará el token
            "data" => [
                "id" => $id,
                "email" => $email
            ]
        );
            return $token;
    }

    static public function tokenValidator($token, $table, $sufix){
        /*======================================
            TRAER USUARIO DE ACUERDO AL TOKEN
        ======================================*/
        $user = GetModel::getDataFilter($table, "token_exp_".$sufix, "token_".$sufix, $token,  null, null, null, null);
        if(!empty($user)) {
            /*===============================================
                VALIDAR QUE EL TOKEN NO HAYA EXPIRADO
            ===============================================*/
            $time = time();
            if($user[0]->{"token_exp_".$sufix} > $time){
                return "ok";
            }
            return "expired";
        }
        return "no-auth";
    }

    static public function apiKey(){
        return "claveDePrueba420";
    }

}