<?php
class RecipeDAO extends ModelDAO
{

    // public function getRecipes(){
    //     return $this->getAll('recipes','Recipe');
    // }

    public function getRecipes()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT r.id_recipes,r.creation_date,r.recipe_name,r.difficulty,r.number_of_people,r.state,r.time,r.id_pictures,id_chief,u.lastname FROM recipes r JOIN chief c ON r.id_chief=c.id_users JOIN users u ON c.id_users=u.id_users');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $item = new Recipe();
                $var[] = $item->hydration($row);
            }
            //echo "donnee sql / ";
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }
}
