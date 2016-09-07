<?php
if(!isset($_GET['page']) OR (isset($_GET['page']) && empty($_GET['page'])))
{
  $page = 'accueil';
}
else
{
  $page = $_GET['page'];
}
?>
<nav>
  <ul>
    <li <?php if($page=='accueil'):?> class="active" <?php endif;?>>
      <a href="<?php echo $rooter->dossier;?>admin/page=accueil">
        Accueil
      </a>
    </li>
    <li <?php if($page=='categories'):?> class="active" <?php endif;?>>
      <a href="<?php echo $rooter->dossier;?>admin/page=categories">
        Catégories
      </a>
    </li>
    <li <?php if($page=='sous_categories'):?> class="active" <?php endif;?>>
      <a href="<?php echo $rooter->dossier;?>admin/page=sous_categories">
        Sous catégories
      </a>
    </li>
    <li <?php if($page=='produits'):?> class="active" <?php endif;?>>
      <a href="<?php echo $rooter->dossier;?>admin/page=produits">
        Produits
      </a>
      <?php if(!empty($produits->categories)): ?>
      <ul>
        <?php foreach($produits->categories as $categorie):?>
        <li>
          <a href="<?php echo $rooter->dossier;?>admin/page=produits/categorie=<?= $categorie['id'];?>">
            <?= $categorie['nom'];?>
          </a>
          <?php if(!empty($categorie['sous_categories'])): ?>
          <ul>
            <?php foreach($categorie['sous_categories'] as $sous_categorie):?>
            <li>
              <a href="<?php echo $rooter->dossier;?>admin/page=produits/categorie=<?= $categorie['id'];?>/sous_categorie=<?= $sous_categorie['id'];?>">
                <?= $sous_categorie['nom'];?>
              </a>
            </li>
            <?php endforeach;?>
          </ul>
          <?php endif;?>
        </li>
        <?php endforeach;?>
      </ul>
      <?php endif;?>
    </li>
    <li <?php if($page=='commandes'):?> class="active" <?php endif;?>>
      <a href="<?php echo $rooter->dossier;?>admin/page=commandes">
        Commandes
      </a>
    </li>
    <li <?php if($page=='options'):?> class="active" <?php endif;?>>
      <a href="<?php echo $rooter->dossier;?>admin/page=options">
        Options
      </a>
    </li>
    <li>
      <a href="<?php echo $rooter->dossier;?>admin/page=deconnexion">
        Déconnexion
      </a>
    </li>
  </ul>
</nav>

<section>
  <?php include $rooter->dossier_root.'php/lib/admin/'.$page.'/index.php';?>
</section>

<?php if($site->messagerie == 1): ?>

<script type="text/javascript">
id = "<?= $_SESSION['admin'];?>";
key = "<?= $_SESSION['secure_key'];?>";
</script>

<?php endif;?>
