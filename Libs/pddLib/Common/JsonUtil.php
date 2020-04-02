<?php

namespace SmartJson\Pdd\Common;

/**
 * 全局处理字符串
 */

class JsonUtil
{
    /**
     * @param $doc 属性字段的注解
     * @return array|null 然后数组，$arr[0]是类型， $arr[1]是映射的名称
     */
    public static function parseDoc($doc)
    {
        $pattern = '/@JsonProperty\(([\w|\<|\>|\\\\]+),[\s?]\"(\w+)\"\)/i';
        preg_match($pattern, $doc, $matches);
        if ($matches && count($matches) == 3) {
            return array($matches[1], $matches[2]);
        } else {
            return NULL;
        }
    }

}