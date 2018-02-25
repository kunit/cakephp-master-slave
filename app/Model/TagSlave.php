<?php
App::uses('Tag', 'Model');

/**
 * TagSlave Model
 *
 * @property ArticleSlave $Article
 * @method Tag useMaster()
 * @method TagSlave useSlave()
 */
class TagSlave extends Tag {

	public $alias = 'Tag';

	public $useDbConfig = 'slave';

	public $useTable = 'tags';

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Article' => array(
			'className' => 'ArticleSlave',
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
