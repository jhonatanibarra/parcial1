<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MIS TAREAS</title>
    <link rel = "stylesheet"
   type = "text/css"
   href = "css/estilo.css" />
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
    <style>
        .tachado
        {
            text-decoration: line-through;
        }
    </style>
    <script>
        $(document).ready(function(){   
            console.log("listo");
            $("input[name='chb']").click(function(){
                val = $(this).val();                
                if($("label[name='l"+val+"']").hasClass('tachado')){
                    $("label[name='l"+val+"']").removeClass("tachado");
                    $.ajax({
                        type: "GET",
                        url: "terminar.php",
                        data:{
                            id:<?php echo $_GET['cedula']?>,
                            n: val,
                            hecho:"false"
                        },
						success: function (response) {							
                        },
                    });
                }else{
                    $("label[name='l"+val+"']").addClass("tachado");
                    $.ajax({
                        type: "GET",
                        url: "terminar.php",
                        data:{
                            id:<?php echo $_GET['cedula']?>,
                            n: val,
                            hecho:"true"
                        },
						success: function (response) {							
                        },
                    });
                }
            }
        )});
    </script>
    <title>Tareas</title>
</head>

<body>
    <h3 id ="cedula" value=<?php echo $_GET['cedula']; ?>>Cedula: <?php echo $_GET['cedula']; ?></h3>
    <?php
        $tarea = array();        
        if(isset($_GET['cedula']))
        {   
            $e = $_GET['cedula'];
            if(!(file_exists ("tareas/".$e.".json"))){
                $misTareas [] = array("tarea"=>"Ser feliz", "fecha"=>date("d/m/Y h:i:sa"), "completa"=> "false");
                array_push($misTareas,array("tarea"=>"Planear semana", "fecha"=>date("d/m/Y h:i:sa"), "completa"=> "false"));
                $tarea = json_encode($misTareas);
                file_put_contents("tareas/$e.json", $tarea);
            }            
        } 
        $datos = file_get_contents("tareas/".$_GET['cedula'].".json");
        $tarea =json_decode($datos,true);
        $n = 0;
        foreach ($tarea as $t):?>
            <div id="divs" class="tarea">
                <input type="checkbox" name="chb" value=<?php echo $n?> > <label name="l<?php echo $n?>"><?php echo $t['tarea']?></label><br>
            </div>            
            <?php $n+=1?>
    <?php endforeach;?>   
    <script>
        function agregar(){
            if(document.getElementById("nuevaTarea").value==""){
                alert("debe escribir una tarea");
            }else{
                var tarea = document.getElementById("nuevaTarea").value;
                escribir(tarea);
                alert("Nueva tarea agregada");
                location.reload();
                document.getElementById("nuevaTarea").value="";
            }
        }
        function getdata(){
            if (this.readyState == 4 && this.status == 200){                
                location.reload();
            }    
        }
        function escribir(tarea){
            var id = <?php echo $_GET['cedula']; ?>;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = getdata;
            xhttp.open("GET", "procesosP.php?tarea=" + tarea+"&id="+id);
            xhttp.send();
        }
    </script>
    <input type="text" class="txtBox" placeholder="Nueva tarea..." id = "nuevaTarea"><button onclick="agregar()">Agregar</button>
</body>
</html>