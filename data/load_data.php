<?php
    header('Content-Type: application/json;charset=utf-8');
    error_reporting(0);
    require ('conexion.php');
    $estaciones = ['15', '16'];
    $months = ['01', '02', '03'];
    $years = ['2021','2022'];
    $response = replyJSON($years, $months, $estaciones);
    print json_encode($response,JSON_PRETTY_PRINT);


function replyJSON($years, $months, $estaciones)
{  
    global $conn; 
    $resultado =array();
    $parametros =  parametros_tabla(); 
    foreach ($years as $year)
    {
        foreach ($months as $month)
        {
        foreach($estaciones as $estacion)
        {
                $name_estacion = GetNameEstacion($estacion); 
                $sql ="SELECT estacion, id_certificado, fecha, ".$parametros." from muestras where estacion = '".$name_estacion."' and estatus='1' and YEAR(fecha)='".$year."' and MONTH(fecha)='".$month."'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC))
                {   
                    foreach ($row as $key => $value) {
                        if (empty($value)) {
                            $row[$key] = "—";
                        }
                    }
                    $resultado[] = $row;
                }
        }    
        }       
                    
            
        }
        if(count($resultado)==null)
        {
            $elementos = 0;
        }
        else
        {
            $elementos= count($resultado);
        }
        $data =array('last_page'=>count($resultado),'data'=>$resultado);
    
        return($data);

}


function parametros_tabla()
{
    
    global $conn; 
    $output='';
    $sql =" select id_parametro  from parametros where enable = 0";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
       $output.= 'parametro_'.$row['id_parametro'].', ';
    }
    return  rtrim($output,', ');

}

function GetNameEstacion($id_parameter)
{
    global $conn;
    $sql = "SELECT nombre_estacion FROM estaciones WHERE id_estacion='" . $id_parameter . "'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $nombre_estacion = $row['nombre_estacion'];
    }
    return $nombre_estacion;
}

function search_program($programa){
    
    global $conn;
    $sql = " select columna_programa as columna from programas where id_programa='".$programa."'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $nombre =" and ". $row['columna']."='1'";
    }
    return $nombre;

}



?>
