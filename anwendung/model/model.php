<?php
/**
 * Get access to all the data
 */
class Model {

	// store the entries in a 2 dimensional array
	private static $entries = array(
		array("id"=>0, "title"=>"Eintrag 1", "content"=>"First one..."),
		array("id"=>1, "title"=>"Eintrag 2", "content"=>"Second entry..."),
		array("id"=>2, "title"=>"Eintrag 3", "content"=>"Last one")
	);

	/**
	 * Return all entries
	 *
	 * @return array of blog entries
	 */
	public static function getEntries(){
		return self::$entries;
	}

	/**
	 * Return an entry by id
	 *
	 * @param int $id id of the entry
	 * @return Array returns array with the entry
	 */
	public static function getEntry($id){
		if(array_key_exists($id, self::$entries)){
			return self::$entries[$id];
		}else{
			return null;
		}
	}
}
?>