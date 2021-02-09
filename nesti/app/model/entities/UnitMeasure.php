<?php
class UnitMeasure{
    private $idUnitMeasure;
    private $name;


    public function hydration($data){
        $this->idUnitMeasure=$data['id_unit_measures'];
        $this->name=$data['name'];
        return $this;
    }


    /**
     * Get the value of idUnitMeasure
     */ 
    public function getIdUnitMeasure()
    {
        return $this->idUnitMeasure;
    }

    /**
     * Set the value of idUnitMeasure
     *
     * @return  self
     */ 
    public function setIdUnitMeasure($idUnitMeasure)
    {
        $this->idUnitMeasure = $idUnitMeasure;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}