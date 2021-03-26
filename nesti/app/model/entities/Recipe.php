<?php
class Recipe
{
    private $idRecipe;
    private $creationDate;
    private $recipeName;
    private $difficulty;
    private $numberOfPeople;
    private $state;
    private $time;
    private User $chief;
    private Picture $picture;

    // constructor


    public function hydration($data)
    {
        $this->idRecipe = $data['id_recipes'];
        $this->creationDate = $data['creation_date'];
        $this->recipeName = $data['recipe_name'];
        $this->difficulty = $data['difficulty'];
        $this->numberOfPeople = $data['number_of_people'];
        $this->state = $data['state'];
        $this->time = $data['time'];
        if (isset($data['picture'])) {
            $this->picture = $data['picture'];
        }
        $this->chief = $data['chief'];
        return $this;
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
     * @return  string
     */
    public function setRecipeName($recipeName)
    {
        $RecipeNameError = "";
        if (empty($recipeName)) {
            $RecipeNameError = 'Please enter a Recipe Name';
        } else {
            $this->recipeName = $recipeName;
        }

        return  $RecipeNameError;
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
     * @return  string
     */
    public function setDifficulty($difficulty)
    {
        $DifficultyError = "";

        if (empty($difficulty)) {
            $DifficultyError = 'Please enter a Number';
        } else if (!preg_match("/[0-5]{1}/", $difficulty)) {
            $DifficultyError = "Only one digit between 0 and 5 allowed";
        } else {
            $this->difficulty = $difficulty;
        }
        return $DifficultyError;
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
     * @return   string
     */
    public function setNumberOfPeople($numberOfPeople)
    {
        $NumberOfPeopleError = "";
        if (empty($numberOfPeople)) {
            $NumberOfPeopleError = 'Please enter a Number';
        } else if (!preg_match("/^[0-9]/", $numberOfPeople)) {
            $NumberOfPeopleError = "Only numbers allowed";
        } else {
            $this->numberOfPeople = $numberOfPeople;
        }
        return  $NumberOfPeopleError;
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
        if ($this->time != null) {
            $troncatedTime = explode(":", $this->time);
            $convertedTime = (double) $troncatedTime[0] * 60 + (double) $troncatedTime[1] + (double) $troncatedTime[2] / 60;
        } else {
            $convertedTime = null;
        }

        return $convertedTime;
    }

    /**
     * Get the value of time for database
     */
    public function getTimeDatabase()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  string
     */
    public function setTime($preparationTime)
    {
        $PreparationTimeError = "";
        if (empty($preparationTime)) {
            $PreparationTimeError = 'Please enter a time';
        } else if (!preg_match("/^[0-9]/", $preparationTime)) {
            $PreparationTimeError = 'Please enter a time in minutes';
        } else {
            $convertedTimeHour = intdiv($preparationTime, 60); // retourne le quotient entier de la division
            $convertedTimeMinutes = fmod($preparationTime, 60); // retourne le reste de la division
            $convertedTime = $convertedTimeHour . ":" . $convertedTimeMinutes . ":00";
            $this->time = $convertedTime;
        }
        return $PreparationTimeError;
    }

    /**
     * Get the value of chief
     */
    public function getChief()
    {
        return $this->chief;
    }

    /**
     * Set the value of chief
     *
     * @return  self
     */
    public function setChief($chief)
    {
        $this->chief = $chief;

        return $this;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    
}
