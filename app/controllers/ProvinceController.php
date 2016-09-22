<?php
class ProvinceController extends Action {
	
	public function areas() {
		$service = new ProvinceService ();
		echo $service->getType ( $_POST ['type'], $_POST ['id'] );
	}
}