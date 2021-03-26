<?php
class Product{
    private $idProduct;
    private $productName;

    public function hydration($data){
        $this->idProduct=$data['id_products'];
        $this->productName=$data['product_name'];
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
     * Get the value of productName
     */ 
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set the value of productName
     *
     * @return  self
     */ 
    public function setProductName($productName)
    {
        $productNameError = "";
        if (empty($productName)) {
            $productNameError = 'Please enter an ingredient name';
        } else {
            $this->productName = $productName;
        }
        return  $productNameError;
    }
}