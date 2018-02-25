<?php
App::uses('ModelBehavior', 'Model');

class MasterSlaveBehavior extends ModelBehavior {

	/**
	 * @param Model $model
	 * @return bool|null|object
	 */
	public function useMaster(Model $model) {
		$class = get_class($model);
		$class = preg_replace('|Slave$|', '', $class);

		$instance = ClassRegistry::init($class);
		if (get_class($instance) === $class) {
			return $instance;
		}

		ClassRegistry::removeObject($model->alias);
		return ClassRegistry::init($class);
	}

	/**
	 * @param Model $model
	 * @return bool|null|object
	 */
	public function useSlave(Model $model) {
		$class = get_class($model);
		$alias = $class;
		$class .= 'Slave';

		ClassRegistry::removeObject($model->alias);
		$slaveModel = ClassRegistry::init(array(
			'class' => $class,
			'alias' => $alias,
		));

		// master のモデルに戻しておく
		$class = preg_replace('|Slave$|', '', $class);
		ClassRegistry::removeObject($slaveModel->alias);
		ClassRegistry::init($class);

		return $slaveModel;
	}

}
