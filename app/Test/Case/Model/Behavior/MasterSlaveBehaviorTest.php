<?php
App::uses('User', 'Model');

/**
 * MasterSlaveBehavior Test Case
 */
class MasterSlaveBehaviorTest extends CakeTestCase {

	/** @var User $User */
	public $User;

	/** @var Article $Article */
	public $Article;

	/** @var Tag $Tag */
	public $Tag;

	/** @var ArticlesTag $ArticlesTag */
	public $ArticlesTag;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.user',
		'app.article',
		'app.tag',
		'app.articles_tag',
		'app.user_slave',
		'app.article_slave',
		'app.tag_slave',
		'app.articles_tag_slave',
	);

	public function setUp()
	{
		parent::setUp();

		$this->User = ClassRegistry::init('User');
		$this->Article = ClassRegistry::init('Article');
		$this->Tag = ClassRegistry::init('Tag');
		$this->ArticlesTag = ClassRegistry::init('ArticlesTag');
	}

	public function tearDown()
	{
		$this->User = null;
		$this->Article = null;
		$this->Tag = null;
		$this->ArticlesTag = null;

		parent::tearDown();
	}

	/**
	 * @throws \Exception
	 */
	public function test_001_Masterのみで処理する() {
		$this->saveMaster();

		$actual = $this->User->find('all');
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$this->assertSame('test', $this->User->useDbConfig);
		$this->assertSame('test', $this->User->Article->useDbConfig);

		$user = ClassRegistry::init('User');
		$this->assertSame('test', $user->useDbConfig);
		$this->assertSame('test', $user->Article->useDbConfig);

		$actual = $this->User->useMaster()->find('all');
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$this->assertSame('test', $this->User->useDbConfig);
		$this->assertSame('test', $this->User->Article->useDbConfig);

		$user = ClassRegistry::init('User');
		$this->assertSame('test', $user->useDbConfig);
		$this->assertSame('test', $user->Article->useDbConfig);

	}

	/**
	 * @throws \Exception
	 */
	public function test_002_MasterにSaveして、Slaveからfindする() {
		$this->saveMaster();

		/** @var UserSlave $user */
		$user = $this->User->useSlave();

		$this->assertSame('UserSlave', get_class($user));
		$this->assertSame('test_slave', $user->useDbConfig);
		$this->assertSame('test_slave', $user->Article->useDbConfig);

		$actual = $user->find('all');
		$this->assertEmpty($actual);

		$this->saveSlave();

		$actual = $user->find('all');
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$this->assertSame('test', $this->User->useDbConfig);
		$this->assertSame('test', $this->User->Article->useDbConfig);

		$user = ClassRegistry::init('User');
		$this->assertSame('test', $user->useDbConfig);
		$this->assertSame('test', $user->Article->useDbConfig);
	}

	/**
	 * @throws \Exception
	 */
	public function test_003_Slaveに切り替えて、Master戻してからfindする() {
		$this->saveMaster();
		$this->saveSlave();

		/** @var User $user */
		$user = $this->User->useSlave()->useMaster();

		$this->assertSame('User', get_class($user));
		$this->assertSame('test', $user->useDbConfig);
		$this->assertSame('test', $user->Article->useDbConfig);

		$actual = $user->find('all');
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$this->User = ClassRegistry::init('User');
		$this->assertSame('test', $this->User->useDbConfig);
		$this->assertSame('test', $this->User->Article->useDbConfig);
	}

	/**
	 * @throws \Exception
	 */
	public function test_004_Slave側のモデルに対して、Master側と同じ条件で検索できる() {
		$this->saveMaster();
		$this->saveSlave();

		$actual = $this->User->find('all', array(
			'contain' => array(
				'Article' => array(
					'conditions' => array(
						'Article.title' => 'article test title',
					),
				),
			),
			'conditions' => array(
				'User.email' => 'test@example.co.jp',
			),
		));
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$actual = $this->User->useSlave()->find('all', array(
			'contain' => array(
				'Article' => array(
					'conditions' => array(
						'Article.title' => 'article test title',
					),
				),
			),
			'conditions' => array(
				'User.email' => 'test@example.co.jp',
			),
		));
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$actual = $this->Article->find('all', array(
			'contain' => array(
				'User' => array(
					'conditions' => array(
						'User.email' => 'test@example.co.jp',
					)
				),
				'Tag' => array(
					'conditions' => array(
						'Tag.title' => 'tag test title',
					)
				),
			),
			'conditions' => array(
				'Article.title' => 'article test title',
			),
		));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.title'));
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('tag test title', Hash::get($actual, '0.Tag.0.title'));

		$actual = $this->Article->useSlave()->find('all', array(
			'contain' => array(
				'User' => array(
					'conditions' => array(
						'User.email' => 'test@example.co.jp',
					)
				),
				'Tag' => array(
					'conditions' => array(
						'Tag.title' => 'tag test title',
					)
				),
			),
			'conditions' => array(
				'Article.title' => 'article test title',
			),
		));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.title'));
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('tag test title', Hash::get($actual, '0.Tag.0.title'));
	}

	/**
	 * @throws \Exception
	 */
	public function test_005_Slaveに2回切り替えてからfindする()
	{
		$this->saveMaster();
		$this->saveSlave();

		/** @var User $user */
		$user = $this->User->useSlave()->useSlave();

		$this->assertSame('UserSlave', get_class($user));
		$this->assertSame('test_slave', $user->useDbConfig);
		$this->assertSame('test_slave', $user->Article->useDbConfig);

		$actual = $user->find('all');
		$this->assertSame('test@example.co.jp', Hash::get($actual, '0.User.email'));
		$this->assertSame('article test title', Hash::get($actual, '0.Article.0.title'));

		$this->User = ClassRegistry::init('User');
		$this->assertSame('test', $this->User->useDbConfig);
		$this->assertSame('test', $this->User->Article->useDbConfig);
	}

	/**
	 * @throws \Exception
	 */
	protected function saveMaster() {
		$data = array(
			'User' => array(
				'email' => 'test@example.co.jp',
				'password' => 'master_slave_test',
			),
		);

		/** @var User $user */
		$user = ClassRegistry::init('User');
		$user->save($data);

		$data = array(
			'Article' => array(
				'user_id' => $user->id,
				'title' => 'article test title',
				'body' => 'article test body',
				'slug' => 'article test slug',
			),
		);

		/** @var Article $article */
		$article = ClassRegistry::init('Article');
		$article->save($data);

		$data = array(
			'Tag' => array(
				'title' => 'tag test title',
			),
		);

		/** @var Tag $tag */
		$tag = ClassRegistry::init('Tag');
		$tag->save($data);

		$data = array(
			'ArticlesTag' => array(
				'article_id' => $article->id,
				'tag_id' => $tag->id,
			),
		);

		/** @var ArticlesTag $articlesTag */
		$articlesTag = ClassRegistry::init('ArticlesTag');
		$articlesTag->save($data);
	}

	/**
	 * 本来 Slave には Save しないが、テスト環境では Master -> Slave への連携は
	 * ないので、別途保存する
	 *
	 * @throws \Exception
	 */
	protected function saveSlave() {
		$data = array(
			'User' => array(
				'email' => 'test@example.co.jp',
				'password' => 'master_slave_test',
			),
		);

		/** @var UserSlave $user */
		$user = ClassRegistry::init('User')->useSlave();
		$user->save($data);

		$data = array(
			'Article' => array(
				'user_id' => $user->id,
				'title' => 'article test title',
				'body' => 'article test body',
				'slug' => 'article test slug',
			),
		);

		/** @var ArticleSlave $article */
		$article = ClassRegistry::init('Article')->useSlave();
		$article->save($data);

		$data = array(
			'Tag' => array(
				'title' => 'tag test title',
			),
		);

		/** @var TagSlave $tag */
		$tag = ClassRegistry::init('Tag')->useSlave();
		$tag->save($data);

		$data = array(
			'ArticlesTag' => array(
				'article_id' => $article->id,
				'tag_id' => $tag->id,
			),
		);

		/** @var ArticlesTagSlave $articlesTag */
		$articlesTag = ClassRegistry::init('ArticlesTag')->useSlave();
		$articlesTag->save($data);
	}

}
