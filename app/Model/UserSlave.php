<?php
App::uses('User', 'Model');

/**
 * UserSlave Model
 *
 * @property ArticleSlave $Article
 * @method User getMasterInstance()
 * @method UserSlave getSlaveInstance()
 */
class UserSlave extends User {

	public $alias = 'User';

	public $useDbConfig = 'slave';

	public $useTable = 'users';

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'ArticleSlave',
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
