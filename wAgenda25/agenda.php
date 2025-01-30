<?php

include('config.php');

header ('Access-Control-Allow-Origin: *');
header ('Access-Control-Allow-Credentials:true');
header ('Access-Control-Allow-Methods: PUT,GET,POST,DELETE,OPTIONS');
header ('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token');
header('Content-Type: application/json; charset=utf-8');

$post =json_decode(file_get_contents("php://input"), true);
if($post['accion']=='login')
    {
        $sentencia=sprintf("SELECT * FROM persona WHERE ci_persona='%s' and clave_persona='%s' ",
        $post['usuario'],$post['clave']);

        $rs = mysqli_query($conexion,$sentencia);
        
        if(mysqli_num_rows($rs) >0){

            while($row=mysqli_fetch_array($rs)){

                $datos=array(
                    'codigo'=>$row['cod_persona'],
                    'nombre'=>$row['nom_persona']." ".$row['ape_persona'],
                );
            }
            $respuesta = json_encode(array('estado'=>true,'persona'=>$datos));

        }else{

            $respuesta = json_encode(array('estado'=>false,'mensaje'=>'Error de usuario o clave'));

        }

        echo $respuesta;


}





























?>