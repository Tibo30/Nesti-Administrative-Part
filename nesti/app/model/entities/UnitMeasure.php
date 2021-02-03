<?php
class UnitMeasure{
    private $idUnitMeasure;
    private $name;

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