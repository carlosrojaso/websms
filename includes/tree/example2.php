<?
// name of the script
$self="example2.php";

// if id param is present, set it to $id or set -1 to $id if not
$target_id=(isset($HTTP_GET_VARS['target_id']))?$HTTP_GET_VARS['target_id']:-1;
//echo $target_id;

//************************************
//** Example 2 of the use of the class tree_structure.inc.php

include('tree_structure.inc.php');


$tab[]=array("id"=>0,"text"=>"c:","id_father"=>-1);
$tab[]=array("id"=>1,"text"=>"documents and settings","id_father"=>0);
$tab[]=array("id"=>2,"text"=>"toto","id_father"=>1);
//$tab[]=array("id"=>3,"text"=>"desktop","id_father"=>2);
//$tab[]=array("id"=>4,"text"=>"recent","id_father"=>2);
$tab[]=array("id"=>5,"text"=>"windows","id_father"=>0);
$tab[]=array("id"=>6,"text"=>"font","id_father"=>5);
$tab[]=array("id"=>7,"text"=>"inf","id_father"=>5);
//$tab[]=array("id"=>8,"text"=>"system32","id_father"=>5);
//$tab[]=array("id"=>9,"text"=>"spool","id_father"=>8);
//$tab[]=array("id"=>10,"text"=>"temp","id_father"=>9);

// tree in text mode
$tree=new tree($tab,"id","text","id_father","img","graphic");

// transform the linear tab to the tab ordered in tree order
$tree->transform($tree->get_idroot());

$tree->expand_all();
/*
if ($target_id!=-1){ // expand tree to $expand_id node id if $expand_id is "set"
	if($tree->get_level_of($target_id)==0){
		$tree->collapse_all();
	}
	
	if($_GET[node]=='expand'){	//abrir
		
		$tree->expand($target_id);
	}elseif($_GET[node]=='collapse'){ //cerrar
		
		$tree->collapse($target_id);
	}
}

if ($target_id==-1){
	$tree->collapse_all();
}
*/

echo $tree->get_error();

// dynamic view. React to mouse click!

echo "<table border='0' cellspacing='0' cellpadding='0'>\n";
for ($y=0;$y<$tree->height();$y=$tree->get_next_line_tree($y)) {
	echo "  <tr>\n";
	echo "    <td height=16><font size=2>\n      ";
	// the $a part is the static part of tree
	// the $b part is the last part of the tree, the part which looks like + or - in windows looking tree
	// the $c part is the text of the node
	// the $d part is the id of the node
	list($a,$b,$c,$d)=$tree->get_line_display($y);
	echo $a;
	if ($tree->tree_tab[$y]["symbol"]=="plus") // if node is "+" => expand it
	echo "<a href=$self?target_id=$d&node=expand>$b</a>";
	else
	if ($tree->tree_tab[$y]["symbol"]=="moins") // if node is "-" => expand to father
	//echo "<a href=$self?target_id=".$tree->tree_tab[$y]["id_father"],"&node=collapse>$b</a>";
	echo "<a href=$self?target_id=$d&node=collapse>$b</a>";
	else // else the node have static tree
	echo $b;
	echo $c;
	if($tree->get_idroot()!=$y){
		echo '<input type="checkbox" value="" >';
	}
	echo "\n    </font></td>\n";
	echo "  </tr>\n";
}

echo "</table>\n";

?>