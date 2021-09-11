<?php
namespace Pctco\Data;
/**
 * 搜索引擎数据索引
 */
class Sitemap{
   /**
   * @name generate
   * @describe 生成 xml
   * @param mixed $platform 平台 如： universal(baidu,so,bing),sogou(sogou_media（响应式站点）)
   * @param mixed $platform = baidu.com
   * @return
   **/
   public function generate($data,$db = 'article',$changefreq = 'daily',$platform = 'universal'){
      $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
      $xml .= "<urlset>\n";
      if ($platform === 'sogou_media') {
         foreach ($data as $item) {
            $xml .= $this->SoGouMediaXml($item);
         }
      }
      if ($platform === 'universal') {
         foreach ($data as $item) {
            $xml .= $this->UniversalXml($item,$changefreq);
         }
      }
      $xml .= "</urlset>\n";

      $path = '/static/library/xml/sitemap/'.$db.'_'.$changefreq.'_'.$platform.'.xml';
      file_put_contents(app()->getRootPath().'entrance'.$path,$xml);

      return $path;
   }
   /**
   * @name UniversalXml
   * @describe 创建XML单项 （通用）
   * @param mixed $item 数据字段 字段
   *   url ： 文章url
   *   channel ： 频道 https://news.sangniao.com
   *   pattern : url 规则 http://news.sangniao.com/p/712821817 = http://news.sangniao.com/p/(\d+)
   *   date ： 日期 2021-10-21
   *
   *
   *
   * @param mixed $changefreq always（总是）、hourly（每小时）、daily（每天）、weekly（每周）、monthly（每月）、yearly（每年）、never（从不）
   * @return String
   **/
   public function UniversalXml($item = [],$changefreq = 'daily'){
       $xml = "<url>\n";
       $xml .= "<loc>" . $item['url'] . "</loc>\n";
       $xml .= "<lastmod>" . $item['date'] . "</lastmod>\n";
       $xml .= "<changefreq>".$changefreq."</changefreq>\n";
       $xml .= "</url>\n";
       return $xml;
   }
   /**
   * @name universal
   * @describe 创建XML单项 （搜狗自适应规则文件）
   * @param mixed $item 数据字段 字段
   * @return String
   *
   * <version>7</version>
   * 必填，填写映射规则适合的版本:1只适用于简版，2只适用于彩版，5只适用于移动版，6适用于彩版和移动版，7适用于简版、彩版、移动版
   *
   **/
   public function SoGouMediaXml($item = []){
       $xml = "<url>\n";
       $xml .= "<loc>" . $item['channel'] . "</loc>\n";
       $xml .= "<data>\n";
       $xml .= "<display>\n";
       $xml .= "<pc_url_pattern>" . $item['pattern'] . "</pc_url_pattern>\n";
       $xml .= "<pc_sample>".$item['url']."</pc_sample>\n";
       $xml .= "<version>7</version>";
       $xml .= "</display>\n";
       $xml .= "</data>\n";
       $xml .= "</url>\n";
       return $xml;
   }
   public function group($data){
      return [
         'count'   =>   count($data),
         'platform'   =>   ['universal','sogou_media'],
         'baidu.com'   =>   [
            'url'   =>   ''
         ],
         'so.com'   =>   [
            'url'   =>   ''
         ],
         'bing.com'   =>   [
            'url'   =>   ''
         ],
         'sogou.com'   =>   [
            'media'   =>   [
               'url'   =>   ''
            ]
         ]
      ];
   }
}
