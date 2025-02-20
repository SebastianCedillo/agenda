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

if($post['accion']=='vcedula'){

$sentencia= sprintf("SELECT * FROM persona WHERE ci_persona='%s' ",$post['cedula']);
$rs=mysqli_query($conexion,$sentencia);

if(mysqli_num_rows($rs)>0){

    $respuesta = json_encode(array("estado"=>true, "mensaje"=>"Cedula ya existe"));

}else{
    $respuesta = json_encode(array("estado"=>false));

}
echo $respuesta;

}


if($post['accion']=='cuenta'){

    $sentencia= sprintf("INSERT INTO persona (ci_persona,nom_persona,ape_persona,clave_persona,correo_persona) values ('%s','%s','%s','%s','%s') " , 

    $post['cedula'],
            $post['nombre'],
            $post['apellido'],
            $post['clave'],
            $post['correo'],
);
    $rs=mysqli_query($conexion,$sentencia);
    
    if($rs){
    
        $respuesta = json_encode(array("estado"=>true, "mensaje"=>"Cuenta creada satisfactoriamente"));
    
    }else{
        $respuesta = json_encode(array("estado"=>false, "mensaje"=> "Error al crear cuenta"));
    
    }
    echo $respuesta;
    
    }


    if($post['accion']=='lcontactos'){

        $sentencia = sprintf("SELECT * FROM contacto WHERE persona_cod_persona='%s' ", $post['codigo']);
        $rs = mysqli_query($conexion,$sentencia);

        if(mysqli_num_rows($rs)>0){

            while($row=mysqli_fetch_array($rs)){
                $datos[]=array(
                    'codigo'=>$row['cod_contacto'],
                    'nombre'=>$row['nom_contacto']." ".$row['ape_contacto'],
                    'telefono'=>$row['telefono_contacto'],
                    'email'=>$row['email_contacto'],
                );

            }
            $respuesta=json_encode(array('estado'=>true,'data'=>$datos));

        }else{

            $respuesta=json_encode(array('estado'=>false,'mensaje'=>"No hay contactos"));
        }

        echo $respuesta;

    }
    

    if($post['accion']=='nuevoContacto'){

        $sentencia= sprintf("INSERT INTO contacto (nom_contacto,ape_contacto,telefono_contacto,email_contacto,persona_cod_persona) values ('%s','%s','%s','%s','%s') " , 
    
        $post['nombre'],
                $post['apellido'],
                $post['telefono'],
                $post['correo'],
                $post['cod_persona'],
    );
        $rs=mysqli_query($conexion,$sentencia);
        
        if($rs){
        
            $respuesta = json_encode(array("estado"=>true, "mensaje"=>"Contacto creado satisfactoriamente"));
        
        }else{
            $respuesta = json_encode(array("estado"=>false, "mensaje"=> "Error al guardar el contacto"));
        
        }
        echo $respuesta;
        
        }

        if($post['accion']=='vtelefono'){

            $sentencia= sprintf("SELECT cod_contacto FROM contacto WHERE  persona_cod_persona = '%s' AND telefono_contacto='%s' ",$post['cod_persona'], $post['telefono']);
            $rs=mysqli_query($conexion,$sentencia);
            
            if(mysqli_num_rows($rs)>0){
            
                $respuesta = json_encode(array("estado"=>true, "mensaje"=>"Telefono ya existe"));
            
            }else{
                $respuesta = json_encode(array("estado"=>false,'mensaje'=>""));
            
            }
            echo $respuesta;
            
            }



     if($post['accion']=='acontacto'){

       $sentencia = sprintf("UPDATE contacto SET nom_contacto = '%s' ,ape_contacto = '%s',telefono_contacto = '%s',email_contacto = '%s' WHERE cod_contacto = '%s' " ,
        
$post['nombre'],
       $post['apellido'],
       $post['telefono'],
       $post['correo'],
       $post['cod_contacto'],
  
    );  
    
    $rs=mysqli_query($conexion,$sentencia);
    if($rs){

        $respuesta = json_encode(array("estado"=>true, "mensaje"=>"Datos actualizados satisfactoriamente"));
    }else{

        $respuesta = json_encode(array("estado"=>false, "mensaje"=>"Error al actualizar"));

    }
    echo $respuesta;

      
}


if($post['accion']=='dcontacto'){

    $sentencia = sprintf("SELECT * FROM contacto WHERE cod_contacto='%s' ", $post['cod_contacto']);
    $rs = mysqli_query($conexion,$sentencia);

    if(mysqli_num_rows($rs)>0){

        while($row=mysqli_fetch_array($rs)){
            $datos=array(

                'nombre'=>$row['nom_contacto'],
                'apellido'=> $row['ape_contacto'],
                'telefono'=>$row['telefono_contacto'],
                'correo'=>$row['email_contacto'],
            );

        }
        $respuesta=json_encode(array('estado'=>true,'datos'=>$datos));

    }else{

        $respuesta=json_encode(array('estado'=>false,'mensaje'=>"Error al cargar datos"));
    }

    echo $respuesta;

}

if($post['accion']=='econtacto'){

$sentencia = sprintf("DELETE FROM contacto WHERE cod_contacto ='%s' " , $post['cod_contacto']);
$rs = mysqli_query($conexion,$sentencia);

if($rs){
    $respuesta=json_encode(array('estado'=>true,'mensaje'=>"Contacto eliminado satisfactoriamente"));

}else{

    $respuesta=json_encode(array('estado'=>false,'mensaje'=>"Erro al eliminar contacto"));

}

echo $respuesta;


}


?>