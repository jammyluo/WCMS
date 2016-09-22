<?php
interface ILog {
	
	public function add($username, $event);
	public function getLogByActionTime($actionTime);
	public function getLogByUsername($username);
}