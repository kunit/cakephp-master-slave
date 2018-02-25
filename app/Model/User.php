<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Article $Article
 * @method User useMaster()
 * @method UserSlave useSlave()
 */
class User extends AppModel {

	public $useDbConfig = 'default';

	public $actsAs = array(
		'Containable',
		'MasterSlave',
	);

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'email';

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
