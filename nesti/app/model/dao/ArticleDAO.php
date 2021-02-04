<?php
class ArticleDAO extends ModelDAO{
    public function getArticles(){
        return $this->getAll('articles','Article');
    }
}