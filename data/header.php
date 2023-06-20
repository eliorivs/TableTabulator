<?php
    header('Content-Type: application/json;charset=utf-8');
    require ('conexion.php');
    $resultado = array();
    $resultado[] =  array('title'=>'Estacion','field'=>"estacion",'sorter'=>"string", 'width'=>120,'hozAlign'=>"center" ,'cellVerticallyCentered'=>'true','headerHorizontal'=>"middle", 'cssClass'=>"centered-header", "frozen"=>"true");
    $resultado[] =  array('title'=>'Certificado','field'=>"id_certificado",'sorter'=>"string", 'width'=>120, 'hozAlign'=>"center", "frozen"=>"true");
    $resultado[] =  array('title'=>'Fecha','field'=>"fecha",'sorter'=>"string", 'width'=>120,'hozAlign'=>"center", "frozen"=>"true");
    $sql ="SELECT * FROM   parametros A,  unidades B  WHERE A.id_unidad = B.id_unidad and A.`enable` =0";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
      
       $resultado[]= array('title'=>$row['nombre_largo'].'<br><span style=" font-size: 10px ; line-height: 10% !important; color: #8f90dc ">'.$row['unidad'].'</span>','field'=>'parametro_'.$row['id_parametro'],'sorter'=>"string", 'width'=>120,'hozAlign'=>"center");
    }
    
   
   
    print json_encode($resultado,JSON_PRETTY_PRINT);

?>
