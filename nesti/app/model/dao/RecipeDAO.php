<?php
class RecipeDAO extends ModelDAO
{

    public function getRecipes()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT r.id_recipes,r.creation_date,r.recipe_name,r.difficulty,r.number_of_people,r.state,r.time,r.id_pictures,r.id_chief FROM recipes r');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $item = new Recipe();
                // create the Chief Object base on is ID
                $userDao = new UserDAO();
                $chief = $userDao->getChief($row["id_chief"]);
                // create the Picture Object base on is ID
                $modelDAO = new ModelDAO();
                $picture = $modelDAO->getPicture($row["id_pictures"]);
                // add the chief and picture to the data $row
                $row['chief'] = $chief;
                $row['picture'] = $picture;
                $var[] = $item->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getRecipe($idRecipe)
    {
        $req = self::$_bdd->prepare('SELECT r.id_recipes,r.creation_date,r.recipe_name,r.difficulty,r.number_of_people,r.state,r.time,r.id_pictures,r.id_chief FROM recipes r WHERE r.id_recipes=:id');
        $req->execute(array("id" => $idRecipe));
        $recipe = $req->fetch();
        $itemRecipe = new Recipe();
        // create the Chief Object base on is ID
        $userDao = new UserDAO();
        $chief = $userDao->getChief($recipe["id_chief"]);
        // create the Picture Object base on is ID
        $modelDAO = new ModelDAO();
        $picture = $modelDAO->getPicture($recipe["id_pictures"]);
        // add the chief and picture to the data $row
        $recipe['chief'] = $chief;
        $recipe['picture'] = $picture;
        $itemRecipe->hydration($recipe);

        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $itemRecipe;
    }

    public function getParagraphs($idRecipe)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT p.id_paragraph, p.content, p.order, p.creation_date, p.id_recipes FROM paragraph p WHERE p.id_recipes=:id');
        $req->execute(array("id" => $idRecipe));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $para = new Paragraph();
                $var[] = $para->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getIngredients($idRecipe)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT r.quantity, r.order, r.id_unit_measures, p.id_products, p.product_name FROM recipe_ingredients r JOIN ingredients i ON r.id_ingredients = i.id_ingredients JOIN products p ON p.id_products = i.id_ingredients WHERE r.id_recipes=:id');
        $req->execute(array("id" => $idRecipe));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $recipeIngredient=new RecipeIngredients();
                // create the object ingredient
                $ing = new Ingredients();
                $dataIng = $ing->hydration(['id_products', 'product_name']);
                // create the object unit measure
                $modelDAO = new ModelDAO();
                $unit = $modelDAO->getUnitMeasure($row['id_unit_measures']);
                // add ingredient and unit measure to the data $row
                $row['ingredient']=$dataIng;
                $row['unitMeasure']=$unit;
                $var[]=$recipeIngredient->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }
}
