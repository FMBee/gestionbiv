
<!-- //NEW -->
<h2>Récapitulatif Prix de Cessions Agences</h2><br />

<form action="index.php?uc=recapCession&action=download" method="POST" enctype="multipart/form-data" >

	<div class="row">
        <div class="col-md-5">
            <!-- upload xls -->
            <div class="form-group">
                <a href="<?php echo $myfile ?>" >
                <input type="button" class="btn btn-block btn-info" value="Télécharger le document"	/>
                </a>
            </div>
            <span><?php echo "Mis en ligne le ".$datefile ?></span><br />
            <span><b><?php echo $result ?></b></span>
        </div>
    </div>
    
    <?php if ( $_SESSION['admin'] ): ?>
	  <div class="row">
        <div class="col-md-5">
            <br /><br />
            <div class="form-group">
                <label>Mettre à jour la version</label>
<!--                 <input type="file" name="XLS" accept="application/vnd.ms-excel, application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /> -->
                <input type="file" name="XLS" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                <p class="help-block">Document au format xlsx</p>
            </div>
        </div>
      </div>
      <!-- validation du formulaire -->
      <input type="submit" value="Valider" class="btn btn-success">
    <?php endif; ?>
    
</form>
