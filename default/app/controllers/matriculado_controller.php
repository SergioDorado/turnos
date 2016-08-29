<?php

Load::models('matriculado');
class MatriculadoController extends AppController
{
     public function Vturno()
     {
       View::select('asignar');
     }
    
    public function index()
    {
       // $matriculado = new Matriculado();
    }
    
   public function create($dni)
   {
       //Flash::valid($dni);
        $this->doc=$dni;
        if(Input::hasPost('matriculado'))
        {
          //Se le pasa el modelo por constructor los datos del Form y ActiveRecord
          //recoge esos datos y se los asocia al campo correspondiente siempre y
          //cuando se utilice la convencion model.campo
          $matriculado = new Matriculado(Input::post('matriculado')); //control del id de los matriculados
          $matriculado->id = Load::model('matriculado')->Ultimo->id + 1;
          $matriculado->dni = $dni;
          Flash::valid($dni);
          Load::models('mataux');
          $mataux1 = new mataux(Input::post('mataux'));
          $mataux2 = new mataux();
          //en caso de fallar el guardado
          
            if($matriculado->create()){
                //Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                $this->nom=$matriculado->nombre;
                $this-> ape=$matriculado->apellido;
                $this->doc=$matriculado->dni;
                if($mataux1->codif_id == NULL)
                {
                    $mataux1->codif_id = 001;                            
                }
                $matriculado->MandarAux($matriculado->id, $mataux1->prof_id, $mataux1->codif_id, $mataux1->titulo,
                       $mataux1->fecegre, $mataux1->revalida, $mataux1->entrevalida_id, $mataux1->instform);
                $matriculado->LlamarTurnos($mataux2->UltimoAux()->id,$mataux1->instform);
                return;               
            }else{
                Flash::error('Falló Operación');
            }
        }
    }
   
    public function before_create($matriculado)
    {
//      View::select('confirmacion');
//      $this->nombre = $matriculado->nombre;
    }   
  
    public function confirmacion()
    {
        View::select('confirmacion');
    }
 
    public function enviar()
      {
        Load::lib('email');
        $para_nombre = "Sergio";
        $asunto = "Mail de prueba"; //El asunto del correo
        $cuerpo = "Este es mi correo de prueba"; //Aquí va el contenido HTML 
        $para_correo = "sad_35842@hotmail.com"; //Correo destino

        //Email::sendContact($para_correo, $para_nombre, $asunto, $cuerpo);
        $mail->envmail();
      }
      
      public function redirect()
      {
          View::select('/tramite/create');
      }
      
      public function consultas()
      {
          $matri = new matriculado();
          $turno = new turnos();
          if (Input::hasPost('dnicons'))
          {
               $dni1 = Input::post('dnicons') ;  
               Input::delete();
               
               if ($matri->exists("dni= $dni1"))
               {
                   $matri = Load::model('matriculado')->consulta($dni1);
                   //$this->listamataux = Load::model('matriculado')->Cosult1($matri->id);
                   $this->listamataux = Load::model('mataux')->ListMataux($matri->id);
                   $this->nombre = $matri->nombre;
                   $this->apellido = $matri->apellido;
                   $this->dni = $matri->dni;
//                   $this->fecha = $turno->fecha;
//                   $this->horario = Load::model('turnos')->TransformarHorario($turno->horario);
                   
               }
               else{ echo"El dni ingresado no existe"; }
          }
          
          
      }
      
      public function verificar()// verifica la existencia cuando solicita un turno
      {
          $matri = new matriculado();
          if (Input::hasPost('ExisteDni'))
          {
              $dniE = Input::post('ExisteDni');
              Input::delete();
              if($matri->exists("dni= $dniE"))
              {
                  $matri = Load::model('matriculado')->consulta($dniE);
                  view::select("profesion");
                  $this->profesion($matri->dni);
                  //Redirect::to("/matriculado/profesion/$matri->id");
              }
              else
              {
                  View::select("create");
                  $this->create($dniE);
              }
          }
      }


    public function profesion($id)
    {
        //echo "el ide pasado es: $id";
        $this->identificador = $id;
        $this->provincia = $clave;
        if (Input::hasPost('mataux'))
        {
            //$matriculado = new matriculado();
            $matriculado = Load::model('matriculado')->consulta($id);
            Load::models('mataux');
            $this->nom=$matriculado->nombre;
            $this-> ape=$matriculado->apellido;
            $this->doc=$matriculado->dni;
            $mataux1 = new mataux(Input::post('mataux'));
            $mataux2 = new mataux();
            if($mataux1->codif_id == NULL)
            {
                $mataux1->codif_id = 001;                            
            }
            $matriculado->MandarAux($matriculado->id, $mataux1->prof_id, $mataux1->codif_id, $mataux1->titulo,
            $mataux1->fecegre, $mataux1->revalida, $mataux1->entrevalida_id, $mataux1->instform);
            $matriculado->LlamarTurnos($mataux2->UltimoAux()->id,$mataux1->instform);   
            
        }
       
        
    }
     
    public function filtro1($clave)
    {
        //View::select('profesion');
        $this->provincia = $clave;
    }
    
    public function asignar2($id)
    {
        Load::model('mataux');
        $matax=new mataux();                
        $matau =$matax->MatAuxU($id);
        $mat=new matriculado();
        $mat1 = $mat->consulta1($matau->matri_id);
        Load::model('turnos');
        $turn= new turnos();
        $tur = $turn->ConsultaTurno($id);
        $this->tur=$tur->horario; //orden de turno nimerico
        $this->hor= $tur->TransformarHorario($tur->horario);//horario del turno
        $this->fech=$tur->Formatofeha($tur->fecha);
        $this->nom=$mat1->nombre;
        $this-> ape=$mat1->apellido;
        $this->doc=$mat1->dni;
    }
}

        