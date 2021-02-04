<?php
class Recipe{
    private $idRecipe;
    private $creationDate;
    private $recipeName;
    private $difficulty;
    private $numberOfPeople;
    private $state;
    private $time;
    private $idPicture;
    private $idChief;

// constructor
public function __construct(array $data){
    $this->idRecipe=$data['id_recipes'];
    $this->creationDate=$data['creation_date'];
    $this->recipeName=$data['recipe_name'];
    $this->difficulty=$data['difficulty'];
    $this->numberOfPeople=$data['number_of_people'];
    $this->state=$data['state'];
    $this->time=$data['time'];
    $this->idPicture=$data['id_pictures'];
    $this->idChief=$data['id_chief'];
}

    /**
     * Get the value of idRecipe
     */ 
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }

    /**
     * Set the value of idRecipe
     *
     * @return  self
     */ 
    public function setIdRecipe($idRecipe)
    {
        $this->idRecipe = $idRecipe;

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
     * Get the value of recipeName
     */ 
    public function getRecipeName()
    {
        return $this->recipeName;
    }

    /**
     * Set the value of recipeName
     *
     * @return  self
     */ 
    public function setRecipeName($recipeName)
    {
        $this->recipeName = $recipeName;

        return $this;
    }

    /**
     * Get the value of difficulty
     */ 
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set the value of difficulty
     *
     * @return  self
     */ 
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get the value of numberOfPeople
     */ 
    public function getNumberOfPeople()
    {
        return $this->numberOfPeople;
    }

    /**
     * Set the value of numberOfPeople
     *
     * @return  self
     */ 
    public function setNumberOfPeople($numberOfPeople)
    {
        $this->numberOfPeople = $numberOfPeople;

        return $this;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

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
     * Get the value of idChief
     */ 
    public function getIdChief()
    {
        return $this->idChief;
    }

    /**
     * Set the value of idChief
     *
     * @return  self
     */ 
    public function setIdChief($idChief)
    {
        $this->idChief = $idChief;

        return $this;
    }
}