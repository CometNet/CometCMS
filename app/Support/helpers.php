<?php

use App\Models\Option;
use App\Models\Menu;
use App\Models\SlideItem;

if (! function_exists('getOption')) {
    /**
     * 通过配置名称获取配置内容
     * @param string $option_name
     * @param string $default
     * @return string
     */
    function getOption(string $option_name, string $default = null)
    {
        $option = Option::where(['option_name' => $option_name])->first();
        if($option){
            return $option->option_value;
        }

        return $default;
    }
}

if (! function_exists('getMenu')) {
    /**
     * 通过导航id获取菜单名称列表
     * @param int $nav_id
     * @return array
     */
    function getMenu(int $nav_id)
    {
        return Menu::where(['nav_id' => $nav_id, 'status' => 1])->get();
    }
}

if (! function_exists('getSlide')) {
    /**
     * 通过导航id获取菜单名称列表
     * @param int $slide_id
     * @return array
     */
    function getSlide(int $slide_id)
    {
        return SlideItem::where(['slide_id' => $slide_id, 'status' => 1])->get();
    }
}

