<?
/*
************************************
** Example of the use of the class tree_structure.inc.php*/

// rename class file from "class.inc.php" to "tree_structure.inc.php"
// for this to work !
include('tree_structure.inc.php'); 

$tab[]=array("id"=>0,"text"=>"c:","id_father"=>-1);
$tab[]=array("id"=>1,"text"=>"documents and settings","id_father"=>0);
$tab[]=array("id"=>2,"text"=>"toto","id_father"=>1);
$tab[]=array("id"=>3,"text"=>"desktop","id_father"=>2);
$tab[]=array("id"=>4,"text"=>"recent","id_father"=>2);
$tab[]=array("id"=>5,"text"=>"windows","id_father"=>0);
$tab[]=array("id"=>6,"text"=>"font","id_father"=>5);
$tab[]=array("id"=>7,"text"=>"inf","id_father"=>5);
$tab[]=array("id"=>8,"text"=>"system32","id_father"=>5);
$tab[]=array("id"=>9,"text"=>"spool","id_father"=>8);
$tab[]=array("id"=>10,"text"=>"temp","id_father"=>9);

$tree=new tree_structure($tab,"id","text","id_father","/rep_pictures");

// transform the linear tab to the tab ordered in tree order
$tree->transform($tree->get_idroot());

// default view. This view is static and don't react of mouse click
$tree->view();

?>