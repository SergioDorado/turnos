<?php
include 'turnos.php';

class matriculado extends ActiveRecord
{
    protected function initialize(){
        $this->validates_presence_of('dni','message: El campo <b>Documento</b> no puede estar vacio');
        $this->validates_presence_of("apellido");
        $this->validates_presence_of("nombre");
        $this->validates_presence_of("fnac");
        $this->validates_presence_of("lugnac");
        $this->validates_presence_of("nacionalidad");
        $this->validates_presence_of("mail");
        
    }
    
    function Ultimo() // devuelve el ultimo matriculado registrado
    {
        $mat=new matriculado();
        return $mat->find_first("order: id desc");
    }
    
    public function LlamarTurnos($id,$instform){ //funcion que determina si corresponde un turno largo o turno corto
        
        View::select('asignar');
        Load::model('turnos');
        $turnos = new turnos();
        if ($instform==NULL)
            {
             $turnos->asignar($id); //pasa el control al modelo de turnos, para asignar un turno corto.
            }
            else
                {
                    $turnos->asignarlarg($id);// pasa el control al modelo de turnos, para asignar un turno largo.
                }
        
        
    }
    
    public function consulta($dni){// consulta un matriculado en particular por dni
        
       $mat = new matriculado();
       return $mat->find_first("conditions: dni = $dni");
    }
    
    Public function consulta1($id)//consulta un matriculado en particular por id
    {
        $mat = new matriculado();
       return $mat->find($id);
    }
    
    public function MandarAux($idmatri,$idporf,$idinstform,$tit,$fecegre,$rev,$identrev,$instform)//paso todos los datos de la tabla auxiliar al modelo mataux
    {
        Load::model('mataux');
        $aux = new mataux();
        $aux->GuardarAux($idmatri, $idporf, $idinstform, $tit, $fecegre, $rev, $identrev, $instform);
    }
    
    
    public function CoparaFecha($fecha) //compara la fecha de hoy con la fecha del turno pasado por parametro.
    {
        if ($fecha >= date('Y-m-d'))
        {
            return TRUE; 
        }   
        
        
    }

    
}
