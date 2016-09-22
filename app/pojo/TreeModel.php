<?php
/**
 * 左右值分类算法  移动，添加，删除
 * @author wolf
 *
 */
class TreeModel extends Db {
	
	var $tablefix = "w_news_";
	
	/** 
	 * Short description. 
	 * 增加新的分类 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function addsort($CatagoryID, $SortName, $module = 1) {
		if ($CatagoryID == 0) {
			$Lft = 0;
			$Rgt = 1;
		} else {
			
			$Result = $this->checkCatagory ( $CatagoryID );
			
			if ($Result != false) {
				//取得父类的左值,右值 
				$Lft = $Result ['Lft'];
				$Rgt = $Result ['Rgt'];
				$this->exec ( "UPDATE `" . $this->tablefix . "category` SET `Lft`=`Lft`+2 WHERE `Lft`>$Rgt" );
				$this->exec ( "UPDATE `" . $this->tablefix . "category` SET `Rgt`=`Rgt`+2 WHERE `Rgt`>=$Rgt" );
			} else {
				echo $SortName . "<br>";
			
			}
		}
		//插入 
		if ($Result != FALSE) {
			if ($this->exec ( "INSERT INTO `" . $this->tablefix . "category` SET fid=$CatagoryID, module=$module, `Lft`='$Rgt',`Rgt`='$Rgt'+1,`sort`=0,`name`='$SortName'" )) {
				return $this->lastInsertId ();
			
			} else {
				return - 1;
			}
		}
	
	}
	
	/** 
	 * Short description. 
	 * 删除类别 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function deleteSort($CatagoryID) {
		//取得被删除类别的左右值,检测是否有子类,如果有就一起删除 
		$Result = $this->checkCatagory ( $CatagoryID );
		$Lft = $Result ['Lft'];
		$Rgt = $Result ['Rgt'];
		//执行删除 
		if ($this->exec ( "DELETE FROM `" . $this->tablefix . "category` WHERE `Lft`>=$Lft AND `Rgt`<=$Rgt" )) {
			$Value = $Rgt - $Lft + 1;
			$this->exec ( "UPDATE `" . $this->tablefix . "category` SET `Lft`=`Lft`-$Value WHERE `Lft`>$Lft" );
			$this->exec ( "UPDATE `" . $this->tablefix . "category` SET `Rgt`=`Rgt`-$Value WHERE `Rgt`>$Rgt" );
			return 1;
		} else {
			return - 1;
		}
	}
	
	/** 
	 * Short description. 
	 * 1,所有子类,不包含自己;2包含自己的所有子类;3不包含自己所有父类4;包含自己所有父类 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function getCatagory($CatagoryID, $type = 1) {
		$Result = $this->checkCatagory ( $CatagoryID );
		$Lft = $Result ['Lft'];
		$Rgt = $Result ['Rgt'];
		$SeekSQL = "SELECT id,name,module FROM `" . $this->tablefix . "category` WHERE ";
		switch ($type) {
			case "1" :
				$condition = "`Lft`>$Lft AND `Rgt`<$Rgt";
				break;
			case "2" :
				$condition = "`Lft`>=$Lft AND `Rgt`<=$Rgt";
				break;
			case "3" :
				$condition = "`Lft`<$Lft AND `Rgt`>$Rgt";
				break;
			case "4" :
				$condition = "`Lft`<=$Lft AND `Rgt`>=$Rgt";
				break;
			default :
				$condition = "`Lft`>$Lft AND `Rgt`<$Rgt";
		}
		$SeekSQL .= $condition . " ORDER BY `Lft` ASC";
		
		return $this->fetchAll ( $SeekSQL );
	}
	
	/** 
	 * Short description. 
	 * 取得直属父类 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function getParent($CatagoryID) {
		return $this->getCatagory ( $CatagoryID, 3 );
	}
	/** 
	 * Short description. 
	 * 移动类,如果类有子类也一并移动 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function moveCatagory($SelfCatagoryID, $ParentCatagoryID) {
		$SelfCatagory = $this->checkCatagory ( $SelfCatagoryID );
		$NewCatagory = $this->checkCatagory ( $ParentCatagoryID );
		
		$SelfLft = $SelfCatagory ['Lft'];
		$SelfRgt = $SelfCatagory ['Rgt'];
		$Value = $SelfRgt - $SelfLft;
		//取得所有分类的ID方便更新左右值 
		$CatagoryIDS = $this->getcatagory ( $SelfCatagoryID, 2 );
		foreach ( $CatagoryIDS as $v ) {
			$IDS [] = $v ['id'];
		}
		$InIDS = implode ( ",", $IDS );
		
		$ParentLft = $NewCatagory ['Lft'];
		$ParentRgt = $NewCatagory ['Rgt'];
		
		if ($ParentRgt > $SelfRgt) {
			$UpdateLeftSQL = "UPDATE `" . $this->tablefix . "category` SET `Lft`=`Lft`-$Value-1 WHERE `Lft`>$SelfRgt AND `Rgt`<=$ParentRgt";
			$UpdateRightSQL = "UPDATE `" . $this->tablefix . "category` SET `Rgt`=`Rgt`-$Value-1 WHERE `Rgt`>$SelfRgt AND `Rgt`<$ParentRgt";
			$TmpValue = $ParentRgt - $SelfRgt - 1;
			$UpdateSelfSQL = "UPDATE `" . $this->tablefix . "category` SET `Lft`=`Lft`+$TmpValue,`Rgt`=`Rgt`+$TmpValue WHERE `id` IN($InIDS)";
		} else {
			$UpdateLeftSQL = "UPDATE `" . $this->tablefix . "category` SET `Lft`=`Lft`+$Value+1 WHERE `Lft`>$ParentRgt AND `Lft`<$SelfLft";
			$UpdateRightSQL = "UPDATE `" . $this->tablefix . "category` SET `Rgt`=`Rgt`+$Value+1 WHERE `Rgt`>=$ParentRgt AND `Rgt`<$SelfLft";
			$TmpValue = $SelfLft - $ParentRgt;
			$UpdateSelfSQL = "UPDATE `" . $this->tablefix . "category` SET `Lft`=`Lft`-$TmpValue,`Rgt`=`Rgt`-$TmpValue WHERE `id` IN($InIDS)";
		}
		//增加fid更新
		$sql = "UPDATE `" . $this->tablefix . "category` SET `fid`=$ParentCatagoryID WHERE id=$SelfCatagoryID";
		$this->exec ( $sql );
		$this->exec ( $UpdateRightSQL );
		$this->exec ( $UpdateSelfSQL );
		return 1;
	}
	
	/** 
	 * Short description. 
	 * 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function checkCatagory($CatagoryID) {
		//检测父类ID是否存在 
		$SQL = "SELECT id,name,Lft,Rgt FROM `" . $this->tablefix . "category` WHERE `id`='$CatagoryID' LIMIT 1";
		return $this->fetch ( $SQL );
	
	}
	
	/** 
	 * Short description. 
	 * 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         array($Catagoryarray,$Deep) 
	 * @update         date time 
	 */
	function sort2array($CatagoryID = 0) {
		$Output = array ();
		if ($CatagoryID == 0) {
			$CatagoryID = $this->getrootid ();
		}
		if (empty ( $CatagoryID )) {
			return array ();
		}
		$sql = 'SELECT Lft, Rgt FROM `' . $this->tablefix . 'category` WHERE `id`=' . $CatagoryID;
		$Row = $this->fetch ( $sql );
		if (count ( $Row ) > 0) {
			$Right = array ();
			$Query = 'SELECT * FROM `' . $this->tablefix . 'category` WHERE Lft BETWEEN ' . $Row ['Lft'] . ' AND ' . $Row ['Rgt'] . ' ORDER BY Lft ASC';
			
			$Result = $this->fetchAll ( $Query );
			foreach ( $Result as $Row ) {
				if (count ( $Right ) > 0) {
					while ( $Right [count ( $Right ) - 1] < $Row ['Rgt'] ) {
						array_pop ( $Right );
					}
				}
				$Output [] = array ('Sort' => $Row, 'Deep' => count ( $Right ) );
				$Right [] = $Row ['Rgt'];
			}
		}
		return $Output;
	}
	
	/** 
	 * Short description. 
	 * 
	 * Detail description 
	 * @param         none 
	 * @global         none 
	 * @since         1.0 
	 * @access         private 
	 * @return         void 
	 * @update         date time 
	 */
	function getrootid() {
		$Query = "SELECT * FROM`" . $this->tablefix . "category` ORDER BY `Lft` ASC LIMIT 1";
		$RootID = $this->fetch ( $Query );
		if (count ( $RootID ) > 0) {
			return $RootID ['id'];
		} else {
			return 0;
		}
	}
	
	/**
	 * 返回TreeModel
	 *
	 * @return TreeModel
	 */
	public static function instance() {
		return self::_instance ( __CLASS__ );
	}
} 