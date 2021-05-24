<?php
class RecipeIngredientsDAO extends ModelDAO
{

    /**
     * get ingredients for a recipe
     * int $idRecipe
     */
    public function getRecipeIngredients($idRecipe)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM recipe_ingredients r WHERE r.id_recipes=:id ORDER BY r.order_ingredient ASC');
        $req->execute(array("id" => $idRecipe));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $recipeIngredient = new RecipeIngredients();
                $var[] = $recipeIngredient->hydration($row);;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    /**
     * get a recipe ingredient
     * RecipeIngredient $recipeIngredient
     */
    public function getRecipeIngredient($recipeIngredient)
    {
        $req = self::$_bdd->prepare('SELECT * FROM recipe_ingredients r WHERE r.id_recipes=:id, r.quantity=:quantity, r.id_unit_measure=:idUnit, r.id_ingredients:=idIng');
        $req->execute(array("id" => $recipeIngredient->getIdRecipe(), "quantity" => $recipeIngredient->getQuantity(), "idUnit" => $recipeIngredient->getIDUnitMeasure(), "idIng" => $recipeIngredient->getIDIngredient()));
        $ingredientRecipe = new RecipeIngredients();
        if ($ingredient =  $req->fetch()) {
            $ingredientRecipe->hydration($ingredient);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $ingredientRecipe;
    }

    /**
     * create recipe ingredient
     * RecipeIngredient $recipeIngredient
     */
    public function createRecipeIngredient($recipeIngredient)
    {
        $req = self::$_bdd->prepare('INSERT INTO recipe_ingredients (quantity, order_ingredient, id_unit_measures, id_recipes, id_ingredients) VALUES (:quantity, :order, :idUnit, :idRecipe, :idIng)');
        $req->execute(array("quantity" => $recipeIngredient->getQuantity(), "order" => $recipeIngredient->getOrder(), "idUnit" => $recipeIngredient->getIDUnitMeasure(), "idRecipe" => $recipeIngredient->getIdRecipe(), "idIng" => $recipeIngredient->getIDIngredient()));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }

    /**
     * delete recipe ingredient
     * int $idRecipe, int $idIngredient, int $order
     */
    public function deleteRecipeIngredient($idRecipe, $idIngredient, $order)
    {
        $req = self::$_bdd->prepare('DELETE FROM recipe_ingredients WHERE id_recipes=:idRecipe AND id_ingredients=:idIngredient AND order_ingredient=:order');
        $req->execute(array("idRecipe" => $idRecipe, "idIngredient" => $idIngredient, "order" => $order));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }

    /**
     * edit order recipe ingredient
     * int $idRecipe, int $idIngredient, int $order, int $newOrder
     */
    public function editRecipeIngredient($idRecipe, $idIngredient, $order, $newOrder)
    {
        $req = self::$_bdd->prepare('UPDATE recipe_ingredients SET order_ingredient=:newOrder WHERE id_recipes=:idRecipe AND id_ingredients=:idIngredient AND order_ingredient=:order');
        $req->execute(array("newOrder" => $newOrder, "idRecipe" => $idRecipe, "idIngredient" => $idIngredient, "order" => $order));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }
}
