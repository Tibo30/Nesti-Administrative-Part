<?php
class ArticleDAO extends ModelDAO
{
    public function getArticles()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM articles a');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $article = new Article();
                $article->hydration($row);
                $var[] = $article;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getArticle($idArticle){
        $req = self::$_bdd->prepare('SELECT * FROM articles a WHERE a.id_article=:id');
        $req->execute(array("id" => $idArticle));
        $article = new Article();
        if ($data = $req->fetch()) {
            $article->hydration($data);
            //var_dump($article->getIdArticle());
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $article;
    }

    public function getimportedArticles()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM import i GROUP BY i.id_article');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $article = $this->getArticle($row['id_article']);
                    $var[] = $article;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }
}
