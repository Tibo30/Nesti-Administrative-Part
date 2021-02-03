<?php
class ArticlePrice{
    private $idArticlePrice;
    private $applicationDate;
    private $price;
    private $idArticle;

    

    /**
     * Get the value of idArticlePrice
     */ 
    public function getIdArticlePrice()
    {
        return $this->idArticlePrice;
    }

    /**
     * Set the value of idArticlePrice
     *
     * @return  self
     */ 
    public function setIdArticlePrice($idArticlePrice)
    {
        $this->idArticlePrice = $idArticlePrice;

        return $this;
    }

    /**
     * Get the value of applicationDate
     */ 
    public function getApplicationDate()
    {
        return $this->applicationDate;
    }

    /**
     * Set the value of applicationDate
     *
     * @return  self
     */ 
    public function setApplicationDate($applicationDate)
    {
        $this->applicationDate = $applicationDate;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of idArticle
     */ 
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set the value of idArticle
     *
     * @return  self
     */ 
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }
}