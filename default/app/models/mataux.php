<?php

class mataux extends ActiveRecord
{
    
 public function GuardarAux($idmatri,$idporf,$idinstform,$tit,$fecegre,$rev,$identrev,$instform)
 {
    
     $param= array('matri_id'=>$idmatri,'codif_id'=>$idinstform,'prof_id'=>$idporf,'titulo'=>$tit,'fecegre'=>$fecegre,'revalida'=>$rev,
         'entrevalidad_id'=>$identrev,'instform'=>$instform);
     $aux=new mataux($param);
     $aux->save();
 }
 
 public function UltimoAux()// trae el ultimo registro guardado
    {
        $mataux=new mataux();
        return ($mataux->find_first('order: id desc'));
    }
    
    public function ListMataux($idmat) //Trae todos los registro que pertenezcan a un matriculado
    {
        $mataux = new mataux();
       return $mataux->find("conditions: matri_id='$idmat'","order: id desc"); 
    } 
    
    public function ConsultarProfesion($cod)// devuelve el nombre de la profesion
    {
        Load::model('profecion');
        $prof = new profecion();
        return $prof->NombreProfesion($cod);
    }
    
    public function ConsTurnoFecha($id)// devuelve la fecha del turno
    {
        Load::model('turnos');
        $tur = new turnos();
        return $tur->Mostrarfecha($id);
    }
    
    public function ConsTurnoHorario($id)// devuelve el horario del turno
    {
        Load::model('turnos');
        $tur = new turnos();
        return $tur->MostrarHorario($id);
    }
    
    public function MatAuxU($id)// devuelve un registro en particular
    {
        $mat = new mataux();
        return $mat->find($id);             
    }
}

