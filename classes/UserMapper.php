<?php

class Usermapper {

	function getUserIdsByMetaValue($key, $value) {

		global $wpdb;
		$table_name = $wpdb->prefix . "usermeta";
		$sql = "SELECT DISTINCT user_id  FROM " . $table_name ." WHERE `meta_key` LIKE '". $key ."' AND meta_value LIKE '". $value . "';";
		$result = $wpdb->get_results($sql);
		$ids = array(); // $ids = []; --> Omdat kakserver een veel te lage PHP versie heeft!
		foreach ($result as $row){
			$ids[] = $row->user_id;
		}
		return $ids;
	}

	function getUserById() {

	}
}