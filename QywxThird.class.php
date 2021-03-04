<?php
class QywxThird
{  

    private $providerSecret;
    private $suiteId;
    private $suiteSecret;
    private $token;
    private $encodingAESKey;
    private $authType;
    private $templateId;
    private $approvalFlowId;

    const BASE_URL = "https://qyapi.weixin.qq.com/cgi-bin/";
    //服务商相关
    const SERVICE_URL = BASE_URL+"service/";
    const SUITE_TOKEN_URL = SERVICE_URL+"get_suite_token";
    const PRE_AUTH_CODE_URL = SERVICE_URL+"get_pre_auth_code?suite_access_token=%s";
    const PERMANENT_CODE_URL = SERVICE_URL+"get_permanent_code?suite_access_token=%s";
    const SESSION_INFO_URL = SERVICE_URL+"set_session_info?suite_access_token=%s";

    const INSTALL_URL = "https://open.work.weixin.qq.com/3rdapp/install?suite_id=%s&pre_auth_code=%s&redirect_uri=%s&state=_state";
    const PROVIDER_TOKEN_ULR = SERVICE_URL+"get_provider_token";
    const REGISTER_CODE_URL = SERVICE_URL+ "get_register_code?provider_access_token=%s";
    const REGISTER_URL = "https://open.work.weixin.qq.com/3rdservice/wework/register?register_code=%s";
    const SSO_AUTH_URL = "https://open.work.weixin.qq.com/wwopen/sso/3rd_qr_connect?appid=%s&redirect_uri=%s&state=%s&usertype=%s";
    const LOGIN_INFO_URL = SERVICE_URL+"get_login_info?access_token=%s";
    //通讯录转译
    const CONTACT_UPLOAD_URL = SERVICE_URL+"media/upload?provider_access_token=%s&type=%s";
    const CONTACT_TRANS_URL = SERVICE_URL + "contact/id_translate?provider_access_token=%s";
    const TRANS_RESULT_URL = service_url + "batch/getresult?provider_access_token=%s&jobid=%s";
    //公司相关
    const CORP_TOKEN_URL = service_url+"get_corp_token?suite_access_token=%s";
    const DEPARTMENT_URL = BASE_URL+"department/list?access_token=%s";
    const USER_SIMPLELIST_URL = BASE_URL+"user/simplelist?access_token=%s&department_id=%s&fetch_child=%s";
    const USER_DETAIL_URL = BASE_URL+"user/get?access_token={access_token}&userid={user_id}";
    //外部联系人
    //获取配置了客户联系功能的成员列表 https://work.weixin.qq.com/api/doc/90001/90143/92576
    const EXT_CONTACT_FOLLOW_USER_LIST_URL = BASE_URL+"externalcontact/get_follow_user_list?access_token=%s";
    //获取客户列表 https://work.weixin.qq.com/api/doc/90001/90143/92264
    const EXT_CONTACT_LIST_URL = BASE_URL+"externalcontact/list?access_token=%s&userid=%s";
    //获取客户群列表 https://work.weixin.qq.com/api/doc/90001/90143/93414
    const EXT_CONTACT_GROUPCHAT_URL = BASE_URL+"externalcontact/groupchat/list?access_token=%s";
    //消息推送
    const MESSAGE_SEND_URL= BASE_URL+"message/send?access_token=%s";
    //素材管理
    //https://open.work.weixin.qq.com/api/doc/90001/90143/90389
    //type 是 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件（file）
    const MEDIA_UPLOAD_URL = BASE_URL+"media/upload?access_token=%s&type=%s";
    const MEDIA_UPLOADIMG_URL = BASE_URL+"media/uploadimg?access_token=%s";
    const MEDIA_GET_URL = BASE_URL+"media/get?access_token=%s&media_id=%s";
    const MEDIA_GET_JSSDK_URL = _base_url+"media/get/jssdk?access_token=%s&media_id=%s";
    //审批
    //审批应用 https://work.weixin.qq.com/api/doc/90001/90143/91956
    const OA_COPY_TEMPLATE_URL ="oa/approval/copytemplate?access_token=%s";
    const OA_GET_TEMPLATE_URL ="/oa/gettemplatedetail?access_token=%s";
    const OA_APPLY_EVENT_URL = "oa/applyevent?access_token=%s";
    const OA_GET_APPROVAL_URL ="oa/getapprovaldetail?access_token=%s";
    //审批流程引擎 https://work.weixin.qq.com/api/doc/90001/90143/93798
    const open_approval_data_url = _base_url+"corp/getopenapprovaldata?access_token=_access_token";
    // _h5应用
    //scope应用授权作用域。
    //snsapi_base：静默授权，可获取成员的基础信息（_user_id与_device_id）；
    //snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱等敏感信息；
    //snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱等敏感信息（已不再支持获取手机号/邮箱）。
    //https://work.weixin.qq.com/api/doc/90001/90143/91120
    const OAUTH_URL = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect";
    //https://work.weixin.qq.com/api/doc/90001/90143/91121
    const OAUTH_USER_URL = SERVICE_URL+"getuserinfo3rd?suite_access_token=%s&code=%s";
    //https://work.weixin.qq.com/api/doc/90001/90143/91122
    const OAUTH_USER_DETAIL_URL = SERVICE_URL+"getuserdetail3rd?suite_access_token=%s";
    //https://work.weixin.qq.com/api/doc/90001/90144/90539
    const JSAPI_TICKET_URL = _base_url+"get_jsapi_ticket?access_token=%s";
    //https://work.weixin.qq.com/api/doc/90001/90144/90539#%_e8%8_e%_b7%_e5%8_f%96%_e5%_ba%94%_e7%94%_a8%_e7%9_a%84jsapi_ticket
    const JSAPI_TICKET_AGENT_URL = _base_url+"ticket/get?access_token=%s&type=agent_config";
    //家校沟通
    //https://open.work.weixin.qq.com/api/doc/90001/90143/92291
    const EXT_CONTACT_MESSAGE_SEND_URL = _base_url+"externalcontact/message/send?access_token=%s";
    //此oauth与_h5oauth一致 https://work.weixin.qq.com/api/doc/90001/90143/91861
    const SCHOOL_OAUTH_URL = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect";
    //https://work.weixin.qq.com/api/doc/90001/90143/91711
    const SCHOOL_OAUTH_USER_URL = SERVICE_URL+"getuserinfo3rd?suite_access_token=%s&code=%s";
    const school_url = _base_url+"school/";
    //https://work.weixin.qq.com/api/doc/90001/90143/92038
    const SCHOOL_USER_GET_URL = school_url+"user/get?access_token=%s&userid=%s";
    //https://work.weixin.qq.com/api/doc/90001/90143/92299
    const SCHOOL_DEPARTMENT_LIST_URL = school_url+"department/list?access_token=%s&id=%s";
    //https://work.weixin.qq.com/api/doc/90001/90143/92043
    const SCHOOL_USER_LIST_URL = school_url+"user/list?access_token=%s&department_id=%s&fetch_child=%s";
    //小程序应用
    //小程序登录流程 https://work.weixin.qq.com/api/doc/90001/90144/92427
    //code2_session https://work.weixin.qq.com/api/doc/90001/90144/92423
    const CODE2SESSION_URL = SERVICE_URL+"miniprogram/jscode2session?suite_access_token=%s&js_code=%s&grant_type=authorization_code";


    public function __construct($mchid, $appid, $appKey,$key)
    {
        $this->mchid = $mchid; //https://pay.weixin.qq.com 产品中心-开发配置-商户号
        $this->appid = $appid; //微信支付申请对应的公众号的APPID
        $this->appKey = $appKey; //微信支付申请对应的公众号的APP Key
        $this->apiKey = $key;   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
    }

    public static function curlGet($url = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function curlPost($url = '', $postData = '', $options = array())
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }
    
    protected static function formatQueryParaMap($paraMap, $urlEncode = false)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($para$as $k => $v) {
            if (null != $v && "null" != $v) {
                if ($urlEncode) {
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    public function getVerify($sVerifyMsgSig,$sVerifyTimeStamp,
    $sVerifyNonce,$sVerifyEchoStr){

    }

    public function instructCallback($sVerifyMsgSig,$sVerifyTimeStamp,$sVerifyNonce,$sData){

    }

    public function dataCallback($sVerifyMsgSig,$sVerifyTimeStamp,$sVerifyNonce,$sData){
        
    }


    //********************************** 应用安装   *************************//
    public function getPreAuthCode($suiteToken){
        $result = "";
        $token = $suiteToken;
        //获取预授权码
//        $params$= new HashMap();
//        paramsMap["suite_access_token",token);
        
        $url = sprintf(self::PRE_AUTH_CODE_URL,token);
        $response = self::curlGet(url);
        //获取错误日志
        if(response.("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }else{
            result = $response["pre_auth_code"];
            //设置授权楝，对某次预授权码pre_auth_code进行授权类型设置
            setSessionInfo(result);
        }
        return result;
    }


    private function setSessionInfo($preAuthCode){
        $token = getSuiteToken();
        //如是测试授权，设置授权配置
        //if(self::getAuthType() == 1){

            JSONObject sessionInfo = new JSONObject();
            sessionInfo["appid"]= new int[0]);
            sessionInfo["auth_type"]=self::getAuthType());
            $postJsonArr = new array();
            $postJson["pre_auth_code"]=preAuthCode);
            $postJson["session_info"]=sessionInfo);
            logger.error(postJson.toString());
            $sessionInfoUrl = sprintf(self::getSessionInfoUrl(),token);
            $sessionResponse = RestUtils.post(sessionInfoUrl,postJson);
            //获取错误日志
            if(sessionResponse.containsKey("errcode") && (Integer) sessionResponse["errcode") != 0){
                logger.error(sessionResponse.toString());
                return false;
            }
        //}
        return  true;
    }

    public function getInstallUrl($url){
        $preAuthCode= getPreAuthCode();
        $result = sprintf(self::getInstallUrl(),self::getSuiteId(),preAuthCode,url);
        return  $result;
    }

    public function getPermentCode($authCode){
        //通过auth code获取公司信息及永久授权码

        $postJsonArr = new array();
        $postJson["auth_code"]= $authCode;
        $url = sprintf(self::getPermanentCodeUrl(),getSuiteToken());
        $response = RestUtils.post(url,postJson);
        //获取错误日志
        if(response.containsKey("errcode") && (Integer) response["errcode"] != 0){
            logger.error(response.toString());
            return  false;
        }
        logger.error(response.toString());

        //保存授权公司信息
        //https://open.work.weixin.qq.com/api/doc/90001/90143/90604
        /**
         "auth_corp_info":
         {
         "corpid": "xxxx",
         "corp_name": "name",
         "corp_type": "verified",
         "corp_square_logo_url": "yyyyy",
         "corp_user_max": 50,
         "corp_agent_max": 30,
         "corp_full_name":"full_name",
         "verified_end_time":1431775834,
         "subject_type": 1,
         "corp_wxqrcode": "zzzzz",
         "corp_scale": "1-50人",
         "corp_industry": "IT服务",
         "corp_sub_industry": "计算机软件/硬件/信息服务",
         "location":"广东省广州市"
         },
         "auth_info":
         {
         "agent" :
         [
         {
         "agentid":1,
         "name":"NAME",
         "round_logo_url":"xxxxxx",
         "square_logo_url":"yyyyyy",
         "appid":1,
         "privilege":
         {
         "level":1,
         "allow_party":[1,2,3],
         "allow_user":["zhansan","lisi"],
         "allow_tag":[1,2,3],
         "extra_party":[4,5,6],
         "extra_user":["wangwu"],
         "extra_tag":[4,5,6]
         }
         },
         {
         "agentid":2,
         "name":"NAME2",
         "round_logo_url":"xxxxxx",
         "square_logo_url":"yyyyyy",
         "appid":5
         }
         ]
         }
         * **/
        //获取永久授权码
        $permanenCode= $response["permanent_code"];
        //获取corpId
        $authCorpInfo =$response["auth_corp_info"];
        $corpId = $authCorpInfo["corpid"];
        //获取agent
        $authInfo = $response["auth_info"];
        $agentList = $authInfo["agent"];
        $agent = $agentList.get(0);
        $agentId = $agent["agentid"];

        QywxThirdCompany company = new QywxThirdCompany();
        company.setPermanentCode(permanenCode);
        company.setCorpId(corpId) ;
        company.setCorpName($authCorpInfo["corp_name"));
        $fullName = authCorpInfo["corp_full_name") ==  null  ? "" :  (String)authCorpInfo["corp_full_name"];
        company.setCorpFullName(fullName);
        company.setSubjectType((Integer) authCorpInfo["subject_type"));
        //设置授权应用id  用于Jssdk agentconfig等使用
        company.setAgentId(agentId);
        company.setStatus(1);
        logger.info(company.toString());
        qywxThirdCompanyService.saveCompany(company);

        //保存授权用户信息
        /**
        "auth_user_info":
        {
            "userid":"aa",
                "name":"xxx",
                "avatar":"http://xxx"
        },
         **/

        QywxThirdUser  user = new QywxThirdUser();
        $authUserInfo = $response["auth_user_info"];
        user.setUserId((String)authUserInfo["userid"));
        user.setName((String)authUserInfo["name"));
        user.setAvatar((String)authUserInfo["avatar"));
        user.setCorpId(corpId);
        user.setStatus(1);
        logger.info(user.toString());
        qywxThirdUserService.saveUser(user);

        //异步同步部门，人员 待处理

        return true;

    }

    private function deleteCompany($corpId){
        return  qywxThirdCompanyService.deleteCompanyByCorpId(corpId) ;
    }



    //**********************************  服务商相关   *************************//
    public function getProviderToken(){

        $postJsonArr = new array();
        $postJson["corpid"]=self::getCorpId();
        $postJson["provider_secret"]=self::getProviderSecret();

        $url = self::getProviderTokenUlr();
        $response= RestUtils.post(url,postJson);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        $token =  $response["provider_access_token"];
        return  token;

    }

    public function getRegisterCode(){

        $url = sprintf(self::getRegisterCodeUrl(),getProviderToken()) ;

        $postJsonArr = new array();
        $postJson["template_id"]=self::getTemplateId();
        $postJson["state"]="lyx123456"];

        $response= RestUtils.post(url,postJson);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        $token =  $response["register_code"];
        return  token;

    }

    public function getRegisterUrl(){
        $registerUrl = sprintf(self::getRegisterUrl(),getRegisterCode());
        return  registerUrl;
    }



    //**********************************  通讯录相关   *************************//
    /**
     *
     * @param filePath
     * @return
     * {
     *    "errcode": 0,
     *    "errmsg": ""，
     *    "type": "image",
     *    "media_id": "1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0",
     *    "created_at": "1380000000"
     * }
     *
     */
    public function uploadContact($filePath){

        //https://open.work.weixin.qq.com/api/doc/90001/90143/91883
        $providerToken = getProviderToken();
        $url = sprintf(self::getContactUploadUrl(),providerToken,"file");

        MultiValueMap<String, Object> params= new LinkedMultiValueMap<>();
        FileSystemResource resource = new FileSystemResource(new File(filePath));
        params.add("media"]=resource);
        return  RestUtils.upload(url,params);

    }

    /**
     *
     * @return
     * {
     *     "errcode": 0,
     *     "errmsg": "ok",
     *     "jobid": "xxxxx"
     * }
     */
    public function transContact($corpId,$mediaId){
        //https://open.work.weixin.qq.com/api/doc/90001/90143/91846
        /**
         * 参数
         * {
         *     "auth_corpid": "wwxxxx",
         *     "media_id_list": ["1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0"],
         *     "output_file_name": "学习手册",
         *     "output_file_format": "pdf"
         * }
         */
        $providerToken = getProviderToken();
        $url = sprintf(self::getContactTransUrl(),$providerToken);

        $postJsonArr = new array();
        $postJson["auth_corpid"]=$corpId;

        $mediaList = new JSONArray();
        mediaList.add(mediaId);
        $postJson["media_id_list"]=$mediaList;

        return  RestUtils.post(url,postJson);

    }

    /**
     *
     * @param jobId
     * @return
     * {
     *     "errcode": 0,
     *     "errmsg": "ok",
     *     "status": 1,
     *     "type": "contact_id_translate",
     *     "result": {
     *         "contact_id_translate":{
     *             "url":"xxxx"
     *         }
     *     }
     * }
     */
    public function getTransResult($jobId){
        //https://open.work.weixin.qq.com/api/doc/90001/90143/91882
        /**
         * id
         */
        $corpToken = getProviderToken();
        $url = sprintf(self::getTransResultUrl(),$corpToken,$jobId);
        $rs = self::curlGet($url);
        rs["rs_url"]=$rl;
        return rs;

    }


    //**********************************  客户联系相关   *************************//
    //获取配置了客户联系功能的成员列表
    public function getExtContactFollowUserList($corpId){
        $corpToken = qywxThirdCompanyService.getCorpAccessToken($corpId);
        $url = sprintf(self::getExtContactFollowUserListUrl(),$corpToken) ;
        $response= self::curlGet($url);
        //获取错误日志
        if(response.containsKey("errcode") && $esponse["errcode"] != 0){
            logger.error(response.toString());
        }
        return  $response;

    }

    //获取指定成员添加的客户列表
    public function getExtContactList($corpId,$userId){

        $corpToken = qywxThirdCompanyService.getCorpAccessToken($corpId);
        $url = sprintf(self::getExtContactListUrl(),$corpToken,$userId) ;

        $response= self::curlGet($url);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"] != 0){
            logger.error(response.toString());
        }
        return  $response;

    }


    //获取配置过客户群管理的客户群列表。
    public function getExtContactGroupchatList($corpId,$userId){

        //https://open.work.weixin.qq.com/api/doc/90001/90143/93414
        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);
        $url = sprintf(self::getExtContactGroupchatUrl(),corpToken) ;

        //分页，预期请求的数据量，取值范围 1 ~ 1000  测试写死1000
        $postJsonArr = new array();
        //owner_filter  userid_list	否	用户ID列表。最多100个
        $postJson["limit"]=1000;
        $response= RestUtils.post(url,postJson);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;

    }


    //**********************************  消息相关   *************************//
    //消息推送
    //发送消息
    public function sendMessageText($corpId,$userId,$text){

        //https://open.work.weixin.qq.com/api/doc/90001/90143/93414
        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);

        $url = sprintf(self::getMessageSendUrl(),corpToken) ;
        //获取企业的agentid
        QywxThirdCompany company =  qywxThirdCompanyService.getCompanyByCorpId(corpId);
        $agentId = $company.getAgentId();

        $postJsonArr = new array();
        $postJson["msgtype"]="text";
        $postJson["agentid"]=$agentId;

        $testJson =  new JSONObject();
        $testJson["content"]=$text;
        $postJson["text"]=$testJson;

        $postJson["touser"]=$userId;
        $response= RestUtils.post(url,postJson);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;

    }

    public  $replyMessage(){

//        XStream xstream = new XStream();
//              '<xml>
//               <Encrypt><![CDATA[msg_encrypt]]></Encrypt>
//               <MsgSignature><![CDATA[msg_signature]]></MsgSignature>
//               <TimeStamp>timestamp</TimeStamp>
//               <Nonce><![CDATA[nonce]]></Nonce>
//               </xml>'
        return  "";
    }


    //**********************************  素材管理相关   *************************//
    public  byte[] downloadMedia($corpId,$mediaId){
        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);
        $mediaDownloadUrl = sprintf(self::getMediaGetUrl(),corpToken,mediaId);
        return RestUtils.dowload(mediaDownloadUrl);

    }

    //**********************************  oa审批相关   *************************//

    //审批流程引擎
    public function getApprovalFlow(){
        $approval = new HashMap();
        approval["templateId"]=self::getApprovalFlowId();
        approval["thirdNo"]=new SnowFlakeUtils(0, 0).createOrderNo());
        return approval;
    }

    public function getApprovalFlowStatus($corpId,$thirdNo){
        $corpToken = qywxThirdCompanyService.getCorpAccessToken($corpId);
        $approvalUrl = sprintf(self::getOpenApprovalDataUrl(),$corpToken);
        $postJsonArr = new array();
        $postJson["thirdNo"]=$thirdNo;
        return RestUtils.post(approvalUrl,postJson);
    }

    //**********************************  PC相关   *************************//
    //PC网页 sso  用于非企业微信环境下扫码登录，如运行在浏览的器应用后台或者脱离企业微信环境下H5应用
    //https://open.work.weixin.qq.com/wwopen/sso/3rd_qrConnect?appid=ww100000a5f2191&redirect_uri=http%3A%2F%2Fwww.oa.com&state=web_login@gyoss9&usertype=admin
    public function getSsoUrl($redirectUrl,$userType){
        $state = "test";
        $ssoUrl = sprintf(self::getSsoAuthUrl(),self::getCorpId(),$redirectUrl,$state,$userType);
        return ssoUrl;
    }

    public function getLoginInfo($authCode){

        $url = sprintf(self::getLoginInfoUrl(),getProviderToken()) ;

        $postJsonArr = new array();
        $postJson["auth_code"]=$authCode;
        $response= RestUtils.post($url,$postJson);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;

    }


    //********************************** H5应用 Oauth   *************************//
    public function getOauthUrl($url){
//        应用授权作用域。
//        snsapi_base：静默授权，可获取成员的基础信息（UserId与DeviceId）；
//        snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱等敏感信息；
//        snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱等敏感信息（已不再支持获取手机号/邮箱）。
        $scope = "snsapi_userinfo";
        $state = "sdfds343";
        $result = sprintf(self::getOauthUrl(),self::getSuiteId(),url,scope,state);
        return  $result;
    }

    public function getOauthUser($code) {

        $suiteToken = getSuiteToken();

        //获取访问用户身份

//        方法一
//        使用此url的suiteToken带了-_请求通过 java.lang.IllegalArgumentException: Not enough variable values available to expand 'suite_access_token'
//        https://blog.csdn.net/xs_challenge/article/details/109451263

//        Map<String,String> params$= new HashMap();
//        $suiteToken = "9EEq7bDkw3zQlHU6CDfBqbjFCYHYt1O6OmTfKWOEfOvDGLSq-stlraI6rkeGgTFiMhQ8wu24ivyGdTvuuOR1hETOXgSXUoNINqALHF1I4Z3BxfAuagNh_XTGFcRpXnAq";
//        paramsMap["suite_access_token",suiteToken);
//        paramsMap["code",code);
//        $response = qywxThirdHttpClient.getForObject(self::getOauthUserUrl(),Map.class,paramsMap);

//        方法二
//        $getOauthUrl = sprintf(self::getOauthUserUrl(),suiteToken,code);
//        HttpHeaders httpHeaders = new HttpHeaders();
//        //httpHeaders.set("Cookie", cookies);
//        httpHeaders.set("Content-Type", "application/json; charset=utf-8");
//        URI uri = null;
//        try {
//            uri = new URI(getOauthUrl);
//        } catch (URISyntaxException e) {
//            e.printStackTrace();
//            return null;
//        }
//        logger.info(getOauthUrl);
//        $response = qywxThirdHttpClient.exchange(URI.create(getOauthUrl), HttpMethod.GET,new HttpEntity<>(httpHeaders),Map.class).getBody();
//

        //方法三
        $getOauthUrl = sprintf(self::getOauthUserUrl(),suiteToken,code);
        $response = self::curlGet(getOauthUrl);
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
            return  $response;
        }

        $userTicket = $response["user_ticket"];
        //获取访问用户敏感信息
        $postJsonArr = new array();
        $postJson["user_ticket"]=userTicket;
        $url = sprintf(self::getOauthUserDetailUrl(),suiteToken);
        $detaiResponse = RestUtils.post(url,postJson);
        //获取错误日志
        if(detaiResponse.containsKey("errcode") && (Integer) detaiResponse["errcode") != 0){
            logger.error(detaiResponse.toString());
        }
        /**
         * {
         * 	"errcode": 0,
         * 	"errmsg": "ok",
         * 	"corpid": "wwcc3b4b831051d56e",
         * 	"userid": "LiYueXi",
         * 	"name": "LiYueXi",
         * 	"department": [1],
         * 	"gender": "1",
         * 	"avatar": "https://rescdn.qqmail.com/node/wwmng/wwmng/style/images/independent/DefaultAvatar$73ba92b5.png",
         * 	"open_userid": "woMAh2BwAApVMP0ZDYUk42tUw3CIeHFA"
         * }
         */

        return detaiResponse;

    }



    public function  getJsSignAgent($corpId,$nonce, $timestamp,  $signUrl) throws  Exception{
        //https://work.weixin.qq.com/api/doc/90001/90144/90548
        //https://work.weixin.qq.com/api/doc/90001/90144/90539#%E8%8E%B7%E5%8F%96%E5%BA%94%E7%94%A8%E7%9A%84jsapi_ticket

        //获取jsticket
        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);
        $url = sprintf(self::getJsapiTicketAgentUrl(),corpToken);
        $response = self::curlGet(url);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        $jsapiTicket = $response["ticket"];
        //通过 获取jsticket  获取签名
        $sign = QywxSHA.getSHA1(jsapiTicket,nonce,timestamp,signUrl);

        //获取appid
        QywxThirdCompany company =  qywxThirdCompanyService.getCompanyByCorpId(corpId);
        $agentId = company.getAgentId();

        Hash$result = new HashMap();
        result["corpId"]= corpId;
        result["agentId"]= agentId;
        result["timestamp"]= timestamp;
        result["nonceStr"]= nonce;
        result["signature"]= sign;
        return  $result;

    }

    //******************************  家校沟通   *********************//
    public  $getSchoolOauthUrl($url){

//        应用授权作用域。
//        snsapi_base：静默授权，可获取成员的基础信息（UserId与DeviceId）；
//        snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱等敏感信息；
//        snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱等敏感信息（已不再支持获取手机号/邮箱）。
        $scope = "snsapi_userinfo";
        $state = "sdfds343";
        $result = sprintf(self::getSchoolOauthUrl(),self::getSuiteId(),url,scope,state);
        return  $result;
    }

    public function getSchoolOauthUser($code) {

        $suiteToken = getSuiteToken();
        //获取访问用户身份
        $getOauthUrl = sprintf(self::getSchoolOauthUserUrl(),suiteToken,code);
        $response = self::curlGet(getOauthUrl);
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
            return  $response;
        }

        $detaiResponse = new HashMap();
        //家长
        if(response.containsKey("external_userid")){


            //https://work.weixin.qq.com/api/doc/90001/90143/91711

            $coprId = $response["CorpId"];
            $corpToken = qywxThirdCompanyService.getCorpAccessToken(coprId);

            $parentsArray = $response["parents"];
            if(parentsArray.size()<0){
                JsonData.buildError("无家长信息"];
            }
            $parentsMap =$parentsArray.get(0);
            $userId = $parentsMap["parent_userid"];
            //获取访问用户敏感信息
            //https://work.weixin.qq.com/api/doc/90001/90143/92038
            $url = sprintf(self::getSchoolUserGetUrl(),corpToken,userId);
             detaiResponse = self::curlGet(url);
            //获取错误日志
            if(detaiResponse.containsKey("errcode") && (Integer) detaiResponse["errcode") != 0){
                logger.error(detaiResponse.toString());
            }

        }else{
          //公司成员
            $userTicket = $response["user_ticket"];
            //获取访问用户敏感信息
            $postJsonArr = new array();
            $postJson["user_ticket"]=userTicket;
            $url = sprintf(self::getOauthUserDetailUrl(),suiteToken);
             detaiResponse = RestUtils.post(url,postJson);
            //获取错误日志
            if(detaiResponse.containsKey("errcode") && (Integer) detaiResponse["errcode") != 0){
                logger.error(detaiResponse.toString());
            }
            detaiResponse["user_type"]=0;
        }



        /**
         * 家长
         {
         "errcode": 0,
         "errmsg": "ok",
         "user_type": 1,
         "student":{
         "student_userid": "zhangsan",
         "name": "张三",
         "department": [1, 2],
         "parents":[
         {
         "parent_userid": "zhangsan_parent1",
         "relation": "爸爸",
         "mobile":"18000000000",
         "is_subscribe": 1,
         "external_userid":"xxxxx"
         },
         {
         "parent_userid": "zhangsan_parent2",
         "relation": "妈妈",
         "mobile": "18000000001",
         "is_subscribe": 0
         }
         ]
         },
         "parent":{
         "parent_userid": "zhangsan_parent2",
         "mobile": "18000000003",
         "is_subscribe": 1,
         "external_userid":"xxxxx",
         "children":[
         {
         "student_userid": "zhangsan",
         "relation": "妈妈"
         },
         {
         "student_userid": "lisi",
         "relation": "伯母"
         }
         ]
         }
         }
         */

        return detaiResponse;

    }

    public function getSchoolDepartmentList($corpId,$deptId){
        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);
        $url = sprintf(self::getSchoolDepartmentListUrl(),corpToken,deptId) ;

        $response= self::curlGet(url);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;
    }

    public function getSchoolUserList($corpId,$deptId,$fetchChild){
        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);
        $url = sprintf(self::getSchoolUserListUrl(),corpToken,deptId,fetchChild) ;

        $response= self::curlGet(url);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;

    }

    public function extContactMessageSend($corpId,$studentUserid,$text){

        $corpToken = qywxThirdCompanyService.getCorpAccessToken(corpId);
        $url = sprintf(self::getExtContactMessageSendUrl(),corpToken) ;

        //获取企业的agentid
        QywxThirdCompany company =  qywxThirdCompanyService.getCompanyByCorpId(corpId);
        $agentId = company.getAgentId();

        $postJsonArr = new array();
        $postJson["msgtype"]="text";
        $postJson["agentid"]=agentId;
        $postJson["to_student_userid"]=studentUserid;

        JSONObject testJson =  new JSONObject();
        testJson["content"]=text;
        $postJson["text"]=testJson;

        $response= RestUtils.post(url,postJson);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;

    }

    //******************************  小程序应用   *********************//
    public function getCode2sessionUser($code){
        $suiteToken = getSuiteToken();
        //获取访问用户身份
//        $params$= new HashMap();
//        paramsMap["suite_access_token",suiteToken);
//        paramsMap["code",code);
        $url = sprintf(self::getCode2sessionUrl(),suiteToken,code);
        $response = self::curlGet(url);
        //获取错误日志
        if(response.containsKey("errcode") && $response["errcode"]!= 0){
            logger.error(response.toString());
        }
        return  $response;
    }



}