<?php
class City{
    protected $idCity;
    protected $cityName;

    public function hydration($data)
    {
        $this->idCity = $data['id_city'];
        $this->cityName = $data['city_name'];
       
        return $this;
    }

    /**
     * Get the value of idCity
     */ 
    public function getIdCity()
    {
        return $this->idCity;
    }

    /**
     * Set the value of idCity
     *
     * @return  self
     */ 
    public function setIdCity($idCity)
    {
        $this->idCity = $idCity;

        return $this;
    }

    /**
     * Get the value of cityName
     */ 
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set the value of cityName
     *
     * @return  string
     */ 
    public function setCityName($cityName)
    {
        $cityError = "";
        if (empty($cityName)) {
            $cityError = "Please enter a city";
        } else if (!preg_match("/^[a-zA-ZÀ-ÿ ,.'-]{3,20}+$/i", $cityName)) {
            $cityError = "The city is incorrect";
        } else {
            $this->cityName = $cityName;
        }
        return  $cityError;
    }
}