<?php

class Profecion extends ActiveRecord{
    
    public function proforde() {
        $prof = new Profecion();
        return($prof->find("order: prf_refe"));
    }
    
    public function NombreProfesion($cod)
    {
        $prof = new Profecion();
        return ($prof->find_first("conditions: codprof='$cod'")->prf_refe);
    }
    
}