<?php
class RecipeDAO extends ModelDAO
{

    //get all recipes
    public function getRecipes()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM recipes');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $item = new Recipe();
                $var[] = $item->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    //get all recipes from a chief
    public function getRecipesChief($idUser)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM recipes WHERE id_chief=:id');
        $req->execute(array("id" => $idUser));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $item = new Recipe();
                $var[] = $item->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    // get last recipe of a chief
    public function getLastRecipe($idUser)
    {
        $req = self::$_bdd->prepare('SELECT * FROM recipes WHERE id_chief=:id ORDER BY creation_date DESC LIMIT 1');
        $req->execute(array("id" => $idUser));
        $lastRecipe = new Recipe();
        if($recipe =  $req->fetch()){
            $lastRecipe->hydration($recipe);
        }       
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $lastRecipe;
    }

    // check if a recipe name already exist
    public function recipeDoesExist($recipeName)
    {
        $exist = false;
        $req = self::$_bdd->prepare('SELECT * FROM recipes WHERE recipe_name=:recipe');
        $req->execute(array("recipe" => $recipeName));
        if ($req->rowcount() == 1) {
            $exist = true;
        }

        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $exist;
    }

    // get recipe according to its id
    public function getRecipe($idRecipe)
    {
        $req = self::$_bdd->prepare('SELECT r.id_recipes,r.creation_date,r.recipe_name,r.difficulty,r.number_of_people,r.state,r.time,r.id_pictures,r.id_chief FROM recipes r WHERE r.id_recipes=:id');
        $req->execute(array("id" => $idRecipe));
        $itemRecipe = new Recipe();
        if($recipe = $req->fetch()){
            $itemRecipe->hydration($recipe);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $itemRecipe;
    }

    // get all paragraphs for a recipe
    public function getParagraphs($idRecipe)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT p.id_paragraph, p.content, p.order_paragraph, p.creation_date, p.id_recipes FROM paragraph p WHERE p.id_recipes=:id ORDER BY p.order_paragraph ASC');
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

    // get all ingredients
    public function getAllIngredients()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT p.id_products, p.product_name FROM products p JOIN ingredients i ON p.id_products = i.id_ingredients');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $ingredients = new Ingredients();
                $var[] = $ingredients->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    // add recipe to database
    public function addRecipe($recipeAdd)
    {
        $req = self::$_bdd->prepare('INSERT INTO recipes (creation_date, recipe_name, difficulty, number_of_people,state,time,id_chief) VALUES (CURRENT_TIMESTAMP, :name, :difficulty, :number, "a", :time, :chief) ');
        $req->execute(array("name" => $recipeAdd->getRecipeName(), "difficulty" => $recipeAdd->getDifficulty(), "number" => $recipeAdd->getNumberOfPeople(), "time" => $recipeAdd->getTimeDatabase(), "chief" => $_SESSION["idUser"]));
        $last_id = self::$_bdd->lastInsertId();
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $last_id;
    }

    // edit recipe in database
    public function editRecipe($recipeEdit, $change)
    {
        switch ($change) {
            case "picture":
                $req = self::$_bdd->prepare('UPDATE recipes SET id_pictures=:idPicture WHERE id_recipes=:id');
                $req->execute(array("idPicture" => ($recipeEdit->getIdPicture()), "id" => ($recipeEdit->getIdRecipe())));
                break;
            case "name":
                $req = self::$_bdd->prepare('UPDATE recipes SET recipe_name=:name WHERE id_recipes=:id');
                $req->execute(array("name" => ($recipeEdit->getRecipeName()), "id" => ($recipeEdit->getIdRecipe())));
                break;
            case "difficulty":
                $req = self::$_bdd->prepare('UPDATE recipes SET difficulty=:difficulty WHERE id_recipes=:id');
                $req->execute(array("difficulty" => ($recipeEdit->getDifficulty()), "id" => ($recipeEdit->getIdRecipe())));
                break;
            case "number":
                $req = self::$_bdd->prepare('UPDATE recipes SET number_of_people=:number WHERE id_recipes=:id');
                $req->execute(array("number" => ($recipeEdit->getNumberOfPeople()), "id" => ($recipeEdit->getIdRecipe())));
                break;
            case "time":
                $req = self::$_bdd->prepare('UPDATE recipes SET time=:time WHERE id_recipes=:id');
                $req->execute(array("time" => ($recipeEdit->getTimeDatabase()), "id" => ($recipeEdit->getIdRecipe())));
                break;
            default:
                break;
        }
    }

    // create paragraph for a recipe
    public function createParagraph($idRecipe, $order, $content)
    {
        $req = self::$_bdd->prepare('INSERT INTO paragraph (content,order_paragraph,creation_date,id_recipes) VALUES (:content, :order, CURRENT_TIMESTAMP, :idRecipe) ');
        $req->execute(array("content" => $content, "order" => $order, "idRecipe" => $idRecipe));
        $last_id = self::$_bdd->lastInsertId();
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $last_id;
    }

    // edit paragraph of a recipe
    public function editParagraph($idRecipe, $idParagraph, $order, $content)
    {
        $req = self::$_bdd->prepare('UPDATE paragraph SET order_paragraph=:order, content=:content WHERE id_recipes=:idRecipe AND id_paragraph=:idParagraph ');
        $req->execute(array("order" => $order, "content" => $content, "idRecipe" => $idRecipe, "idParagraph" => $idParagraph));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }

    // edit orrder paragraph of a recipe
    public function editOrderParagraph($idRecipe, $order, $newOrder)
    {
        $req = self::$_bdd->prepare('UPDATE paragraph SET order_paragraph=:newOrder WHERE id_recipes=:idRecipe AND order_paragraph=:order ');
        $req->execute(array("order" => $order, "newOrder" => $newOrder, "idRecipe" => $idRecipe));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }

    // delete paragaph of a recipe
    public function deleteParagraph($idParagraph)
    {
        $req = self::$_bdd->prepare('DELETE FROM paragraph WHERE id_paragraph=:idParagraph ');
        $req->execute(array("idParagraph" => $idParagraph));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }
}
