<?php
class Article
{
    private $idArticle;
    private $quantityPerUnit;
    private $state;
    private $creationDate;
    private $updateDate;
    private $idUnitMeasure;
    private $idProduct;
    private $idPictures;

public function hydration($data){
    $this->idArticle=$data['id_article'];
    $this->quantityPerUnit=$data['quantity_per_unit'];
    $this->state=$data['state'];
    $this->creationDate=$data['creation_date'];
    $this->updateDate=$data['update_date'];
    $this->idUnitMeasure=$data['id_unit_measures'];
    $this->idProduct=$data['id_products'];
    $this->idPictures=$data['id_pictures'];
}

// // hydration
// public function hydrate (array $data){
//     foreach($data as $key => $value){
//         $method='set'.ucfirst($key);
//         if(method_exists($this,$method)){
//             $this->$method($value);
//         }
//     }
// }

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

    /**
     * Get the value of quantityPerUnit
     */
    public function getQuantityPerUnit()
    {
        return $this->quantityPerUnit;
    }

    /**
     * Set the value of quantityPerUnit
     *
     * @return  self
     */
    public function setQuantityPerUnit($quantityPerUnit)
    {
        $this->quantityPerUnit = $quantityPerUnit;

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
     * Get the value of updateDate
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set the value of updateDate
     *
     * @return  self
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

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
     * Get the value of idProduct
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set the value of idProduct
     *
     * @return  self
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get the value of idPictures
     */
    public function getIdPictures()
    {
        return $this->idPictures;
    }

    /**
     * Set the value of idPictures
     *
     * @return  self
     */
    public function setIdPictures($idPictures)
    {
        $this->idPictures = $idPictures;

        return $this;
    }
}
