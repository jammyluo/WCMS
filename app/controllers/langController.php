<?php
/**
 * 多语言
 * @author Administrator
 *
 */
class LangController extends Action {
	
	/**
	 * 多语言切换
	 */
	public function language() {
		if ($_GET ['lang']) {
			//   setcookie("lang", "");
			setcookie ( "lang", trim ( $_GET ['lang'] ), time () + 3600 * 8, "/" );
			echo "<script>javascript:history.go(-1)</script>";
			return;
		
		}
	}
}


