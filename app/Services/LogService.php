<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-09
 * Time: 9:50
 */

namespace App\Services;


class LogService
{
    /** 过滤掉updated_at,created_at 字段
     * @param $model
     * @return static
     */
    function handleCreateAttributes($model)
    {
        $attributes = collect($model)->except(['updated_at', 'created_at']);
        return $attributes;
    }


    /** 检测更新属性
     * @param $newAttributes
     * @param $lodAttributes
     * @return LogService|array
     */
    function detectChanges($newAttributes, $lodAttributes)
    {
        $changeAttributes = array_udiff_assoc($newAttributes, $lodAttributes, function ($new, $old) {
            return $new <=> $old;
        });
        $changeAttributes = $this->filterAttributes($changeAttributes);
        return $changeAttributes;
    }

    /** 过滤掉特定字段
     * @param $attributes
     * @param $filterKeys
     * @return static
     */

    function filterAttributes($attributes, $filterKeys = [])
    {
        $attributes = collect($attributes)->except(array_merge($filterKeys, ['updated_at', 'created_at']))->toArray();
        return $attributes;
    }


    /** 根据更新的属性，返回更新键的旧属性
     * @param $oldAttributes
     * @param $changeAttributes
     * @return array
     */

    function getOldChangeAttributes($changeAttributes, $oldAttributes)
    {
        $oldChangeAttributes = collect($oldAttributes)
            ->only(array_keys($changeAttributes))
            ->all();
        return $oldChangeAttributes;
    }

    /** 将更新了的新属性和旧属性用json_encode 处理
     * @param $changeAttributes
     * @param $oldAttributes
     * @return string
     */
    function getProperties($changeAttributes, $oldAttributes)
    {
        $properties = [
            'new' => $changeAttributes,
            'old' => $oldAttributes
        ];
        return $properties;
    }

    /** 生成更新字段描述
     * @param $newProperties
     * @param $oldProperties
     * @param $keyCn
     * @return null|string
     */

    function generateKeyLogCn($newProperties, $oldProperties, $keyCn)
    {
        if ($newProperties&& $oldProperties) {
            $descString = '';
            foreach ($keyCn as $key => $cn) {
                $newAttr = data_get($newProperties, $key);
                $oldAttr = data_get($oldProperties, $key);
                if(isset($newAttr)&&isset($oldAttr)){
                    $descString .= $cn . ':' .$oldAttr  . '->' .$newAttr  . ';';
                }
            }
            return $descString ? $descString : null;
        } else {
            return null;
        }
    }

    /** 检测新属性和旧属性，生成一个数组
     * @param $newArray
     * @param $oldArray
     * @return array
     */

    public function updateProperties($newArray,$oldArray):array{
        $changeAttributes = $this->detectChanges($newArray,$oldArray);
        $oldAttributes = $this->getOldChangeAttributes($changeAttributes,$oldArray);
        $properties = $this->getProperties($changeAttributes,$oldAttributes);
        return $properties;
    }

    /** 根据新属性和旧属性，生成描述
     * @param $properties
     * @param $keyCn
     * @return string
     */

    public function generateDescription($properties,$keyCn){
        $newArray =data_get($properties,'new',[]);
        $oldArray =data_get($properties,'old',[]) ;
        $description='【更新】';
        $keyDescriptionCn = $this->generateKeyLogCn($newArray,$oldArray,$keyCn);
        if($keyDescriptionCn)$description.=$keyDescriptionCn;
        return $description;
    }
}