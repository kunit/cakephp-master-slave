# MasterSlaveBehavior for CakePHP2

## 目的

既にある程度システムが組まれていて、途中から Master/Slave 構成にする場合に、 既存のコードを極力変更せずに、Master/Slave 切り替えながら クエリー発行できるようにする。

アソシエーションがある場合にも対応する。

## 組み込み方

### 1. Master/Slave でアクセスするモデルに対して、XxxSlave モデルを追加する

たとえば、User モデル に対して行う場合、 User モデルを継承した UserSlave モデルを作る。

### 2. XxxSlave モデルにいくつかプロパティを追加する

以下のプロパティを追加する

1. `$alias` は、親のモデルと同じものを設定する
    - 例えば、UserSlave モデルの場合は、 `public $alias = 'User';` となる
2. `$useDbConfig` は、database.php に設定した slave 用のエントリを設定する
3. `$useTable` は、親のモデルと同じものを設定する
    - 例えば、UserSlave モデルの場合は、 `public $useTable = 'users';` となる
4. 親のモデルにアソシエーションの定義がある場合、それ用の YyySlave モデルを同じように設定し、定義部分の class を Yyy から YyySlave に変更

例えば、以下のような設定になる

```php
<?php
App::uses('User', 'Model');

class UserSlave extends User {
	public $alias = 'User';
	public $useDbConfig = 'slave';
	public $useTable = 'users';

	public $hasMany = array(
		'Article' => array(
			'className' => 'ArticleSlave',
			'foreignKey' => 'user_id',
		),
	);
}
```

### 3. XXX モデルに MasterSlave Behavior を追加する

```php
class User extends AppModel {
    public $actsAs = array('MasterSlave');
}
```

### 4. Slave 側のインスタンスを取得して find 等の処理する

```php
<?php
$this->User = ClassRegistry::init('User');

$users = $this->User->getSlaveInstance()->find('all');
```

`$this->User->getSlaveInstance()` の返却値は、 `UserSlave` モデルのインスタンスになる
