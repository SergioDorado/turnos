<?php

class tramite extends ActiveRecord
{
    
    /*  Funcion que recive el codigo de tramite y devuelve el tipo de tramite para motrar en la vista
     * 0 = Constancia de matricula activa
     * 1 = Baja de Matricula
     * 2 = Certificacion de libre sancion porfesional
     */
    public function TransformarTramite($codigo)
    {
        switch ($codigo)
        {
            case 0: return 'Constancia de matrícula activa';break;
            case 1: return 'Baja de matrícula';break;
            case 2: return 'Certificación de libre sanción profesional';break;
        }
    }
    
    public function ExisteEnRefeps($dni)
    {
        Load::model('refeps');
        $prof = new refeps();
        return $prof->exists("dni = $dni");
    }
    
    public function GetNombre($dni)
    {
        Load::model('refeps');
        $prof = new refeps();
        return $prof->TraerNombre($dni);
            
    }
    
    public function GetMatricula($dni)
    {
        Load::model('refeps');
        $prof = new refeps();
        return $prof->TraerMatricula($dni);
    }
    
 
}