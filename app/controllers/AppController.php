<?php
class AppController extends Action {
	
	
	//app首页显示页面
	public function iframe() {
		$this->view ()->display ( 'file:app/iframe.tpl' );
	}
}