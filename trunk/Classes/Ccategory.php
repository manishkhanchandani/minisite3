<?php
class Ccategory {

	private $cacheSecs = CACHETIME;
	private static $instance;
	public $qs='';
	
	public function __construct($dbFrameWork, $Common) {
		if(self::$instance) {
			return self::$instance;
		} else {
			self::$instance = $this;
			$this->dbFrameWork = $dbFrameWork;
			$this->Common = $Common;
		}
	}
	
	public $catLink=array();
	public $catLinkChild=array();
	
	public function categoryParentLink($catId) {
		if(!$this->catLink) $this->catLink = array();
		$sql = "select * from ccategory where category_id = '".$catId."' and site_id = '".ID."' and module_id = '".MID."'";
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		if($rs->RecordCount()>0) {
			$rec = $rs->FetchRow();
			$catId = $rec['category_id'];
			$pid = $rec['parent_id'];
			$category = '<a href="'.HTTPPATH.'/index.php?ID='.ID.'&MID='.MID.'&pg='.pg.'&catId='.$catId.$this->qs.'">'.$rec['category'].'</a>';
			array_unshift($this->catLink,$category);
			$this->categoryParentLink($pid);	
		} else {
			$this->catLinkDisplay = '<a href="'.HTTPPATH.'/index.php?ID='.ID.'&MID='.MID.'&pg='.pg.'&catId='.$catId.$this->qs.'">Home</a>';
			if($this->catLink) {
				foreach($this->catLink as $value) {
					$this->catLinkDisplay .= ' >> '.$value;
				}
				$this->catLinkDisplay = substr($this->catLinkDisplay,0);
			}
		}
	}
	
	public $tree;					// Clear the directory tree
	public $depth;					// Child level depth.
	public $top_level_on;			// What top-level category are we on?
	public $exclude = array();			// Define the exclusion array
	
	public function tree($CatId) {
		$this->tree = "";					
		$this->depth = 1;					
		$this->top_level_on = 1;			
		$this->exclude = array(0);	
		$this->tempTree = '';		
		$sql = "select * from ccategory where site_id = '".ID."' and module_id = '".MID."' and parent_id = '".$CatId."'";
		$nav_query = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while($nav_row = $nav_query->FetchRow()) {
			$goOn = 1;			// Resets variable to allow us to continue building out the tree.
			for($x = 0; $x < count($this->exclude); $x++)		// Check to see if the new item has been used
			{
				if ( $this->exclude[$x] == $nav_row['category_id'] )
				{
					$goOn = 0;
					break;	// Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
				}
			}
			if ( $goOn == 1 )
			{
				$this->tree .= "<li class=\"lilinks\"><a href=\"".HTTPPATH."/index.php?ID=".ID."&MID=".MID."&pg=".pg."&catId=".$nav_row['category_id'].$this->qs."\" class=\"alinks\">".$nav_row['category'] . "</a></li>";				// Process the main tree node
				array_push($this->exclude, $nav_row['category_id']);		// Add to the exclusion list
				$this->tree .= $this->build_child($nav_row['category_id']);		// Start the recursive function of building the child tree
			}
		}
	}
	public function build_child($oldID)			// Recursive function to get all of the children...unlimited depth
	{			
		$sql = "SELECT * FROM `ccategory` WHERE parent_id='" . $oldID . "'";		
		$child_query = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}		
		while ($child = $child_query->FetchRow())
		{
			if ( $child['category_id'] != $child['parent_id'] )
			{
				$tempTree .= "<li class=\"lilinks\"><a href=\"".HTTPPATH."/index.php?ID=".ID."&MID=".MID."&pg=".pg."&catId=".$child['category_id'].$this->qs."\" class=\"alinks\">";
				for ( $c=0;$c<$this->depth;$c++ )			// Indent over so that there is distinction between levels
				{ 
					$tempTree .= "&nbsp;&nbsp;&nbsp;&nbsp;"; 
				}
				$tempTree .= "- " . $child['category'] . "</a></li>";
				$this->depth++;		// Incriment depth b/c we're building this child's child tree  (complicated yet???)
				$tempTree .= $this->build_child($child['category_id']);		// Add to the temporary local tree
				$this->depth--;		// Decrement depth b/c we're done building the child's child tree.
				array_push($this->exclude, $child['category_id']);			// Add the item to the exclusion list
			}
		}
	 
		return $tempTree;
	}	
	
	public $treeSelectBox;					// Clear the directory tree
	public $depthSelectBox;					// Child level depth.
	public $excludeSelectBox = array();			// Define the exclusion array
	public $selectedSelectBox = array();			// Define the exclusion array
	
	public function treeSelectBox($CatId) {
		$this->treeSelectBox = "";					
		$this->depthSelectBox = 1;		
		$this->excludeSelectBox = array(0);	
		
		$sql = "select * from ccategory where site_id = '".ID."' and module_id = '".MID."' and parent_id = '".$CatId."'";			
		$nav_query = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}		
		while ($nav_row = $nav_query->FetchRow()) {
			$goOn = 1;			// Resets variable to allow us to continue building out the tree.
			for($x = 0; $x < count($this->excludeSelectBox); $x++)		// Check to see if the new item has been used
			{
				if ( $this->excludeSelectBox[$x] == $nav_row['category_id'] )
				{
					$goOn = 0;
					break;	// Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
				}
			}
			if ( $goOn == 1 )
			{
				$this->treeSelectBox .= "<option value='".$nav_row['category_id']."'";
				if(in_array($nav_row['category_id'], $this->selectedSelectBox)) {
					$this->treeSelectBox .= " selected";
				}
				$this->treeSelectBox .= ">".stripslashes($nav_row['category']) . "</option>";				// Process the main tree node
				array_push($this->excludeSelectBox, $nav_row['category_id']);		// Add to the exclusion list
				$this->treeSelectBox .= $this->build_childSelectBox($nav_row['category_id']);		// Start the recursive function of building the child tree
			}
		}
	}
	public function build_childSelectBox($oldID)			// Recursive function to get all of the children...unlimited depth
	{			
		$sql = "SELECT * FROM `ccategory` WHERE site_id = '".ID."' and module_id = '".MID."' and parent_id='" . $oldID . "'";
		$child_query = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}		
		while ($child = $child_query->FetchRow())
		{
			if ( $child['category_id'] != $child['parent_id'] )
			{
				$tempTree .= "<option value='".$child['category_id']."'";
				if(in_array($child['category_id'], $this->selectedSelectBox)) {
					$tempTree .= " selected";
				}
				$tempTree .= ">";
				for ( $c=0;$c<$this->depthSelectBox;$c++ )			// Indent over so that there is distinction between levels
				{ 
					$tempTree .= "&nbsp;&nbsp;&nbsp;&nbsp;"; 
				}
				$tempTree .= "- " . stripslashes($child['category']) . "</option>";
				$this->depthSelectBox++;		// Incriment depth b/c we're building this child's child tree  (complicated yet???)
				$tempTree .= $this->build_childSelectBox($child['category_id']);		// Add to the temporary local tree
				$this->depthSelectBox--;		// Decrement depth b/c we're done building the child's child tree.
				array_push($this->excludeSelectBox, $child['category_id']);			// Add the item to the exclusion list
			}
		}
	 
		return $tempTree;
	}
}
?>