<?php
class Article
{
    private $idArticle;
    private $quantityPerUnit;
    private $state;
    private $creationDate;
    private $updateDate;
    private $iDUnitMeasure;
    private $iDProduct;
    private $iDPicture;
    private $userArticleName;

    public function hydration($data)
    {
        $this->idArticle = $data['id_article'];
        $this->quantityPerUnit = $data['quantity_per_unit'];
        $this->state = $data['state'];
        $this->creationDate = $data['creation_date'];
        $this->updateDate = $data['update_date'];
        $this->iDUnitMeasure = $data['id_unit_measures'];
        $this->iDProduct = $data['id_products'];
        if (isset($data['id_pictures'])) {
            $this->iDPicture = $data['id_pictures'];
        }
        $this->userArticleName = $data['user_article_name'];
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


    // Display state for tables
    public function getDisplayState()
    {
        $state = $this->state;
        if ($this->state == 'a') {
            $state = 'Active';
        }
        if ($this->state == 'b') {
            $state = 'Blocked';
        }
        if ($this->state == 'w') {
            $state = 'Waiting';
        }
        return $state;
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
     * Get the value of iDUnitMeasure
     */
    public function getIDUnitMeasure()
    {
        return $this->iDUnitMeasure;
    }

    /**
     * Set the value of iDUnitMeasure
     *
     * @return  self
     */
    public function setIDUnitMeasure($iDUnitMeasure)
    {
        $this->iDUnitMeasure = $iDUnitMeasure;

        return $this;
    }

    /**
     * Get the value of iDProduct
     */
    public function getIDProduct()
    {
        return $this->iDProduct;
    }

    /**
     * Set the value of iDProduct
     *
     * @return  self
     */
    public function setIDProduct($iDProduct)
    {
        $this->iDProduct = $iDProduct;

        return $this;
    }

    /**
     * Get the value of iDPicture
     */
    public function getIDPicture()
    {
        return $this->iDPicture;
    }

    /**
     * Set the value of iDPicture
     *
     * @return  self
     */
    public function setIDPicture($iDPicture)
    {
        $this->iDPicture = $iDPicture;

        return $this;
    }

    /**
     * Get the UnitMeasure
     */
    public function getUnitMeasure()
    {
        $unitDAO = new UnitMeasureDAO();
        $unit = $unitDAO->getUnitMeasure($this->iDUnitMeasure);
        return $unit;
    }

    /**
     * Get the UnitMeasure
     */
    public function getProduct()
    {
        $productDAO = new ProductDAO();
        $product = $productDAO->getProduct($this->iDProduct);
        return $product;
    }

    /**
     * Get the UnitMeasure
     */
    public function getPicture()
    {
        $pictureDAO = new PictureDAO();
        $picture = $pictureDAO->getPicture($this->iDPicture);
        return $picture;
    }

    /**
     * Get the lastImport of article
     */
    public function getLastImport()
    {
        $importDAO = new ImportDAO();
        $import = $importDAO->getLastImport($this->idArticle);
        return $import;
    }


    /**
     * Get the article price
     */
    public function getPrice()
    {
        $priceDAO = new ArticlePriceDAO();
        $price = $priceDAO->getPrice($this->idArticle);
        return $price;
    }


    /**
     * Get the value of userArticleName
     */
    public function getUserArticleName()
    {
        return $this->userArticleName;
    }

    /**
     * Set the value of userArticleName
     *
     * @return  string
     */
    public function setUserArticleName($userArticleName)
    {
        $articleUserNameError = "";
        if (empty($userArticleName)) {
            $this->userArticleName = "";
            // $articleUserNameError = "Veuillez entrer un nom";
        } else {
            $this->userArticleName = $userArticleName;
        }
        return  $articleUserNameError;
    }

    public function getType()
    {
        $productDAO = new ProductDAO();
        $type = $productDAO->getType($this->iDProduct);
        return $type;
    }

    public function getStock()
    {
        $lotDAO = new LotDAO();
        $orderDAO = new OrderDAO();
        $orderLines = $orderDAO->getOrderLinesArticle($this->idArticle); // get all the order lines for an article
        $lots = $lotDAO->getLots($this->idArticle); // get all the lots for an article
        $quantityOrdered = 0;
        $quantityBought = 0;
        foreach ($orderLines as $orderLine) {
            $quantityOrdered += $orderLine->getQuantityOrdered();
        }
        foreach ($lots as $lot) {
            $quantityBought += $lot->getBoughtQuantity();
        }
        $stock = $quantityBought - $quantityOrdered;
        return $stock;
    }

    public function getQuantityBought()
    {
        $lotDAO = new LotDAO();
        $lots = $lotDAO->getLots($this->idArticle); // get all the lots for an article
        $quantityBought = 0;
        foreach ($lots as $lot) {
            $quantityBought += $lot->getBoughtQuantity();
        }
        return $quantityBought;
    }

    public function getQuantitySold()
    {
        $orderDAO = new OrderDAO();
        $orderLines = $orderDAO->getOrderLinesArticle($this->idArticle); // get all the order lines for an article
        $quantitySold = 0;
        foreach ($orderLines as $orderLine) {
            $quantitySold += $orderLine->getQuantityOrdered();
        }
        return $quantitySold;
    }

    public function getTotalSales()
    {
        $orderDAO = new OrderDAO();
        $orderLines = $orderDAO->getOrderLinesArticle($this->idArticle); // get all the order lines for an article
        $totalSales = 0;
        foreach ($orderLines as $orderLine) {
            $totalSales += $orderLine->getQuantityOrdered() * $this->getPrice()->getPrice();
        }
        return $totalSales;
    }

    public function getTotalBought()
    {
        $lotDAO = new LotDAO();
        $lots = $lotDAO->getLots($this->idArticle); // get all the lots for an article
        $totalBought = 0;
        foreach ($lots as $lot) {
            $totalBought += $lot->getBoughtQuantity() * $lot->getUnitCost();
        }
        return $totalBought;
    }

    public function getBenefits()
    {
        $benefits = $this->getTotalSales() - $this->getTotalBought();
        return $benefits;
    }
}
