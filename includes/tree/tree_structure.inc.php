<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// CLASS NAME:  TREE                                                                                               //
// LANGUAGE   : PHP                                                                                                //
// AUTHOR     : Julien PACHET                                                                                      //
// EMAIL      : j|u|l|i|e|n| [@] |p|a|c|h|e|t|.|c|o|m                                                              //
// VERSION:     1.52                                                                                               //
// DATE:        06/08/2003                                                                                         //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// History:                                                                                                        //
//----------                                                                                                       //
//  Date        Version   Actions                                                                                  //
// --------------------------------------------------------------------------------------------------------------- //
//  06/08/2003  1.0       Final version                                                                            //
//  12/08/2003  1.1       Class now doesn't need the level of item                                                 //
//  28/08/2003  1.11      Can choose between text mode and graphic mode in the constructor                         //
//  11/12/2003  1.2       add get_path function to return the path to an item                                      //
//  12/12/2003  1.21      get_path function now return full text instead of id                                     //
//  26/12/2003  1.3       get_line_display($y) return the 4 part of what to display in line $y:                    //
//                          static tree, symbol before text, text and id                                           //
//  24/06/2004  1.31      view_tree now return the string to display, to be compatible with html cache display     //
//  18/02/2005  1.32      add optional parameter to get_path: return or not the root node                          //
//  08/04/2005  1.4       many checks to avoid class to crash                                                      //
//  08/04/2005  1.5       * tree can now order childs depending on another column containing order                 //
//                        * rename of get_list_childs to get_list_children ;-)                                     //
//                        * cache almost all data to prevent searching several times the same result               //
//  12/04/2005  1.51      * improve test in level_of and add the coding of root node                               //
//  03/08/2005  1.52      bug with new order child resolve                                                         //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Need to work: No other file / documents                                                                         //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// What the class need:                                                                                            //
// * a 2D assoc array, with at least the column: id, text, level of the text and the father of the text            //
// * the names of the column id, text, level, father                                                               //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// What the class do:                                                                                              //
// * Transform the 2D linear array into a 2D array ordered in the order of the tree, and other infos in each line: //
//   * id of the node                                                                                              //
//   * text of the node                                                                                            //
//   * the symbol of the node: a plus, a minus, or other                                                           //
//   * the number of childs of the node                                                                            //
//   * the list in an array of the childs                                                                          //
//   * the rest of the pictures of the tree, to place before the symbole                                           //
// * React to expand / collapse action to nodes                                                                    //
// * export a static view of the tree (without for example the link which can launch the collapse/expand action)   //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class tree {
	private $images_dir;
	private $linear_tab;
	public $tree_tab;
	private $symboles;
	private $id_column,$text_column,$father_column,$level_column;
	private $error="";
	private $id_stop=-1; // id_father value of root node
	private $width=-1;
	private $order_column="";
	private $children=array();
	private $fathers=array();
	private $line_in_tree=array();
	private $line_in_tab=array();
	//private $level_of=array();
	private $id_root=-1;

	// constructor
	public function __construct($tab,$a_id_column,$a_text_column,$a_father_column,$images_dir,$mode="graphic") {

		$this->images_dir=$images_dir;
		if ($mode=="graphic"){
			$this->symboles=array(	"vert"=>"<img src='$this->images_dir/arbo_vert.gif'     border=0 vspace=0 hspace=0 align=absbottom>",
			"plus"=>"<img src='$this->images_dir/arbo_plus.gif'     border=0 vspace=0 hspace=0 align=absbottom>",
			"moins"=>"<img src='$this->images_dir/arbo_moins.gif'   border=0 vspace=0 hspace=0 align=absbottom>",
			"vide"=>"<img src='$this->images_dir/arbo_vide.gif'     border=0 vspace=0 hspace=0 align=absbottom>",
			"angle"=>"<img src='$this->images_dir/arbo_angle.gif'   border=0 vspace=0 hspace=0 align=absbottom>",
			"milieu"=>"<img src='$this->images_dir/arbo_milieu.gif' border=0 vspace=0 hspace=0 align=absbottom>");
		}
		else{
			$this->symboles=array(	"vert"=>"&nbsp;|&nbsp;",
			"plus"=>"&nbsp;+&nbsp;",
			"moins"=>"&nbsp;-&nbsp;",
			"vide"=>"&nbsp;&nbsp;&nbsp;",
			"angle"=>"&nbsp;`-",
			"milieu"=>"&nbsp;|-");
		}
		$this->id_column=$a_id_column;
		$this->text_column=$a_text_column;
		$this->father_column=$a_father_column;
		$this->level_column="level";
		$cols=array_keys($tab[0]);
		if (!in_array($this->id_column,$cols)){
			$this->error="Class tree: column ".$this->id_column." not exist in parameter tab";
		}
		if (!in_array($this->text_column,$cols)){
			$this->error="Class tree: column ".$this->text_column." not exist in parameter tab";
		}
		if (!in_array($this->father_column,$cols)){
			$this->error="Class tree: column ".$this->father_column." not exist in parameter tab";
		}

		if ($this->error=="") {
			$this->linear_tab=$tab;
			for ($i=0;$i<count($tab);$i++) {
				$this->linear_tab[$i][$this->level_column]=$this->get_level_of($this->linear_tab[$i][$this->id_column]);
				if ($this->linear_tab[$i][$this->father_column]==$this->id_stop){
					$this->id_root=$this->linear_tab[$i][$this->id_column];
				}
			}
		}
	}

	// V1.5 added function: set the name of order column, to order childs of a node
	public function set_order_column($a_order_column) {
		$this->order_column=$a_order_column;
	}

	// Get the line number where to find the node $id in linear_tab
	public function get_line_of($id) {

		if ($this->error=="") {
			if (!isset($this->line_in_tab["$id"])) {
				$found=-1;
				for ($i=0;($i<count($this->linear_tab))&&($found==-1);$i++)
				if ($this->linear_tab[$i][$this->id_column]==$id)
				$found=$i;
				if ($found!=-1)
				$this->line_in_tab["$id"]=$found;
				else
				$this->error="Class tree: $node #$id not found in get_line_of";
			}
			return $this->line_in_tab["$id"];
		}
		$this->error="Class tree: node #$id not found in get_line_of";
		return -1;
	}

	// get the line number where to find the node $id in tree_tab
	public function get_line_in_tree($id) {
		if ($this->error=="") {
			if (!isset($this->line_in_tree["$id"])) {
				$found=-1;
				for ($i=0;($i<count($this->tree_tab))&&($found==-1);$i++){
					if ($this->tree_tab[$i]["id"]==$id) {
						$found=$i;
					}
				}
				if ($found!=-1){
					$this->line_in_tree["$id"]=$found;
				}
				else{
					$this->error="Class tree: node #$id not found in get_line_in_tree";
				}
			}
			return $this->line_in_tree["$id"];
		}
		return -1;
	}

	// list in a array of the $id of the child
	// V1.5: updated: make a sort in the childs depending if the order_column is set
	// list in a array of the $id of the child
	public function get_list_children($id) {
		//ebug($this->linear_tab);
		if ($this->error=="") {
			if (!isset($this->children["$id"])) {
				$temp=array();
				for ($i=0;$i<count($this->linear_tab);$i++) {
					if ($this->linear_tab[$i][$this->father_column]==$id) {
						if ($this->order_column!="")
						$temp[]=array('id'=>$this->linear_tab[$i][$this->id_column],'ordre'=>$this->linear_tab[$i][$this->order_column]);
						else
						$temp[]=array('id'=>$this->linear_tab[$i][$this->id_column],'ordre'=>0);
					}
				}
				//sort by order column if set
				if ($this->order_column!="")
				$temp=array_2D_sort($temp,$this->order_column);
				$res=array();
				foreach ($temp as $v)
				$res[]=$v['id'];
				$this->children["$id"]=$res;
			}
			return $this->children["$id"];
		}
		return array();
	}

	// number of childs of the $id_node
	public function nb_children($id_node) {
		return count($this->get_fathers($id_node));
	}

	// get the level of the item $id_node
	public function get_level_of($id_node) {
		if ($this->error=="") {
			$res=0;
			while (
			($this->linear_tab[$this->get_line_of($id_node)][$this->father_column]!=$this->id_stop)
			&&
			($this->linear_tab[$this->get_line_of($id_node)][$this->father_column]!=$this->linear_tab[$this->get_line_of($id_node)][$this->id_column])
			&&
			($res<=count($this->linear_tab))
			) {
				$res++;
				$id_node=$this->linear_tab[$this->get_line_of($id_node)][$this->father_column];
			}
			return $res;
		}
		return -1;
	}

	// list in array the father, grand-father, etc... of the $id_node
	public function get_fathers($id_node) {
		if ($this->error=="") {
			if (!isset($this->fathers["$id_node"])) {
				$niveau=$this->linear_tab[$this->get_line_of($id_node)][$this->level_column];
				for ($temp=array(),$i=$niveau;$i!=0;$i--) {
					$id_node=$this->linear_tab[$this->get_line_of($id_node)][$this->father_column];
					$temp[$i-1]=$id_node;
				}
				for ($res=array(),$i=0;$i<count($temp);$i++)
				$res[$i]=$temp[$i];
				$this->fathers["$id_node"]=$res;
			}
			return $this->fathers["$id_node"];
		}
		return -1;
	}

	// collapse the node $id
	public function collapse($id) {

		$lista_hijos=$this->get_list_children(0);

		for($i=0;$i<count($lista_hijos);$i++){
			if($id==0){
				echo '<br>'.'id_hijos'.$lista_hijos[$i].'<br>';
				$this->tree_tab[0]["symbol"]="plus";
				break;
			}else {
				if($lista_hijos[$i]==$id){
					echo '<br>'.'cerrar hijo: '.$lista_hijos[$i].'<br>';
					$this->tree_tab[$lista_hijos[$i]]["symbol"]="plus";
					break;
				}
			}
		}
	}

	// collapse the entire tree
	public function collapse_all() {
		//echo '<br>collapse_all<br>';
		for ($i=0;$i<count($this->tree_tab);$i++){
			if ($this->tree_tab[$i]["symbol"]=="moins"){
				$this->tree_tab[$i]["symbol"]="plus";
			}
		}
	}

	// expand the node $id
	public function expand($id) {

		$lista_hijos=$this->get_list_children(0);
		
		if($id==0){
			$this->tree_tab[0]["symbol"]="moins";
		}
		
		for($i=0;$i<count($lista_hijos);$i++){

			if($id==0){
				echo '<br>'.'id_hijos'.$lista_hijos[$i].'<br>';
				$this->tree_tab[$lista_hijos[$i]]["symbol"]="plus";
			}else{
				if($lista_hijos[$i]==$id){
					echo '<br>'.'abrir hijo: '.$lista_hijos[$i].'<br>';
					$this->tree_tab[$lista_hijos[$i]]["symbol"]="moins";
					break;
				}
			}
		}

	}

	// try to expand from the root to the node $id
	public function expand_to($id) {
		if ($this->error=="") {
			$this->collapse_all(); // on retrecie d'abord tout
			$ascendants=$this->get_fathers($id);
			$ascendants[]=$id;
			for ($i=0;$i<count($ascendants);$i++) {
				$nb_childs=$this->tree_tab[$this->get_line_in_tree($ascendants[$i])]["nb_childs"];
				if ($nb_childs>0){
					$this->expand($ascendants[$i]);
				}
				else{
					$i=count($ascendants);
				}
			}
		}
	}

	// expand the entire tree
	public function expand_all() {
		if ($this->error=="") {
			for ($i=0;$i<count($this->tree_tab);$i++)
			if ($this->tree_tab[$i]["symbol"]=="plus")
			$this->tree_tab[$i]["symbol"]="moins";
		}
	}

	// get the id of the root, i.e. where id_pere=-1
	public function get_idroot() {
		if ($this->error=="") {
			return $this->id_root;
		}
		return -1;
	}

	// width of the expanded tree
	public function width() {
		if ($this->error=="") {
			if ($this->width==-1) {
				for ($x=-1,$i=0;$i<count($this->tree_tab);$i=$this->get_next_line_tree($i))
				$x=max($x,$this->tree_tab[$i]["level"]);
				$this->width=$x;
			}
			else
			return $this->width;
		}
		return -1;
	}

	// total height of the expanded tree
	public function height() {
		return count($this->tree_tab);
	}

	// echo a static tree (you have do make you function to make collapse/expand action)
	public function view_tree() {
		if ($this->error=="") {
			$res="";
			$res.="<table border='0' cellspacing='0' cellpadding='0'>\n";
			for ($y=0;$y<$this->height();$y=$this->get_next_line_tree($y)) {
				$res.="\t<tr>\n";
				$res.="\t\t<td height=16><font size=1>";
				list($a,$b,$c,$d)=$this->get_line_display($y); // the $b part is the last part of the tree, the part which looks like + or - in windows looking tree
				$res.=$a.$b.$c; // for dynamic tree, just react to clic on $b part by putting a href link to expand or collapse tree
				$res.="</font></td>\n";
				$res.="\t</tr>\n";
			}
			$res.="</table>\n";
			return $res;
		}
		return "";
	}
	// return the 4 parts of a line to display: static part of tree, last part of tree (this one have to react to mouse click), text, and id of the node
	public function get_line_display($y) {
		if ($this->error=="") {
			$arbre=$this->tree_tab[$y]["tree"];
			for ($i=0,$res=array(),$res[0]="";$i<count($arbre);$i++)
			$res[0].=$this->symboles[$arbre[$i]];
			$res[1]=$this->symboles[$this->tree_tab[$y]["symbol"]];
			$res[2]=$this->tree_tab[$y]["text"];
			$res[3]=$this->tree_tab[$y]['id'];
			return $res;
		}
		return array("","","","");
	}
	// get the next line in the array tree_tab, depending of the collapse/expand node
	public function get_next_line_tree($l) {
		if ($this->error=="") {
			if ($this->tree_tab[$l]["symbol"]!="plus") {
				return $l+1;
			}
			else // the node have "plus" symbol => have to jump as such node as they are hidden
			for ($i=$l+1;$i<$this->height();$i++)
			if ($this->tree_tab[$i]["level"]<=$this->tree_tab[$l]["level"]) // when the level is equal or smaller
			return $i;
			return $this->height();
		}
		return -1;
	}

	// transform the linear array in a 1D array in the order of the tree, with the info
	public function transform($id_begin) {
		if ($this->error=="") {
			$id_begin*=1;
			if (is_string($id_begin)){
				$this->error="class tree: invalid parameter value of id_begin=$id_begin in transform";
			}else {
				$ligne=$this->get_line_of($id_begin);

				$tab_fils=$this->get_list_children($id_begin);
				$nb_fils=count($tab_fils);
				$niveau=$this->linear_tab[$ligne][$this->level_column];
				$id_pere=$this->linear_tab[$ligne][$this->father_column];
				$texte=$this->linear_tab[$ligne][$this->text_column];

				if ($nb_fils>0){
					$symbole="moins";
				}
				else {
					$temp=$this->get_list_children($id_pere); // liste des freres
					$symbole=($id_begin==$temp[count($temp)-1])?"angle":"milieu";
				}
				// reste of tree
				$ascendants=$this->get_fathers($id_begin);
				$arbre=array();
				for ($i=0;$i<count($ascendants);$i++) {
					$freres=$this->get_brothers($ascendants[$i]);
					$arbre[$i]=($ascendants[$i]==$freres[count($freres)-1])?"vide":"vert";
				}

				$this->tree_tab[]=array("id"=>$id_begin,
				"symbol"=>$symbole,
				"text"=>$texte,
				"nb_children"=>count($tab_fils),
				"level"=>$niveau,
				"id_father"=>$id_pere,
				"childs"=>$tab_fils,
				"tree"=>$arbre);
				for ($i=0;$i<count($tab_fils);$i++){
					$this->transform($tab_fils[$i]);
				}
			}
		}
	}

	// get the list of the brothers of $id (include $id)
	private function get_brothers($id) {
		if ($this->error=="") {
			$id_pere=$this->linear_tab[$this->get_line_of($id)][$this->father_column];
			return $this->get_list_children($id_pere);
		}
		return array();
	}
	// get a path text to an item like "root -> item1 -> item11 -> item111"
	public function get_path($id_item,$separator,$get_root=true) {
		if ($this->error=="") {
			$ids=$this->get_fathers($id_item);
			for ($i=($get_root)?0:1;$i<count($ids);$i++)
			$temp[]=$this->tree_tab[$this->get_line_in_tree($ids[$i])]["text"];
			$temp[]=$this->tree_tab[$this->get_line_in_tree($id_item)]["text"];
			return implode($separator,$temp);
		}
		return "";
	}

	public function get_error() {
		return $this->error;
	}
}

?>
