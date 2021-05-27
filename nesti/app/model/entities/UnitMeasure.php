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
     * @return  string
     */ 
    public function setName($name)
    {
        $unitNameError = "";
        if (empty($name)) {
            $unitNameError = 'Please enter a unit measure name';
        } else {
            $this->name = $name;
        }
        return  $unitNameError;
    }
}