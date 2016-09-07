<div class="row options">

  <form method="post" action="<?= $rooter->dossier.'admin/page=options';?>" enctype="multipart/form-data">

    <div class="col-sm-12">
      <h2>Général</h2>
    </div>

    <!-- titre du site -->
    <div class="col-sm-3">
      <div class="reference" data-reference="titre-site">
        <i class="fa fa-info"></i>
      </div>
      Le titre de votre site
    </div>

    <div class="col-sm-9">
      <input type="text" name="titre" class="form-control" value="<?= $site->titre;?>"/>
    </div>

    <!-- description du site -->
    <div class="col-sm-3">
      <div class="reference" data-reference="description-site">
        <i class="fa fa-info"></i>
      </div>
      La description de votre site
    </div>

    <div class="col-sm-9">
      <input type="text" name="description" value="<?= $site->description;?>" class="form-control">
    </div>

    <!-- image du site -->
    <div class="col-sm-3">
      <div class="reference" data-reference="illustration-site">
        <i class="fa fa-info"></i>
      </div>
      L'illustration de votre site
    </div>

    <div class="col-sm-9">
      <input type="file" name="illustration" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif" />
      <?php if(!empty($site->illustration)):?>
      <img class="img-illustration" src="<?= $site->illustration;?>" width="250" alt="" />
      <?php endif;?>
    </div>

    <!-- langue du site -->
    <div class="col-sm-3">
      <div class="reference" data-reference="langue-site">
        <i class="fa fa-info"></i>
      </div>
      Cible internationale
    </div>

    <div class="col-sm-9">
      <select name="langue" class="form-control">
        <?php foreach($pays->list as $pays): ?>
        <option value="<?= $pays['id'];?>" <?php if($site->cible == $pays['id']): echo 'selected'; endif;?>>
          <?= $pays['nom'];?>
        </option>
        <?php endforeach;?>
      </select>
    </div>

    <div class="col-sm-12">
      <h2>Réseaux sociaux</h2>
    </div>

    <!-- facebook du site -->
    <div class="col-sm-3">
      <i class="fa fa-facebook"></i>Votre page facebook
    </div>

    <div class="col-sm-9">
      <input type="text" name="facebook" class="form-control" value="<?= $site->facebook;?>"/>
    </div>

    <!-- twitter du site -->
    <div class="col-sm-3">
      <i class="fa fa-twitter"></i>Votre compte twitter
    </div>

    <div class="col-sm-9">
      <input type="text" name="twitter" class="form-control" value="<?= $site->twitter;?>"/>
    </div>

    <div class="col-sm-3">
      <div class="reference" data-reference="maintenance-site">
        <i class="fa fa-info"></i>
      </div>
        Site en maintenance
    </div>
    <div class="col-sm-9">
      <select name="maintenance" class="form-control">
        <option value="0" <?php if($site->maintenance == 0):echo 'selected';endif;?>>Non</option>
        <option value="1" <?php if($site->maintenance == 1):echo 'selected';endif;?>>Oui</option>
      </select>
    </div>

    <div class="col-sm-3">
      <div class="reference" data-reference="messagerie-site">
        <i class="fa fa-info"></i>
      </div>
        Activer la messagerie
    </div>
    <div class="col-sm-9">
      <select name="messagerie" class="form-control">
        <option value="0" <?php if($site->messagerie == 0):echo 'selected';endif;?>>Non</option>
        <option value="1" <?php if($site->messagerie == 1):echo 'selected';endif;?>>Oui</option>
      </select>
    </div>

    <div class="col-sm-12">
      <input type="hidden" name="type" value="options" />
      <input type="hidden" name="secure" value="<?= $rooter->secure_key;?>" />
      <input type="submit" value="Envoyer" class="form-control"/>
    </div>
  </form>

</div>
