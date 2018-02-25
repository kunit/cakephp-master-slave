<?php
App::uses('ModelBehavior', 'Model');

class MasterSlaveBehavior extends ModelBehavior {

	/**
	 * @param Model $model
	 * @return bool|null|object
	 */
	public function useMaster(Model $model) {
		$class = get_class($model);
		$backupClass = $class;
		$class = preg_replace('|Slave$|', '', $class);

		ClassRegistry::removeObject($model->alias);
		$masterModel = ClassRegistry::init($class);

		ClassRegistry::removeObject($masterModel->alias);
		ClassRegistry::init($backupClass);

		return $masterModel;
	}

	/**
	 * @param Model $model
	 * @return bool|null|object
	 */
	public function useSlave(Model $model) {
		$class = get_class($model);
		$backupClass = $class;
		$alias = $class;
		$class .= 'Slave';

		ClassRegistry::removeObject($model->alias);
		$slaveModel = ClassRegistry::init(array(
			'class' => $class,
			'alias' => $alias,
		));

		ClassRegistry::removeObject($slaveModel->alias);
		ClassRegistry::init($backupClass);

		return $slaveModel;
	}

}
