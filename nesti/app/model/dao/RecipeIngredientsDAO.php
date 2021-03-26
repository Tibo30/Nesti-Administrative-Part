<?php
class RecipeIngredientsDAO extends ModelDAO
{
    
    public function getRecipeIngredients($idRecipe){
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM recipe_ingredients r WHERE r.id_recipes=:id ORDER BY r.order_ingredient ASC');
        $req->execute(array("id" => $idRecipe));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $recipeIngredient=new RecipeIngredients();
                $var[] = $recipeIngredient->hydration($row);;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getRecipeIngredient($recipeIngredient){
        $req = self::$_bdd->prepare('SELECT * FROM recipe_ingredients r WHERE r.id_recipes=:id, r.quantity=:quantity, r.id_unit_measure=:idUnit, r.id_ingredients:=idIng');
        $req->execute(array("id" => $recipeIngredient->getIdRecipe(),"quantity"=>$recipeIngredient->getQuantity(),"idUnit" => $recipeIngredient->getIDUnitMeasure(),"idIng" => $recipeIngredient->getIDIngredient()));
        $ingredient =  $req->fetch();
        $ingredientRecipe = new RecipeIngredients();
        $ingredientRecipe->hydration($ingredient);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $ingredientRecipe;
    }

    public function createRecipeIngredient($recipeIngredient)
    {
        $req = self::$_bdd->prepare('INSERT INTO recipe_ingredients (quantity, order_ingredient, id_unit_measures, id_recipes, id_ingredients) VALUES (:quantity, :order, :idUnit, :idRecipe, :idIng)');
        $req->execute(array("quantity" => $recipeIngredient->getQuantity(), "order"=>$recipeIngredient->getOrder(), "idUnit"=>$recipeIngredient->getIDUnitMeasure(),"idRecipe" => $recipeIngredient->getIdRecipe(),"idIng" => $recipeIngredient->getIDIngredient()));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }
    
}