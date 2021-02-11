<div class="container bg-white align-items-left" id="recipePage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp > Import</p>
    </div>
    <div class="d-flex flex-row justify-content-around">
        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">Import</h2>
            <form method="post">
                <label class="form-label" for="importCSV">Import a .CSV File</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="importCSV">
                    <label class="custom-file-label" for="importCSV" data-browse=""></label>
                </div>
            </form>
            <button class="btn mt-2 align-self-end" id="importArticle">Import</button>

        </div>
        <div>
        <div class="d-flex flex-column">
            <h3 class="mb-2 mt-2">List of imported articles</h2>
            <div class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
            </div>

        </div>

        </div>

    </div>

</div>