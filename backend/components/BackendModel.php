<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\components;

/**
 * Interface BackendModel
 * @package backend\components
 *
 * @property integer $id
 */
interface BackendModel
{
    /**
     * Get title for the template page
     *
     * @return string
     */
    public function getTitle();

    /**
     * Has search form on index template page
     *
     * @return bool
     */
    public function hasSearch();

    /**
     * Get attribute columns for index and view page
     *
     * @param $page
     *
     * @return array
     */
    public function getColumns($page);

    /**
     * @return \yii\db\ActiveRecord
     */
    public function getSearchModel();

    /**
     * @return array
     */
    public function getFormConfig();
}
