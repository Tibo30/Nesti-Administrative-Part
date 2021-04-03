<?php
class CommentsDAO extends ModelDAO
{
    // get all comments for a moderator
    public function getCommentsModerator($idUser)
    {
        $var=[];
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

    // get all comments for a user
    public function getComments($idUser)
    {
        $var=[];
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
}
