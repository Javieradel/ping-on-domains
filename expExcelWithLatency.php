<?php

    $domains=['google.com','logon.warmane.com','facebook.com'];




        $currentDate=$hoy = date('j-m-y');
        $archivo = fopen("./tabla-ping-$currentDate.csv", "w+");
        if(!$archivo){
            echo "ha ocurrido un error creando o abriendo el archivo destino";
            exit();
        }else{
            echo "iniciando...\n";
            fputcsv($archivo,['Dominio', 'Ping Promedio'],',');
        }



    for($i=0; $i< count($domains); $i++){
        
        #RETURN VALUE TYPE : "XX XX XX XX XX"
        $prom = shell_exec("ping -c 3 -4 ${domains[$i]} | grep -oP \".*time=\K\d+\"");
        #RETURN ARRAY WITH ENTRIES OF PING TIME VALUE
        $prom= preg_split("/\n/",$prom);
        #REMOVE EMPTY ENTRIE ON END OF ARRAY
        array_pop($prom);
        #RETURN PROMEDIO ON MILISECONDS
        $pingPromedio= intval(array_sum($prom)/count($prom));
        #INJECT VALUES TO FILE
        fputcsv($archivo,[$domains[$i], $pingPromedio],',');
        //echo "$domains[$i] ping promedio = $pingPromedio\n";
        echo intval((($i*100)/count($domains)))."%\n";
        


    }
    



?>
