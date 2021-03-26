<?php
class Paragraph
{
    private $idParagraph;
    private $content;
    private $order;
    private $creationDate;
    private $idRecipe;

    public function hydration($data)
    {
        $this->idParagraph = $data['id_paragraph'];
        $this->content = $data['content'];
        $this->order = $data['order_paragraph'];
        $this->creationDate = $data['creation_date'];
        $this->idRecipe = $data['id_recipes'];
        return $this;
    }


    /**
     * Get the value of idParagraph
     */
    public function getIdParagraph()
    {
        return $this->idParagraph;
    }

    /**
     * Set the value of idParagraph
     *
     * @return  self
     */
    public function setIdParagraph($idParagraph)
    {
        $this->idParagraph = $idParagraph;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */
    public function setOrder($order)
    {
        $this->order = $order;

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
}
