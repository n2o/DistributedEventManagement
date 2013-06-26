<?php
class Event extends AppModel {
	public $validate = array(
		'title' => array('rule' => 'notEmpty'),
		'description' => array('rule' => 'notEmpty'));
	// public $hasAndBelongsToMany = array(
	// 	'User' => array(
	// 		'className'              => 'User',
	// 		'joinTable'              => 'events_users',
	// 		'foreignKey'             => 'event_id',
	// 		'associationForeignKey'  => 'user_id',
	// 		'unique'                 => 'keepExisting',
	// 		'conditions'             => '',
	// 		'fields'                 => '',
	// 		'order'                  => '',
	// 		'limit'                  => '',
	// 		'offset'                 => '',
	// 		'finderQuery'            => '',
	// 		'deleteQuery'            => '',
	// 		'insertQuery'            => ''
	// 	)
	// );
	public $hasMany = 'User';
}