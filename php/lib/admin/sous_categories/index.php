<!-- insertion sous categories -->
<div class="row categories">
  <div class="col-sm-12 add">
    <i class="fa fa-plus"></i>
  </div>

  <form method="post" class="form-add" action="/admin/page=sous_categories" enctype="multipart/form-data">
    <div class="col-sm-3">
      <div class="reference" data-reference="nom-categorie">
        <i class="fa fa-info"></i> Nom de la sous catégorie
      </div>
    </div>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="nom" />
    </div>
    <div class="col-sm-12">
      <input type="hidden" name="type" value="add-sous-categorie" />
      <input type="hidden" name="secure" value="<?= $rooter->secure_key;?>" />
      <input type="submit" value="Envoyer" class="form-control"/>
    </div>
  </form>
</div>

<!-- liste categories -->
<div class="row categories">
  <table class="table table-responsive table-hover">
    <?php
    foreach($sous_categories->list as $sous_categorie):
    if($sous_categorie['modifiable'] == 1):
    ?>
    <tr>
      <td align="left">

        <!-- affichage classique -->
        <p class="echo" data-id="<?= $sous_categorie['id'];?>">
          <?= $sous_categorie['nom'];?>
        </p>

        <!-- affichage modification -->
        <form method="post" class="hidden form_action_update" data-id="<?= $sous_categorie['id'];?>" action="/admin/page=categories" enctype="multipart/form-data">
          <input type="hidden" name="type" value="update-sous-categorie" />
          <input type="hidden" name="secure" value="<?= $rooter->secure_key;?>" />
          <input type="hidden" name="id" value="<?= $sous_categorie['id'];?>" />
          <input type="text" name="nom" class="form-control enter-submit" data-form="form_action_update" data-id="<?= $sous_categorie['id'];?>" value="<?= $sous_categorie['nom'];?>" />
        </form>

      </td>
      <td align="right">

        <!-- stylo modification-->
        <i class="fa fa-pencil action_update" data-id="<?= $sous_categorie['id'];?>"></i>

        <!-- croix suppression -->
        <form method="post" class="form_action_delete" data-id="<?= $sous_categorie['id'];?>" action="/admin/page=categories" enctype="multipart/form-data">
          <input type="hidden" name="type" value="delete-sous-categorie" />
          <input type="hidden" name="secure" value="<?= $rooter->secure_key;?>" />
          <input type="hidden" name="id" value="<?= $sous_categorie['id'];?>" />
          <i class="fa fa-remove action_delete" data-id="<?= $sous_categorie['id'];?>"></i>
        </form>

      </td>

    </tr>
    <?php
    endif;
    endforeach;?>
  </table>
</div>
