<?php
class CommentsDAO extends ModelDAO
{
    
    /**
     * get all comments for a moderator
     * int $idUser
     */
    public function getCommentsModerator($idUser)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM comments WHERE id_moderator=:id');
        $req->execute(array("id" => $idUser));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $comment = new Comments();
                $comment->hydration($row);
                $var[] = $comment;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    /**
     * get all comments for a user
     * int $idUser
     */
    public function getComments($idUser)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM comments WHERE id_users=:id');
        $req->execute(array("id" => $idUser));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $comment = new Comments();
                $comment->hydration($row);
                $var[] = $comment;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    /**
     * get a comment according to its id
     * int $idComment
     */
    public function getComment($idComment)
    {
        $req = self::$_bdd->prepare('SELECT * FROM comments WHERE id_comments=:id');
        $req->execute(array("id" => $idComment));
        $comment = new Comments();
        if ($data = $req->fetch()) {
            $comment->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $comment;
    }

     /**
     * edit state comment
     * int $idComment, String $state
     */
     public function editComment($idComment, $state)
     {
         $req = self::$_bdd->prepare('UPDATE comments SET state=:state WHERE id_comments=:id');
         $req->execute(array("state" => $state, "id" => $idComment));
         $req->closeCursor(); // release the server connection so it's possible to do other query
     }
}
