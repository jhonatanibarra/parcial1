<?php
    
    if(isset($_GET['tarea'],$_GET['id']))
    {
        $tarea = array();
        $t = $_GET['tarea'];
        $e = $_GET['id'];
        $datos = file_get_contents("tareas/".$e.".json");
        $tarea =json_decode($datos,true);
        array_push($tarea,array("tarea"=>$t, "fecha"=>date("d/m/Y h:i:sa"), "completa"=> "false"));
        $misTareas = json_encode($tarea);
        file_put_contents("tareas/".$e.".json", $misTareas);
        echo $t;
    }
?>
