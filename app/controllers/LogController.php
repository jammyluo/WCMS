<?php
class LogController extends NodeController {

	public function listing() {
		$rs = self::getLogService ()->listing ( $_GET ['p'] );
		$this->view ()->assign ( 'totalnum', $rs ['totalnum'] );
		$flag = self::getLogService ()->getEventFlag ();
		$this->view ()->assign ( 'flag', $flag );
		$this->view ()->assign ( 'num', $rs ['page'] );
		$this->view ()->assign ( 'log', $rs ['list'] );
		$this->view ()->display ( 'file:log/list.tpl' );	
	}

	public function chart() {
		$rs = self::getLogService ()->chart ( $_GET ['event'] );
		$flag = self::getLogService ()->getEventFlag ();
		$this->view ()->assign ( 'event', urldecode($_GET ['event']) );
		$this->view ()->assign ( 'flag', $flag );
		$this->view ()->assign ( 'log', $rs );
		$this->view ()->display ( "file:log/chart.tpl" );
	}

}
