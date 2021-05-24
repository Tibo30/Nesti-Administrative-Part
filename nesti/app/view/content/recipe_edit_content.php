<?php
if (!isset($recipe) || empty($recipe)) {
    $recipe = new Recipe();
}
if (!isset($paragraphs)) {
    $paragraphs = [];
    if (!empty($paragraphs)) {
        foreach ($paragraphs as $paragraph) {
            $paragraph = new Paragraph();
        }
    }
}
if (!isset($listAllIngredients)) {
    $listAllIngredients = [];
    if (!empty($recipes)) {
        foreach ($recipes as $ingredients) {
            $ingredients = new Ingredients();
        }
    }
}
if (!isset($recipeIngredients)) {
    $recipeIngredients = [];
    if (!empty($recipeIngredients)) {
        foreach ($recipeIngredients as $ingredient) {
            $ingredient = new RecipeIngredients();
        }
    }
}
if (!isset($listAllUnits)) {
    $listAllUnits = [];
    if (!empty($listAllUnits)) {
        foreach ($listAllUnits as $unit) {
            $unit = new UnitMeasure();
        }
    }
}
?>
    <div class="container bg-white align-items-left position-relative" id="recipeEditPage">

        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>recipe"><u>Recipes</u>
            </a>
            <p> &nbsp > Edit</p>
        </div>

        <!-- div notif recipe edit -->
        <div id="recipeEditSuccess" class="notifications" hidden>
            <p>The recipe has been successfully edited</p>
        </div>
        <!-- div notif picture recipe edit -->
        <div id="recipePictureEditSuccess" class="notifications" hidden>
            <p>The recipe picture has been successfully edited</p>
        </div>
        <div id="recipePictureEditMessage" class="notifications" hidden>
            <p></p>
        </div>
        <!-- div notif picture recipe delete -->
        <div id="recipePictureDeleteSuccess" class="notifications" hidden>
            <p>The recipe picture has been successfully deleted</p>
        </div>

        <div class="d-flex flex-row flex-wrap justify-content-around">
            <div class="d-flex flex-column">
                <h2 class="mb-2 mt-2">Recipe Edit</h2>
                <form method="post" id="editRecipeForm">
                    <div class="form-group">
                        <label for="inputEditRecipeName">Recipe name</label>
                        <input type="text" class="form-control" id="inputEditRecipeName" name="recipeName" value="<?= $recipe->getRecipeName() ?>">
                        <small id="recipeChiefName" class="form-text text-muted">Recipe Chief : <?= $recipe->getChief()->getLastname() . " " . $recipe->getChief()->getFirstname() ?></small>
                    </div>
                    <span class="text-danger" id="errorEditRecipeName"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputEditDifficulty">Difficulty (grade on 5)</label>
                        <div class="col-2 p-0"><input type="text" class="form-control" id="inputEditDifficulty" name="difficulty" value="<?= $recipe->getDifficulty() ?>"></div>
                    </div>
                    <span class="text-danger" id="errorEditDifficulty"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputEditNumberOfPeople">Number of people</label>
                        <div class="col-2 p-0"><input type="text" class="form-control" id="inputEditNumberOfPeople" name="numberOfPeople" value="<?= $recipe->getNumberOfPeople() ?>"></div>
                    </div>
                    <span class="text-danger" id="errorEditNumberPeople"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputEditPreparationTime">Preparation time in minutes</label>
                        <div class="col-2 p-0"><input type="text" class="form-control" id="inputEditPreparationTime" name="preparationTime" value="<?= $recipe->getTime() ?>"></div>
                    </div>
                    <span class="text-danger" id="errorEditTime"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputUserEditState">State</label> <br>
                        <select class="col-3 p-0" name="recipeState" id="recipeEditState">
                            <option value="a" <?php if ($recipe->getState() == 'a') {
                                                    echo 'selected';
                                                }; ?>>Active</option>
                            <option value="b" <?php if ($recipe->getState() == 'b') {
                                                    echo 'selected';
                                                }; ?>>Blocked</option>
                            <option value="w" <?php if ($recipe->getState() == 'w') {
                                                    echo 'selected';
                                                }; ?>>Waiting</option>
                        </select>
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                        <button id="submitEditRecipe" data-toggle="modal" type="button" data-target="#modalEditRecipe" class="btn mr-5">Submit</button>
                        <button id="cancelEditRecipe" type="reset" class="btn">Cancel</button>
                    </div>
                    <div class="modal fade" id="modalEditRecipe" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to update this recipe information ?</h5>
                                    <button type="button" class="close" id="closeModalEditRecipe" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button id="confirm-edit-recipe" class="btn" type="submit">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <input type="text" class="form-control" name="idRecipe" id="idRecipe" value="<?= $recipe->getIdRecipe() ?>" hidden>
            </div>

            <div id="editPicture" class="mt-3 mt-xl-0">
                <div id="recipePictureEdit" class="bg-light border mb-2" style='background-image:url("<?= $recipe->getIdPicture() != null ? BASE_URL . PATH_PICTURES . $recipe->getPicture()->getName() . "." . $recipe->getPicture()->getExtension() : "" ?>")'></div>
                <div class=" d-flex flex-row justify-content-between">
                    <p class="recipePictureEditName"><?= $recipe->getIdPicture() != null ? ($recipe->getPicture()->getName() . "." . $recipe->getPicture()->getExtension()) : "" ?></p>
                    <div class="recipePictureBin" data-toggle="modal" data-target="#modalDeletePictureRecipe"><img src=" <?php echo BASE_URL . PATH_ICONS ?>delete-svg.svg" alt="svg bin"></div>
                    <div class="modal fade" id="modalDeletePictureRecipe" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete this recipe picture ?</h5>
                                    <button type="button" class="close" id="closeModalDeletePictureRecipe" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button id="confirm-delete-picture-recipe" class="btn" type="submit">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="form-label" for="customFile">Download a new picture</label>
                <div class="custom-file">
                    <form id="formEditRecipeImage" action="" enctype="multipart/form-data" method="post">
                        <div class="d-flex flex-column">
                            <input type="file" class="custom-file-input" id="InputFileEditRecipe" name="image" onchange="updatePictureName()">
                            <div class = "d-flex align-items-center justify-content-end">
                                <p class="pictureNameInput w-100"></p>
                                <button data-toggle="modal" type="button" data-target="#modalEditPictureRecipe" class="align-self-end mt-1 btn" id="btn-edit-recipe-picture">OK</button>
                            </div>
                        </div>
                        <label class="custom-file-label" for="InputFileEditRecipe" data-browse="Browse"></label>
                        <div class="modal fade" id="modalEditPictureRecipe" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to update this recipe picture ?</h5>
                                        <button type="button" class="close" id="closeModalEditPictureRecipe" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="confirm-edit-picture-recipe" class="btn" type="submit">Confirm</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- div notif paragraph deleted -->
            <div id="recipeEditParagraphDeletedSuccess" class="notifications" hidden>
                <p>The paragraph has been successfully deleted from the recipe. Please don't forget to save ! </p>
            </div>
            <!-- div notif paragraph moved-->
            <div id="recipeEditParagraphMovedSuccess" class="notifications" hidden>
                <p>Please don't forget to save ! </p>
            </div>
            <!-- div notif paragraph saved-->
            <div id="recipeEditParagraphSavedSuccess" class="notifications" hidden>
                <p>The paragraphs have been saved in the database </p>
            </div>
            <!-- div notif ingredient added -->
            <div id="recipeEditIngredientEditSuccess" class="notifications" hidden>
                <p>The recipe ingredient has been successfully added</p>
            </div>
            <!-- div notif ingredient deleted -->
            <div id="recipeEditIngredientDeletedSuccess" class="notifications" hidden>
                <p>The recipe ingredient has been successfully deleted</p>
            </div>

        </div>



        <div class="container px-0 mx-0 mt-5 bg-light d-flex flex-row flex-wrap justify-content-between position-relative">

            <div class="col-12 col-lg-7">
                <h3 class="mb-2 mt-2">Preparation</h3>
                <div class="form-group">
                    <div id="paragraphsEditRecipe" class="d-flex flex-column">

                        <?php
                        $index = 0;
                        $paragraphs = $recipe->getParagraphs();
                        foreach ($paragraphs as $paragraph) {
                            echo '<div class="paragraphEditRecipeLine d-flex flex-row flex-wrap justify-content-between" order="' . $paragraph->getOrder() . '" data-id="' . $paragraph->getIdParagraph() . '">';
                            if ($index == 0) { // if this is the first paragraph
                                if (count($paragraphs) > 1) { // if there is more than 1 paragraph
                                    echo '<div class="paragraphIcons"><img class="downSvg" src="' . BASE_URL . PATH_ICONS . 'down-svg.png" alt="arrow down icon" ><img onclick="createModal(' . ($index + 1) . ',' . $paragraph->getIdParagraph() . ')" class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                        <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                        ';
                                } else { // if there is only 1 paragraph
                                    echo '                        <div class="paragraphIcons"><img onclick="createModal(' . ($index + 1) . ',' . $paragraph->getIdParagraph() . ')" class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                        <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                        ';
                                }
                            } else if ($index == count($paragraphs) - 1 && count($paragraphs) > 1) { // if this is the last paragraph and there is more than one
                                echo '                        <div class="paragraphIcons"><img class="upSvg" src="' . BASE_URL . PATH_ICONS . 'up-svg.png" alt="arrow up icon" ><img onclick="createModal(' . ($index + 1) . ',' . $paragraph->getIdParagraph() . ')" class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                        <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                        ';
                            } else {
                                echo '                        <div class="paragraphIcons"><img class="upSvg" src="' . BASE_URL . PATH_ICONS . 'up-svg.png" alt="arrow up icon" ><img class="downSvg" src="' . BASE_URL . PATH_ICONS . 'down-svg.png" alt="arrow down icon" ><img onclick="createModal(' . ($index + 1) . ',' . $paragraph->getIdParagraph() . ')" class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                            <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                            ';
                            }

                            echo '<div id="openModal' . ($index + 1) . '" hidden data-toggle="modal" data-target="#modalEditRecipeDeleteParagraph' . ($index + 1) . '"></div>';


                            echo ' </div>';
                            $index++;
                        }
                        ?>


                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <button id="addParagraphEditRecipe" class="btn" onclick="addParagraph()">
                            <div class="fas fa-plus"></div>
                        </button>
                        <button id="okParagraphEditRecipe" type="submit" class="btn mt-2">SAVE</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <h3 class="mb-2 mt-2">Ingredient List</h3>
                <div class="form-group">
                    <div id="addIngredientListEditRecipe" class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                        <?php foreach ($recipeIngredients as $recipeIngredient) {
                            echo ' <div class="d-flex flex-row justify-content-between"> <div class="mb-3"> ' . $recipeIngredient->getQuantity() . " " . $recipeIngredient->getUnitMeasure()->getName() . " of " . $recipeIngredient->getIngredient()->getProductName() . ' </div><div onclick="createModalDeleteIngredient(' . $recipeIngredient->getOrder() . ',' . $recipeIngredient->getIdRecipe() . ',' . $recipeIngredient->getIDIngredient() . ')" class="btn-delete-ingredient">delete</div><div id="openModalIngredient' . $recipeIngredient->getOrder() . '" hidden data-toggle="modal" data-target="#modalRecipeDeleteIngredient' . $recipeIngredient->getOrder() . '"></div></div>';
                        }
                        ?>
                    </div>
                    <div class="col-12 p-0 mb-3">
                        <label for="inputIngredientNameEditRecipe">Add an ingredient</label>
                        <input list="ingredientsEdit" type="text" class="form-control" placeholder="Ingredient" id="inputIngredientNameEditRecipe">
                        <datalist id="ingredientsEdit">
                            <?php
                            foreach ($listAllIngredients as $ingredients) {
                                echo '<option value="' . ($ingredients->getProductName()) . '">';
                            }
                            ?>
                        </datalist>
                        <span class="text-danger" id="errorRecipeEditIngredient"></span>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <div class="col-4 p-0"><input type="text" class="form-control" placeholder="Quantity" name="quantity" id="inputIngredientQuantityEditRecipe"></div>
                        <div class="col-5 p-0">
                            <input list="UnitsEdit" type="text" class="form-control" placeholder="Unit of Measure" name="unitMeasure" id="inputIngredientUnitEditRecipe">
                            <datalist id="UnitsEdit">
                                <?php
                                foreach ($listAllUnits as $unit) {
                                    echo '<option value="' . ($unit->getName()) . '">';
                                }
                                ?>
                            </datalist>
                        </div>
                        <button id="okIngredientEditRecipe" type="submit" class="btn">OK</button>
                        <span class="text-danger" id="errorRecipeEditQuantity"></span>
                        <span class="text-danger" id="errorRecipeEditUnit"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
        const ROOT = '<?= BASE_URL ?>';
    </script>