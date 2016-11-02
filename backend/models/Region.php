<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property integer $region_id
 * @property integer $parent_id
 * @property string $region_name
 * @property integer $region_type
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'region_type'], 'integer'],
            [['region_name'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'parent_id' => 'Parent ID',
            'region_name' => 'Region Name',
            'region_type' => 'Region Type',
        ];
    }
    /**
     *@FUNCNAME:findAllProvince;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:获取所有的省份;
     **/
    public function findAllProvince(){
        $province = new Region();
        $provinces = $province->find()->where(["region_type" => 1])->all();
        return $provinces;
    }
    /**
     *@FUNCNAME:findAllProvince;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:获取所有的城市;
     **/
    public function findAllCities($provinceId,$selection = null)
    {
        $city = new Region();
        $cities = $city->find()->where(['parent_id'=>$provinceId])->All();
        return $cities;
    }
    /**
     *@FUNCNAME:findAllProvince;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:获得所有区县;
     **/
    public function findAllDistincts($cityId,$selection = null)
    {
        $district = new Region();
        $districts = $district->find()->where(['parent_id'=>$cityId])->All();
        return $districts;
    }
}
