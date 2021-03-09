<?php
class ArticlePrice{
    private $idArticlePrice;
    private $applicationDate;
    private $price;
    private $iDArticle;

    public function hydration($data){
        $this->idArticlePrice=$data['id_article_price'];
        $this->applicationDate=$data['application_date'];
        $this->price=$data['price'];
        $this->iDArticle=$data['id_article'];
        return $this;
    }

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
     * Get the value of iDArticle
     */ 
    public function getIDArticle()
    {
        return $this->iDArticle;
    }

    /**
     * Set the value of iDArticle
     *
     * @return  self
     */ 
    public function setIDArticle($iDArticle)
    {
        $this->iDArticle = $iDArticle;

        return $this;
    }
}