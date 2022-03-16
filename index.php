<?php 
// require files
require_once 'model/gebruiker.class.php';
require_once 'controller/init.php';
//Connect initilization class.
$init = new Init();
$gebruiker = new Gebruiker();

$action_url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$default_url = "http://localhost/scaldaOOPPHP/index.php";

$get_array = $gebruiker->getGetValues();

$action = FALSE;
if (!empty($get_array)) {
    if (isset($get_array['action'])) {
        $action = $gebruiker->handleGetAction($get_array);
    }
}

$post_array = $gebruiker->getPostValues();



if (!empty($post_array['verzenden'])) {
    $error = FALSE;
    $add = FALSE;
    $result = $gebruiker->save($post_array);
    if ($result) {
        $add = TRUE;
    } else {
        $error = TRUE;
    }
}

if (!empty($_GET['action'])){
if ($_GET['action'] == 'delete') {
    $delete = FALSE;
    $Edelete = FALSE;
    $result = $gebruiker->delete(!empty($_POST['id']));
    if ($result) {
        $delete = TRUE;
    } else {
        $Edelete = TRUE;
    }
}
}

if (!empty($_GET['action'])){
    if ($_GET['action'] == 'update') {
        $update = FALSE;
    $result = $gebruiker->update($post_array);
    if($result){
        $update = TRUE;
    }else{
        $update = FALSE;
    }
}
}
$gebruiker_lijst = $gebruiker->getGebruikersList();
?>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>
<style>
    .row{
    margin-top:20px;
    }
</style>
</head>
<body>
    <div class="container">
        <?php  if (isset($add)) {
        echo($add ? '<div class="alert alert-success text-center">
                    '.$post_array['voornaam'].' '.$post_array['achternaam'].' is aangemaakt.</div>'.
                    '<script>
                    setTimeout(function() {
                        window.location.href = "'.$default_url.'";
                     }, 5000);
                    </script>'
            :
            '<div class="alert text-center alert-warning">
                 '.$post_array['voornaam'].' '.$post_array['achternaam'].' bestaat al.
            </div>'. 
            '<script>
            setTimeout(function() {
                window.location.href = "'.$default_url.'";
             }, 5000);
            </script>');
    } 
    if (isset($update)) {
        echo($update ? '<div class="alert alert-success text-center">
                    '.$post_array['voornaam'].' '.$post_array['achternaam'].' is bijgewerkt.</div>'.
                    '<script>
                    setTimeout(function() {
                        window.location.href = "'.$default_url.'";
                     }, 5000);
                    </script>'
            :
            '<div class="alert text-center alert-warning">
                 '.$post_array['voornaam'].' '.$post_array['achternaam'].' kan niet worden bijgewerkt.
            </div>'. 
            '<script>
            setTimeout(function() {
                window.location.href = "'.$default_url.'";
             }, 5000);
            </script>');
    } 

    if (isset($delete)) { echo($delete ? '<div class="alert alert-success text-center">
        Verwijderd.</div>'.
            '<script>
            setTimeout(function() {
                window.location.href = "'.$default_url.'";
            }, 5000);
            </script>'
            :
            '<div class="alert alert-success text-center">
            Verwijderd.</div>'. 
            '<script>
            setTimeout(function() {
                window.location.href = "'.$default_url.'";
            }, 5000);
            </script>' );

    }
    ?>
<div class="row">
    <h2>Gebruiker Crud</h2>
    <?php if($action !== 'update'){ ?>
<div class="col-6">
    <form method="post" action="<?=$action_url;?>">
        <div class="row">
            <div class="col-6">
                <label>Voornaam</label>
                <input type="text" class="form-control" name="voornaam" placeholder="Voornaam" value="">
            </div>
            <div class="col-6">
                <label>Achternaam</label>
                <input type="text" class="form-control" name="achternaam" placeholder="Achternaam" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label>Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email" value="">
            </div>
            <div class="col-6">
                <label>Telefoonnummer</label>
                <input type="text" class="form-control" name="telefoonnummer" placeholder="Telefoonnummer" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>Adres</label>
                <input type="text" class="form-control" name="adres" placeholder="Adres" value="">
            </div>
            <div class="col-4">
                <label>Postcode</label>
                <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="">
            </div>
            <div class="col-4">
                <label>Woonplaats</label>
                <input type="text" class="form-control" name="woonplaats" placeholder="Woonplaats" value="">
            </div>
        </div>
     <div class="row">
         <div class="col-6">
             <input type="submit" name="verzenden" class="btn btn-primary">
         </div>
     </div>
    </form>
</div>
<?php } // if action is not update, show form ?>
<?php
    foreach($gebruiker_lijst as $lijst_obj){
        if($action == 'update' && $lijst_obj->getId() == $get_array['id']){ 
    ?>
    <div class="col-6">
    <form method="post" action="<?=$action_url;?>">
        <div class="row">
            <div class="col-6">
                <label>Voornaam</label>
                <input type="hidden" class="form-control" name="id" value="<?= $lijst_obj->getId()?>">
                <input type="text" class="form-control" name="voornaam" placeholder="Voornaam" value="<?=$lijst_obj->getVoornaam();?>">
            </div>
            <div class="col-6">
                <label>Achternaam</label>
                <input type="text" class="form-control" name="achternaam" placeholder="Achternaam" value="<?=$lijst_obj->getAchternaam();?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label>Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email" value="<?=$lijst_obj->getEmail();?>">
            </div>
            <div class="col-6">
                <label>Telefoonnummer</label>
                <input type="text" class="form-control" name="telefoonnummer" placeholder="Telefoonnummer" value="<?=$lijst_obj->getTelefoonnummer();?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>Adres</label>
                <input type="text" class="form-control" name="adres" placeholder="Adres" value="<?=$lijst_obj->getAdres();?>">
            </div>
            <div class="col-4">
                <label>Postcode</label>
                <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="<?=$lijst_obj->getPostcode();?>">
            </div>
            <div class="col-4">
                <label>Woonplaats</label>
                <input type="text" class="form-control" name="woonplaats" placeholder="Woonplaats" value="<?=$lijst_obj->getWoonplaats();?>">
            </div>
        </div>
     <div class="row">
         <div class="col-6">
             <input type="submit" name="update" class="btn btn-primary" value="Update">
         </div>
     </div>
    </form>
</div>
<?php }} ?>
<div class="col-6">
    <?php if($gebruiker->getGebruikersAantal() < 1){}else{ //start gebruikers aantal check ?>
        <form method="post" action="<?=$action_url;?>">
    <table class="table">
        <tr>
            <th>Naam</th>
            <th>Email</th>
            <th>Telefoonnummer</th>
            <th>Vestiging</th>
            <th colspan="2">Acties</th>
        </tr>
        <?php 
        foreach($gebruiker_lijst as $lijst_obj){ //start de foreach 
        // Add params to base url update link
        $upd_link =  $action_url . '?action=update&id='. $lijst_obj->getId();
        // Add params to base url delete link
        $del_link =  $action_url . '?action=delete&id='. $lijst_obj->getId();
        ?>
        <tr>
            <td><?= $lijst_obj->getVoornaam() .' '.$lijst_obj->getAchternaam();?></td>
            <td><?= $lijst_obj->getEmail();?></td>
            <td><?= $lijst_obj->getTelefoonnummer();?></td>
            <td><?= $lijst_obj->getAdres().' '.$lijst_obj->getPostcode().' '.$lijst_obj->getWoonplaats();?></td>
           <td><a  class="btn btn-success" name="update" href="<?= $upd_link; ?>">Update</a></td>
           <td><a class="btn btn-danger" name="delete" href="<?= $del_link; ?>">Delete</a></td>
        </tr>
        <?php } //einde van de foreach ?>
    </table>
        </form>
    <?php }//sluit gebruikers aantal check ?>
</div>
</div>
</div>
</body>
</html>