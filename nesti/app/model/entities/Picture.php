<?php
class Picture{
    private $idPicture;
    private $creationDate;
    private $name;
    private $extension;

    public function hydration($data){
        $this->idPicture=$data['id_pictures'];
        $this->creationDate=$data['creation_date'];
        $this->name=$data['name'];
        $this->extension=$data['extension'];
        return $this;
    }

    /**
     * Get the value of idPicture
     */ 
    public function getIdPicture()
    {
        return $this->idPicture;
    }

    /**
     * Set the value of idPicture
     *
     * @return  self
     */ 
    public function setIdPicture($idPicture)
    {
        $this->idPicture = $idPicture;

        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

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

    /**
     * Get the value of extension
     */ 
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the value of extension
     *
     * @return  self
     */ 
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }
}