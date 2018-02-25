<?php
App::uses('ArticleTag', 'Model');

/**
 * ArticlesTagSlave Model
 *
 * @property ArticleSlave $Article
 * @property TagSlave $Tag
 * @method ArticlesTag useMaster()
 * @method ArticlesTagSlave useSlave()
 */
class ArticlesTagSlave extends ArticlesTag
{
	public $alias = 'ArticlesTag';

	public $useDbConfig = 'slave';

	public $useTable = 'articles_tags';

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Article' => array(
			'className' => 'ArticleSlave',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tag' => array(
			'className' => 'TagSlave',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
