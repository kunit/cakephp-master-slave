<?php
App::uses('AppModel', 'Model');

/**
 * ArticlesTag Model
 *
 * @property Article $Article
 * @property Tag $Tag
 * @method ArticlesTag useMaster()
 * @method ArticlesTagSlave useSlave()
 */
class ArticlesTag extends AppModel {

	public $useDbConfig = 'default';

	public $actsAs = array(
		'Containable',
		'MasterSlave',
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
