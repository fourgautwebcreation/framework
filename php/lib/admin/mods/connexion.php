<form id="form_connexion" method="post" action="<?php echo $rooter->dossier;?>admin" enctype="multipart/form-data">
  <table id="table_connexion">
    <tr>
      <th align="center" colspan="2">
        Connexion administrateurs
      </th>
    </tr>
    <tr>
      <td align="left">
        Votre pseudo
      </td>
      <td align="left">
        <div class="relative">
          <input type="text" name="pseudo" />

          <div class="champs_vide" data-name="pseudo">
            <div class="arrow"></div>
            <span>Ce champs est vide</span>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td align="left">
        Votre mot de passe
      </td>
      <td align="left">
        <div class="relative">
          <input type="password" name="pass" />

          <div class="champs_vide" data-name="pass">
            <div class="arrow"></div>
            <span>Ce champs est vide</span>
          </div>

        </div>
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2">
        <input type="hidden" value="1" name="connexion_extranet"/>
        <input type="button" value="Connexion" />
      </td>
    </tr>
  </table>
</form>
