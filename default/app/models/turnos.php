<?php

class turnos extends ActiveRecord{
    
    /*
     * funcion ContarFechas recibe por parametro una fecha
     * cuenta la cantidad de recgistros con esa fecha...
     * Devuelve la cantidad de registros que contengan la fecha pasada por parametro.
     */
   public function ContarFechas($fec) 
    {
       $turno = new turnos();
       return $turno->count("fecha = \"$fec\"");
    } 
   
    public function GrabarTurno($fec,$tur,$id,$tipo)
    {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
	$soli =  date('m/d/Y g:ia'); 
        $dia = new DateTime($fec);  
        $turno = new turnos();
        $dia = $turno->TransformarDias($dia->format('D')); //Transforma el dia de ingles a español para guardar en la BD
        $param = array('dia'=>$dia,'fecha'=>$fec,'horario'=>$tur,'mataux_id'=>$id,'fecsoli'=>$soli,'tipo'=>$tipo,'tramite'=>'M','estado'=>'A');
        $turno = new turnos($param);
        $turno->save();
    }
    
    
    /*
     *funcion TurnoLleno: Recibe por parametro una fecha con todos los turnos llenos, y segun el dia
     *(Martes, Miercoles o Jueves) de la fecha, lo reasigna al siguiente dia de atencion.
     *   Devuelve la nueva fecha del turno.
     */
    public function TurnoLleno($fecha1)
    {
        $dat = new DateTime($fecha1);
        
        $dat= $dat->format('D');    //Transformo la fecha a su correspondiente dia de la samena...
        if($dat == 'Tue')// si es martes...
        {
           
            $fecha1 =date('Y-m-d',strtotime('+1 days', strtotime($fecha1))); //se pasa la fecha al miercoles siguiente...
        }
        if($dat == 'Wed')// si es miercoles...
        {
            
            $fecha1 =date('Y-m-d',strtotime('+1 days', strtotime($fecha1)));// se pasa la fecha al jueves siguiente...
        }
        if($dat == 'Thu')// si es jueves...
        {
            
           $fecha1 =date('Y-m-d',strtotime('+5 days', strtotime($fecha1))); //se pasa la fecha al martes siguiente...
        }
        return $fecha1;  
    }
    
    
    
    /*
     * Funion FechaDisponible: Recibe por parametro una fecha, esta funcion comprueba si en esa fehca existen turnos
     * disponibles, de no ser así busca la proxima fecha que poseaa turno disponible.
     * Devuelve una feha que posee turnos disponibles.
     */
    public function FechaDisponible($fecha)
    {
        $turno = new turnos();
        $ban = false;           //inicializacion de bandera en Falso
        while(!$ban)
        {
            $cuenta = $turno->ContarFechas($fecha); // cantidad de turnos asignados en la fecha ($fecha)
            if($cuenta<8)    //si la cantidad de fechas asignadas es < 8 existen turnos disponibles
            {
                $ban = true;  // se cambia la bandera para salir del ciclo de repeticion
            }
            else
            {       // si no existen turnos disponibles se busca la fecha mas cercana con turnos disponibles
                $fecha = $turno->TurnoLleno($fecha);
            }
        }
        
        return $fecha;  //retorna fecha con turnos disponibles
    }
    
    function IdMat()
    {
        $matri = new matriculado();
        return $matri->Ultimo();
    }
    
    function IdTur()
    {
    $turno =  new turnos();
    return $turno->find_first("order: codturnos desc");
    }
    
    
    /* 
     * Funcion Transformar Horario: recibe como parametro el turno asignado, 
     * y devuelve el orario correspondiente a dicho turno...
     */
    public function TransformarHorario($turn)
    {
        switch ($turn)
        {
            case 1: return 'Hs. 8:00'; break;
            
            case 2: return 'Hs. 8:30'; break;
            
            case 3: return 'Hs. 9:00'; break;
            
            case 4: return 'Hs. 9:30'; break;
            
            case 5: return 'Hs. 10:00'; break;
            
            case 6: return 'Hs. 10:30'; break;
            
            case 7: return 'Hs. 11:00'; break;
            
            case 8: return 'Hs. 11:30'; break;
        }
    }
    
    /*
     * Funcion Transformar dias: recibe como parametro el nombre de un dia en ingles
     * devuelve el nombre del dia en español
     */
    public function TransformarDias($dia)
    {
        switch($dia)
        {
            case 'Tue': return 'Mar'; break;
            case 'Wed': return 'Mie'; break;
            case 'Thu': return 'Jue'; break;
        }
    }
    
    
    
     public function asignar($id){
        
       $dia = date("D");
       $fecha = date("Y-m-d");
       $turno = new turnos();
       $tipo = 'C';
       
       
       if ($dia == "Mon") // si es lunes
       {
        
        $fecasig = date('Y-m-d',  strtotime('+3 day'));// cambia la fecha del lunes a la del siguiente jueves
        $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
        $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
        $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
        $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
        $hora = $turno->TransformarHorario($tur);

        echo"Nº. $tur, a $hora, el dia ";
        echo $time->format('d-m-Y');
       }
       else
       {
            if($dia == "Tue") //si es martes...
            {
                
                $fecasig = date('Y-m-d',  strtotime('+7 day'));// cambia la fecha del martes para el martes siguiente
                $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                $hora = $turno->TransformarHorario($tur);
              echo"Nº. $tur, a $hora, el dia ";
                echo $time->format('d-m-Y');
            }
            else
            {
                if($dia == "Wed") // si es miercoles...
                {
                    
                    $fecasig = date('Y-m-d',  strtotime('+6 day')); // cambia la fecha del miercoles para el martes siguiente
                    $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                    $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                    $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                    $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                    $hora = $turno->TransformarHorario($tur);
                    echo"Nº. $tur, a $hora, el dia ";
                    echo $time->format('d-m-Y');
               }
                else
                {
                    if($dia == "Thu") //si es jueves...
                    {
                       
                        $fecasig = date('Y-m-d',  strtotime('+5 day')); //cambia la fecha del jueves para el martes siguiente
                        $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                        $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                        $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                        $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                        $hora = $turno->TransformarHorario($tur);
                        
                        echo"Nº. $tur, a $hora, el dia ";
                        echo $time->format('d-m-Y');

                    }
                    else
                    {    
                        If($dia== "Fri")//si es viernes...
                        {
                            $fecasig = date('Y-m-d',  strtotime('+5 day')); //cambia la fecha del viernes para el miercoles siguiente
                            $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                            $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                            $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                            $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                            $hora = $turno->TransformarHorario($tur);

                            echo"Nº. $tur, a $hora, el dia ";
                            echo $time->format('d-m-Y');
                        } 
                        else
                        {
                            If($dia=="Sat")//si es sbado
                            {
                                $fecasig = date('Y-m-d',  strtotime('+4 day')); //cambia la fecha del sabado para el miercoles siguiente
                                $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                                $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                                $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                                $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                                $hora = $turno->TransformarHorario($tur);
                                echo"Nº. $tur, a $hora, el dia ";
                                echo $time->format('d-m-Y');
                            }
                            else
                            {
                                $fecasig = date('Y-m-d',  strtotime('+3 day')); //cambia la fecha del domingo para el miercoles siguiente
                                $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                                $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                                $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                                $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                                $hora = $turno->TransformarHorario($tur);
                                echo"Nº. $tur, a $hora, el dia ";
                                echo $time->format('d-m-Y'); 
                            }
                        }
                                                 

                        
                    }
                }
            }
       }

   } 
    
    
   
 
public function asignarlarg($id){ //asinacion de turnos largos
        
       $dia = date("D");
       $fecha = date("Y-m-d");
       $turno = new turnos();
       $tipo = 'L';
       
       
       if ($dia == "Mon") // si es lunes
       {
        
        $fecasig = date('Y-m-d',  strtotime('+15 day'));// cambia la fecha del lunes a la del martes 15 dias despues
        $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
        $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
        $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
        $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
        $hora = $turno->TransformarHorario($tur);
        echo"Nº. $tur, a $hora, el dia ";
        echo $time->format('d-m-Y');
       }
       else
       {
            if($dia == "Tue") //si es martes...
            {
                
                $fecasig = date('Y-m-d',  strtotime('+14 day'));// cambia la fecha del martes para el martes 14 dias despues
                $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                $hora = $turno->TransformarHorario($tur);
              echo"Nº. $tur, a $hora, el dia ";
                echo $time->format('d-m-Y');

            }
            else
            {
                if($dia == "Wed") // si es miercoles...
                {
                    
                    $fecasig = date('Y-m-d',  strtotime('+14 day')); // cambia la fecha del miercoles para el miercoles 14 dias depues
                    $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                    $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                    $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                    $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                    $hora = $turno->TransformarHorario($tur);
                    echo"Nº. $tur, a $hora, el dia ";
                    echo $time->format('d-m-Y');

               }
                else
                {
                    if($dia == "Thu") //si es jueves...
                    {
                       
                        $fecasig = date('Y-m-d',  strtotime('+14 day')); //cambia la fecha del jueves para el jueves dentro de 14 dias
                        $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                        $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                        $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                        $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                        $hora = $turno->TransformarHorario($tur);
                        
                        echo"Nº. $tur, a $hora, el dia ";
                        echo $time->format('d-m-Y');

                    }
                    else
                    {                       //si es viernes... 
                        If($dia == "Fri")
                        {
                            $fecasig = date('Y-m-d',  strtotime('+18 day')); //cambia la fecha del viernes para el martes 18 dias despues
                            $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                            $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                            $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                            $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                            $hora = $turno->TransformarHorario($tur);
                            echo"Nº. $tur, a $hora, el dia ";
                            echo $time->format('d-m-Y');  
                        }
                        else
                        {
                            If($dia=="Sat")
                            {
                                $fecasig = date('Y-m-d',  strtotime('+17 day')); //cambia la fecha del sabado para el martes 17 dias despues
                                $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                                $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                                $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                                $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                                $hora = $turno->TransformarHorario($tur);
                                echo"Nº. $tur, a $hora, el dia ";
                                echo $time->format('d-m-Y');   
                            }
                            else
                            {
                                $fecasig = date('Y-m-d',  strtotime('+16 day')); //cambia la fecha del domingo para el martes 16 dias despues
                                $fecasig = $turno->FechaDisponible($fecasig);// busca fecha disponible
                                $tur = $turno->ContarFechas($fecasig)+1;    // calcua el turno a asignar
                                $turno->GrabarTurno($fecasig, $tur,$id,$tipo);        //graba datos    
                                $time= new DateTime($fecasig);              // se cambia el formato de la fecha para mostrar por pantalla
                                $hora = $turno->TransformarHorario($tur);
                                echo"Nº. $tur, a $hora, el dia ";
                                echo $time->format('d-m-Y');  
                            }
                        }
                        
                    }
                }
            }
       }

   }   
   
   
    public function ConsultaTurno($idmat)
    {
        $turno = new turnos();
       return $turno->find_first("conditions: mataux_id='$idmat'"); 
    }   
   
   public function Formatofeha($fecha)
    {
       $time= new DateTime($fecha);
       return $time->format('d/m/Y');
    }
    
    public function Mostrarfecha($idaux)
    {
        $turno = new turnos();
       return $turno->find_first("conditions: mataux_id='$idaux'")->fecha;
    }
    
    public function MostrarHorario($idaux)
    {
       $turno = new turnos();
       return $turno->find_first("conditions: mataux_id='$idaux'")->horario; 
    }
}
