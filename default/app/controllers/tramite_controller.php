<?php

Load::models('tramite');
class TramiteController extends AppController
{
    public function create($dni)
   {
        if(Input::hasPost('tramite'))
        {
          //Se le pasa el modelo por constructor los datos del Form y ActiveRecord
          //recoge esos datos y se los asocia al campo correspondiente siempre y
          //cuando se utilice la convencion model.campo
          $tramite = new Tramite(Input::post('tramite'));
          $tramite->fec = new date() ;
          $tramite->dni = $dni;
          //en caso de fallar el guardado
          
            if($tramite->create($dni)){
                //Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                $this->nombtramite = $tramite->nombre;
                $this->apetramite = $tramite->apellido;
                $this->dnitramite = $tramite->dni;
                $this->tramite = Load::model('tramite')->TransformarTramite($tramite->tramite);
                Input::delete();  
                 View::select('exito');
                return; 
               
            }else{
                Flash::error('Falló Operación');
            }
        }
    }
    
    public function tramitecreate($dni)
    {
        $this->listarefp = Load::model('refeps')->ListRefeps($dni);
        if(Input::hasPost('tramite'))
        {
          //Se le pasa el modelo por constructor los datos del Form y ActiveRecord
          //recoge esos datos y se los asocia al campo correspondiente siempre y
          //cuando se utilice la convencion model.campo
          $tramite = new Tramite(Input::post('tramite'));
          $tramite->fec = new date() ;
          $tramite->dni = $dni;
          $tramite->apellido = Load::model('refeps')->TraerNombre($dni);
          //en caso de fallar el guardado
          
            if($tramite->create($dni)){
                //Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                $this->apetramite = $tramite->apellido;
                $this->dnitramite = $tramite->dni;
                $this->tramite = Load::model('tramite')->TransformarTramite($tramite->tramite);
                Input::delete();  
                View::select('tramiteexito2');
                return; 
               
            }else{
                Flash::error('Falló Operación');
            }
        }
    }
    
          public function verificar2()//verifica la existencia cuando solicita otro tramite
      {
                $tram = new tramite();
          if (Input::hasPost('ExisteDni2'))
          {
              $dniE2 = Input::post('ExisteDni2');
              $this->dniE = $dniE2;
              $this->apynom = $tram->GetNombre($dniE2);
              $this->matricula = $tram->GetMatricula($dniE2);
              Input::delete();
              if($tram->ExisteEnRefeps($dniE2))
              {
                    View::select('tramitecreate');
                    $this->tramitecreate($dniE2);
              }
              else
              {
                  View::select("create");
                  $this->create($dniE2);
              }
          }
      }
    
}
