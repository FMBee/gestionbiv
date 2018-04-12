
<h2>Récapitulatif Prix de Cession Agences</h2>

<form action="index.php?uc=recapCession&action=download" method="POST" enctype="multipart/form-data" >

	<div class="row">
        <div class="col-md-3">
            <!-- upload xls -->
            <div class="form-group">
                <input type="button" class="btn btn-block" name="load" />Charger le document
            </div>
            <div id="groupImageRecap" class="form-group">
                <label>image recap</label>
                <input type="file" name="PDF" accept="*.xls,*.xlsx" />
                <p class="help-block">Document au format image (dimensions 1058*566px).</p>
            </div>
        </div>
    </div>
    <!-- validation du formulaire -->
    <input type="submit" value="Valider" class="btn btn-success">
</form>
