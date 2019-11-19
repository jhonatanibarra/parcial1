<?php
    $tarea = array();
    $e = $_GET['id'];
    $datos = file_get_contents("tareas/".$e.".json");
    $tarea =json_decode($datos,true);
    $i = 0;
    foreach ($tarea as $t){
        if($i == $_GET['n']){
            $t["completa"] = $_GET['echo'];
        }
        $i+=1;
    }
    $misTareas = json_encode($tarea);
    file_put_contents("tareas/".$e.".json", $misTareas);    
?>
