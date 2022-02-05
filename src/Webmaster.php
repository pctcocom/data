<?php
namespace Pctco\Data;
use think\facade\Request;
/**
 * 数据
 */
class Webmaster{
    protected $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    /** 
     ** 百度资源提交 API
     *? @date 22/02/05 11:55
     *  @param Array $urls 想要提交的链接
     *  @param myParam2 Explain the meaning of the parameter...
     *! @return 
     */
    public function BaiDuResourceSubmitApi($urls = []){
        // $urls = array(
        //     'http://www.example.com/1.html',
        //     'http://www.example.com/2.html',
        // );
        $api = 'http://data.zz.baidu.com/urls?site=https://news.sangniao.com&token=l5wtrznFkevdZXkP';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        return $result;
    }
}