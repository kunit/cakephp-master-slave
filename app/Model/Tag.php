<?php
App::uses('AppModel', 'Model');

/**
 * Tag Model
 *
 * @property Article $Article
 * @method Tag getMasterInstance()
 * @method TagSlave getSlaveInstance()
 */
class Tag extends AppModel {

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
	public $displayField = 'title';

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Article' => array(
			'className' => 'Article',
			'joinTable' => 'articles_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'article_id',
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
