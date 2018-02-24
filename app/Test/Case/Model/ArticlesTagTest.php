<?php
App::uses('ArticlesTag', 'Model');

/**
 * ArticlesTag Test Case
 */
class ArticlesTagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.articles_tag',
		'app.article',
		'app.user',
		'app.tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ArticlesTag = ClassRegistry::init('ArticlesTag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ArticlesTag);

		parent::tearDown();
	}

}
