<?php
class Comments{
    private $id_comments;
    private $commentTitle;
    private $commentContent;
    private $creationDate;
    private $state;
    private $idRecipe;
    private $idModerator;
    private $idUser;
    
    public function hydration($data)
    {
        $this->id_comments = $data['id_comments'];
        $this->commentTitle = $data['comments_title'];
        $this->commentContent = $data['comment_content'];
        $this->creationDate = $data['creation_date'];
        $this->state = $data['state'];
        $this->idRecipe = $data['id_recipes'];
        $this->idModerator = $data['id_moderator'];
        $this->idUser = $data['id_users'];
       
        return $this;
    }

    /**
     * Get the value of commentTitle
     */ 
    public function getCommentTitle()
    {
        return $this->commentTitle;
    }

    /**
     * Set the value of commentTitle
     *
     * @return  self
     */ 
    public function setCommentTitle($commentTitle)
    {
        $this->commentTitle = $commentTitle;

        return $this;
    }

    /**
     * Get the value of commentContent
     */ 
    public function getCommentContent()
    {
        return $this->commentContent;
    }

    /**
     * Set the value of commentContent
     *
     * @return  self
     */ 
    public function setCommentContent($commentContent)
    {
        $this->commentContent = $commentContent;

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
     * Get the value of idModerator
     */ 
    public function getIdModerator()
    {
        return $this->idModerator;
    }

    /**
     * Set the value of idModerator
     *
     * @return  self
     */ 
    public function setIdModerator($idModerator)
    {
        $this->idModerator = $idModerator;

        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of id_comments
     */ 
    public function getId_comments()
    {
        return $this->id_comments;
    }

    /**
     * Set the value of id_comments
     *
     * @return  self
     */ 
    public function setId_comments($id_comments)
    {
        $this->id_comments = $id_comments;

        return $this;
    }
}