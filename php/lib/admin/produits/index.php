<!-- insertion produit -->
<div class="categories">
  <div class="col-sm-12 add">
    <i class="fa fa-plus"></i>
  </div>

  <form method="post" class="form-add" action="/admin/page=produits" enctype="multipart/form-data">

    <!-- nom du produit -->
    <div class="row">
      <div class="col-sm-2">
        <div class="reference" data-reference="nom-produit">
          <i class="fa fa-info"></i> Nom du produit
        </div>
      </div>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="nom" />
      </div>
    </div>


    <!-- prix du produit -->
    <div class="row">
      <div class="col-sm-2">
        <div class="reference" data-reference="prix-produit">
          Prix du produit
        </div>
      </div>
      <div class="col-sm-4">
        <input type="number" class="form-control" name="prix" />
      </div>

      <!-- quantité sisponible -->
      <div class="col-sm-2">
        <div class="reference" data-reference="quantite-produit">
          Quantité disponible
        </div>
      </div>
      <div class="col-sm-4">
        <input type="number" class="form-control" name="quantite" />
      </div>
    </div>

    <div class="row">

      <!-- categorie et sous catégorie -->
      <div class="col-sm-2">
        <div class="reference" data-reference="categorie-produit">
          Catégorie
        </div>
      </div>
      <div class="col-sm-4">
        <select name="categorie" class="form-control">
          <?php foreach($categories->list as $categorie):?>
          <option value="<?= $categorie['id'];?>"><?= $categorie['nom'];?></option>
          <?php endforeach;?>
        </select>
      </div>

      <div class="col-sm-2">
        <div class="reference" data-reference="categorie-produit">
          Sous catégorie
        </div>
      </div>
      <div class="col-sm-4">
        <select name="sous_categorie" class="form-control">
          <?php foreach($sous_categories->list as $sous_categorie): ?>
          <option value="<?= $sous_categorie['id'];?>"><?= $sous_categorie['nom'];?></option>
          <?php endforeach;?>
        </select>
      </div>
    </div>

    <div class="row">

      <!-- illustration produit -->
      <div class="col-sm-2">
        <div class="reference" data-reference="illustration-produit">
          Image d'illustration
        </div>
      </div>
      <div class="col-sm-10">
        <input type="file" class="form-control" name="illustration" accept=".jpg,.jpeg,.bmp,.png,.gif"/>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <input type="hidden" name="type" value="add-produit" />
        <input type="hidden" name="secure" value="<?= $rooter->secure_key;?>" />
        <input type="submit" value="Envoyer" class="form-control"/>
      </div>
    </div>
  </form>

  <?php include $rooter->dossier_root.'php/lib/admin/produits/list.php';?>
</div>
