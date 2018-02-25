<?php
App::uses('Article', 'Model');

/**
 * ArticleSlave Model
 *
 * @property UserSlave $User
 * @property TagSlave $Tag
 * @method Article useMaster()
 * @method ArticleSlave useSlave()
 */
class ArticleSlave extends Article {

	public $alias = 'Article';

	public $useDbConfig = 'slave';

	public $useTable = 'articles';

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'UserSlave',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'TagSlave',
			'joinTable' => 'articles_tags',
			'foreignKey' => 'article_id',
			'associationForeignKey' => 'tag_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
