<?php
class provincia extends ActiveRecord
{
    public function MostrarProv() //lista las provincias
    {
        $prov = new provincia();
        return $prov->find("order: nombre");
    }
    
    public function DevolverProv($cod) //Recibe el codigo de provincia y devuelve el nombre de la misma
    {
        $prov = new provincia();
        return $prov->find_first("$cod")->nombre;
    }
}