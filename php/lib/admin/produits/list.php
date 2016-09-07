<table class="table table-responsive table-hover">
  <tr>
    <th>Illustration</th>
    <th>Nom</th>
    <th>Prix</th>
    <th>Quantite</th>
    <th>Catégorie</th>
    <th>Sous catégorie</th>
  </tr>
<?php
foreach($produits->list as $produit):

if
(
!isset($_GET['categorie'])
OR (isset($_GET['categorie']) && !isset($_GET['sous_categorie']) && $produit['categorie'] == $_GET['categorie'])
OR (isset($_GET['categorie']) && isset($_GET['sous_categorie']) && $produit['categorie'] == $_GET['categorie'] && $_GET['sous_categorie'] == $produit['sous_categorie'])
)
{
?>

<!-- nom -->
<tr class="echo" data-id="<?= $produit['id'];?>">
  <td align="left">
    <img src="<?= $produit['illustration'];?>" width="100" alt=""/>
  </td>
  <td align="left">
    <?= $produit['nom'];?>
  </td>
  <td align="left">
    <?= $produit['prix'];?> €
  </td>
  <td align="left">
    <?= $produit['quantite'];?>
  </td>
  <td align="left">
    <?= $produit['nom_categorie'];?>
  </td>
  <td align="left">
    <?= $produit['nom_sous_categorie'];?>
  </td>
  <td align="right">
    <i class="fa fa-pencil action_update" data-id="<?= $produit['id'];?>" />
  </td>
</tr>


<!-- formulaire de modification -->
<form method="post" action="/admin/page=produits" enctype="multipart/form-data">

  <!-- nom du produit -->
  <tr class="form_action_update hidden" data-id="<?= $produit['id'];?>">
    <td align="left">
      <img src="<?= $produit['illustration'];?>" width="100" alt=""/>
    </td>
    <td align="left" colspan="1">
      <div class="reference" data-reference="nom-produit">
        Nom du produit
      </div>
    </td>
    <td align="left" colspan="3">
      <input type="text" class="form-control" name="nom" value="<?= $produit['nom'];?>"/>
    </td>
    <td align="right">
      <i class="fa fa-pencil action_update" data-id="<?= $produit['id'];?>" />
    </td>
  </tr>


  <!-- prix du produit -->
  <tr class="form_action_update hidden" data-id="<?= $produit['id'];?>">
    <td></td>
    <td align="left">
      <div class="reference" data-reference="prix-produit">
        Prix du produit
      </div>
    </td>
    <td align="left">
      <input type="number" class="form-control" name="prix" value="<?= $produit['prix'];?>"/>
    </td>

    <!-- quantité disponible -->
    <td align="left">
      <div class="reference" data-reference="quantite-produit">
        Quantité disponible
      </div>
    </td>
    <td align="left">
      <input type="number" class="form-control" name="quantite" value="<?= $produit['quantite'];?>"/>
    </td>
    <td></td>
  </tr>

  <tr class="form_action_update hidden" data-id="<?= $produit['id'];?>">
    <td></td>
    <!-- categorie et sous catégorie -->
    <td align="left">
      <div class="reference" data-reference="categorie-produit">
        Catégorie
      </div>
    </td>
    <td align="left">
      <select name="categorie" class="form-control">
        <?php foreach($categories->list as $categorie): ?>
        <option value="<?= $categorie['id'];?>" <?php if($categorie['id'] == $produit['categorie']):?>selected<?php endif;?>>
          <?= $categorie['nom'];?>
        </option>
        <?php endforeach;?>
      </select>
    </td>

    <td align="left">
      <div class="reference" data-reference="categorie-produit">
        Sous catégorie
      </div>
    </td>
    <td align="left">
      <select name="sous_categorie" class="form-control">
        <?php foreach($sous_categories->list as $sous_categorie): ?>
        <option value="<?= $sous_categorie['id'];?>" <?php if($sous_categorie['id'] == $produit['sous_categorie']):?>selected<?php endif;?>>
          <?= $sous_categorie['nom'];?>
        </option>
        <?php endforeach;?>
      </select>
    </td>
    <td></td>
  </tr>

  <tr class="form_action_update hidden" data-id="<?= $produit['id'];?>">
    <td></td>
    <!-- illustration produit -->
    <td align="left" colspan="1">
      <div class="reference" data-reference="illustration-produit">
        Image d'illustration
      </div>
    </td>
    <td align="left" colspan="3">
      <input type="file" class="form-control" name="illustration" accept=".jpg,.jpeg,.bmp,.png,.gif"/>
    </td>
    <td></td>
  </tr>

  <tr class="form_action_update hidden" data-id="<?= $produit['id'];?>">
    <td align="center" colspan="6">
      <input type="hidden" name="type" value="update-produit" />
      <input type="hidden" name="id" value="<?= $produit['id'];?>" />
      <input type="hidden" name="secure" value="<?= $rooter->secure_key;?>" />
      <input type="submit" value="Modifier" class="form-control"/>
    </td>
  </tr>
</form>
<?php
}
endforeach;?>
</table>
