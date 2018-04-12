<?php
if(!isset($_REQUEST['numbiv']) || !isset($_REQUEST['annee'])){
  header ('Location: index.php');
  exit;
} else {
  $unBiv = $pdo->getUnBiv($_REQUEST['numbiv'], $_REQUEST['annee']);
  $unFournisseur = $pdo->getUnFournisseurs($unBiv['fournisseur']);
  include 'vues/v_recapBiv.php';
}
