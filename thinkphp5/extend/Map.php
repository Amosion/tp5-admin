<?php
/**
 *
 * 百度地图相关业务封装
 */
class Map {
    /**
     * 根据地址获取经纬度
     * return array
     */
    public static function getLngLat($address){
        //http://api.map.baidu.com/geocoder/v2/?address=
        //北京市海淀区上地十街10号&output=json&ak=你的ak&callback=showLocation

        if(!$address){
            return '';
        }
        $data = [
            'address' => $address,
            'ak' => config('map.ak'),
            'output' => 'json'
        ];

        $url = config('map.baidu_map_url').config('map.geocoder').'?'.http_build_query($data);
        //1 file_get_contents($url)
        //2 curl
        $result = doCurl($url);
        if($result){
            return json_decode($result,true);
        }else {
            return [];
        }
    }

    /**
      * http://api.map.baidu.com/staticimage/v2?
      * ak=E4805d16520de693a3fe707cdc962045&mcode=666666&
      * center=116.403874,39.914888&width=300&height=200&zoom=11
      *   根据经纬度或地址获取百度地图
      *   return array
      */
    public static function staticimage($center){
        if(!$center){
            return '';
        }
        $data = [
            'ak' => config('map.ak'),
            'width' => config('map.width'),
            'height' => config('map.height'),
            'center' => $center,
            'markers' => $center
        ];

        $url = config('map.baidu_map_url').config('map.staticimage').'?'.http_build_query($data);
        //1 file_get_contents($url)
        //2 curl
        $result = doCurl($url);
        if($result){
           return json_decode($result,true);
        }else {
            return [];
        }
        //return $result;

    }
}
