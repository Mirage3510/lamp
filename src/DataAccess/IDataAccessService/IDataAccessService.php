<?php

/**
 * 汎用データアクセスサービスのインターフェースです。
 */
interface IDataAccessService {

	/**
	 * 指定の検索条件でデータを検索します。
	 * @param SearchCondition $searchCondition
	 * @param ConditionType $conditionType
	 */
	public function searchByCondition($searchCondition);

	/**
	 * IDを元にデータ検索します。
	 * @param unknown $id
	 */
	public function searchById($id);

	/**
	 * データを作成します。
	 * @param $model
	 */
	public function create($model);

	/**
	 * データを更新します。
	 * @param $model
	 */
	public function update($model);

	/**
	 * 指定IDのデータを論理削除します。
	 * @param $id
	 */
	public function remove($id);

	/**
	 * 指定IDのデータを物理削除します。
	 * @param $id
	 */
	public function delete($id);


}