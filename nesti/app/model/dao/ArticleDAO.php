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
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $article;
    }

    public function editArticle($articleEdit,$change){
        if ($change=="articleUserName"){
            $req = self::$_bdd->prepare('UPDATE articles SET user_article_name=:name, update_date=CURRENT_TIMESTAMP WHERE id_article=:id');
            $req->execute(array("name" => ($articleEdit->getUserArticleName()),"id" => ($articleEdit->getIdArticle())));
        } else if ($change=="state"){
            $req = self::$_bdd->prepare('UPDATE articles SET state=:state, update_date=CURRENT_TIMESTAMP WHERE id_article=:id');
            $req->execute(array("state" => ($articleEdit->getState()),"id" => ($articleEdit->getIdArticle())));
        } else if ($change=="picture"){
            $req = self::$_bdd->prepare('UPDATE articles SET id_pictures=:idPicture, update_date=CURRENT_TIMESTAMP WHERE id_article=:id');
            $req->execute(array("idPicture" => ($articleEdit->getIDPicture()),"id" => ($articleEdit->getIdArticle())));
        } 
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
