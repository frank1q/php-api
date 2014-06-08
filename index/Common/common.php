<?php
	function selectClass($num){
		$num = intval($num);
		switch ($num) {
			case '0':
				$class='primary';
				break;
			case '1':
				$class='info';
				break;
			case '2':
				$class='default';
				break;
			case '3':
				$class='danger';
				break;
			case '4':
				$class='success';
				break;
			case '5':
				$class='inverse';
				break;
			default:
				$class='primary';
				break;
		}
		return $class;
	}

?>