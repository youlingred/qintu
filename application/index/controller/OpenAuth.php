<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
use org\ThinkOauth;

/**
 * 第三方登录
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class OpenAuth extends Base
{
    /**
     * 统一登录方法
     * @author tangtanglove
     */
	public function login($type = null){

        if (empty($type)) {
            return $this->error('参数错误');
        }
        if ($type == 'wechat') {
            // 生成一个token
            $state = md5(time());
            // 储存token
            session('state',$state);
			$config = config('think_sdk_wechat');
            $wechatUrl = 'https://open.weixin.qq.com/connect/qrconnect?appid='.$config['app_id']
            .'&redirect_uri='.$config['callback']
            .'&response_type=code&scope=snsapi_login&state='.$state
            .'#wechat_redirect';

            return $this->redirect($wechatUrl);
        } else {

            //加载ThinkOauth类并实例化一个对象
            import('org.util.thinksdk.ThinkOauth');
            $sns  = ThinkOauth::getInstance($type);

            //跳转到授权页面
            return $this->redirect($sns->getRequestCodeURL());
        }

	}

    /**
     * 授权回调
     * @author tangtanglove
     */
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误');
		
		//加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$sns  = ThinkOauth::getInstance($type);

		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => input('openid'), 'openkey' => input('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);
		//获取当前登录用户信息
		if(is_array($token)){
			//$user_info = $this->$type($token);
            $openAuthInfo = call_user_func_array(array($this,$type), array($token));
			// echo("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
			// echo("授权信息为：<br>");
			// dump($token);
			// echo("当前登录用户信息为：<br>");
			// dump($openAuthInfo);

            if (empty($openAuthInfo)) {
                return $this->error('错误！');
            }

            $where[$type.'_openid'] = $token['openid'];
            $userInfo = Db::name('Users')->where($where)->find();
            if (!empty($userInfo) && $userInfo['status']!=1) {
                return $this->error('用户被禁用！');
            }

            if (!empty($userInfo)) {
                $session['uid']       = $userInfo['id'];
                $session['username']  = $userInfo['username'];
                $session['nickname']  = $userInfo['nickname'];
                $session['mobile']    = $userInfo['mobile'];
                $session['last_login']= $userInfo['last_login'];                                            
                // 记录用户登录信息
                session('index_user_auth',$session);
                return $this->success('登陆成功！',url('index/user/userCenter'));
            } else {
                $data[$type.'_openid']  = $token['openid'];
                $data['nickname']       = $openAuthInfo['nick'];
                $data['uuid']           = create_uuid();
                $data['salt']           = create_salt();
                $data['regdate']        = time();
                $data['last_login']     = $data['regdate'];
                $data['status']         = '1';
                $result = Db::name('Users')->insert($data);
                if ($result) {
                    $openid = $result['openid'];
                    $session['uid']       = Db::getLastInsID();
                    $session['nickname']  = $openAuthInfo['nick'];
                    $session['last_login']= $userInfo['last_login'];
                    // 记录用户登录信息
                    session('index_user_auth',$session);
                    return $this->success('登陆成功！',url('index/user/userCenter'));
                } else {
                    return $this->error('错误！');
                }
            }
		}
	}

    /**
     * 微信登录
     * @author tangtanglove
     */
    public function wechat()
    {
        $state = input('get.state');
        if ($state != session('state')) {
            return $this->error('授权出错！');
        }
		$config = config('think_sdk_wechat');
        $response_type = input('get.response_type');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$config['app_id'].'&secret='.$config['app_secret'].'&code='.$response_type.'&grant_type=authorization_code';
        $result = json_decode(httpMethod($url));
        $openid       = $result['openid'];
        $access_token = $result['access_token'];

        // 获取用户信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid;
        $wechatInfo = json_decode(httpMethod($url));

        if (empty($wechatInfo['openid'])) {
            return $this->error('错误！');
        }

        if (empty($openid)) {
            return $this->error('错误！');
        }

        $where['openid'] = $openid;
        $userInfo = Db::name('Users')->where($where)->find();
        if (!empty($userInfo) && $userInfo['status']!=1) {
            return $this->error('用户被禁用！');
        }

        if (!empty($userInfo)) {
            $session['uid']       = $userInfo['id'];
            $session['username']  = $userInfo['username'];
            $session['nickname']  = $userInfo['nickname'];
            $session['mobile']    = $userInfo['mobile'];
            $session['last_login']= $userInfo['last_login'];                                            
            // 记录用户登录信息
            session('index_user_auth',$session);
            return $this->success('登陆成功！',url('index/user/userCenter'));
        } else {
            $data['openid']         = $openid;
            $data['nickname']       = $wechatInfo['nickname'];
            $data['uuid']           = create_uuid();
            $data['salt']           = create_salt();
            $data['regdate']        = time();
            $data['last_login']     = $data['regdate'];
            $data['status']         = '1';
            $result = Db::name('Users')->insert($data);
            if ($result) {
                $openid = $result['openid'];
                $session['uid']       = Db::getLastInsID();
                $session['nickname']  = $wechatInfo['nickname'];
                $session['last_login']= $userInfo['last_login'];
                // 记录用户登录信息
                session('index_user_auth',$session);
                return $this->success('登陆成功！',url('index/user/userCenter'));
            } else {
                return $this->error('错误！');
            }
        }
    }

	//登录成功，获取腾讯QQ用户信息
	public function qq($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$qq   = ThinkOauth::getInstance('qq', $token);
		$data = $qq->call('user/get_user_info');
		if($data['ret'] == 0){
			$userInfo['type'] = 'QQ';
			$userInfo['name'] = $data['nickname'];
			$userInfo['nick'] = $data['nickname'];
			$userInfo['head'] = $data['figureurl_2'];
			return $userInfo;
		} else {
			throw_exception("获取腾讯QQ用户信息失败：{$data['msg']}");
		}
	}

	//登录成功，获取腾讯微博用户信息
	public function tencent($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$tencent = ThinkOauth::getInstance('tencent', $token);
		$data    = $tencent->call('user/info');

		if($data['ret'] == 0){
			$userInfo['type'] = 'TENCENT';
			$userInfo['name'] = $data['data']['name'];
			$userInfo['nick'] = $data['data']['nick'];
			$userInfo['head'] = $data['data']['head'];
			return $userInfo;
		} else {
			throw_exception("获取腾讯微博用户信息失败：{$data['msg']}");
		}
	}

	//登录成功，获取新浪微博用户信息
	public function sina($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$sina = ThinkOauth::getInstance('sina', $token);
		$data = $sina->call('users/show', "uid={$sina->openid()}");

		if($data['error_code'] == 0){
			$userInfo['type'] = 'SINA';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['screen_name'];
			$userInfo['head'] = $data['avatar_large'];
			return $userInfo;
		} else {
			throw_exception("获取新浪微博用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取网易微博用户信息
	public function t163($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$t163 = ThinkOauth::getInstance('t163', $token);
		$data = $t163->call('users/show');

		if($data['error_code'] == 0){
			$userInfo['type'] = 'T163';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['screen_name'];
			$userInfo['head'] = str_replace('w=48&h=48', 'w=180&h=180', $data['profile_image_url']);
			return $userInfo;
		} else {
			throw_exception("获取网易微博用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取人人网用户信息
	public function renren($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$renren = ThinkOauth::getInstance('renren', $token);
		$data   = $renren->call('user/get');

		if(!isset($data['error'])){
			$userInfo['type'] = 'RENREN';
			$userInfo['name'] = $data['response']['name'];
			$userInfo['nick'] = $data['response']['name'];
			$userInfo['head'] = $data['response']['avatar'][3]['url'];
			return $userInfo;
		} else {
			throw_exception("获取人人网用户信息失败：{$data['error_msg']}");
		}
	}

	//登录成功，获取360用户信息
	public function x360($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$x360 = ThinkOauth::getInstance('x360', $token);
		$data = $x360->call('user/me');

		if($data['error_code'] == 0){
			$userInfo['type'] = 'X360';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['avatar'];
			return $userInfo;
		} else {
			throw_exception("获取360用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取豆瓣用户信息
	public function douban($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$douban = ThinkOauth::getInstance('douban', $token);
		$data   = $douban->call('user/~me');

		if(empty($data['code'])){
			$userInfo['type'] = 'DOUBAN';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['avatar'];
			return $userInfo;
		} else {
			throw_exception("获取豆瓣用户信息失败：{$data['msg']}");
		}
	}

	//登录成功，获取Github用户信息
	public function github($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$github = ThinkOauth::getInstance('github', $token);
		$data   = $github->call('user');

		if(empty($data['code'])){
			$userInfo['type'] = 'GITHUB';
			$userInfo['name'] = $data['login'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['avatar_url'];
			return $userInfo;
		} else {
			throw_exception("获取Github用户信息失败：{$data}");
		}
	}

	//登录成功，获取Google用户信息
	public function google($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$google = ThinkOauth::getInstance('google', $token);
		$data   = $google->call('userinfo');

		if(!empty($data['id'])){
			$userInfo['type'] = 'GOOGLE';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['picture'];
			return $userInfo;
		} else {
			throw_exception("获取Google用户信息失败：{$data}");
		}
	}

	//登录成功，获取Google用户信息
	public function msn($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$msn  = ThinkOauth::getInstance('msn', $token);
		$data = $msn->call('me');

		if(!empty($data['id'])){
			$userInfo['type'] = 'MSN';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = '微软暂未提供头像URL，请通过 me/picture 接口下载';
			return $userInfo;
		} else {
			throw_exception("获取msn用户信息失败：{$data}");
		}
	}

	//登录成功，获取点点用户信息
	public function diandian($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$diandian  = ThinkOauth::getInstance('diandian', $token);
		$data      = $diandian->call('user/info');

		if(!empty($data['meta']['status']) && $data['meta']['status'] == 200){
			$userInfo['type'] = 'DIANDIAN';
			$userInfo['name'] = $data['response']['name'];
			$userInfo['nick'] = $data['response']['name'];
			$userInfo['head'] = "https://api.diandian.com/v1/blog/{$data['response']['blogs'][0]['blogUuid']}/avatar/144";
			return $userInfo;
		} else {
			throw_exception("获取点点用户信息失败：{$data}");
		}
	}

	//登录成功，获取淘宝网用户信息
	public function taobao($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$taobao = ThinkOauth::getInstance('taobao', $token);
		$fields = 'user_id,nick,sex,buyer_credit,avatar,has_shop,vip_info';
		$data   = $taobao->call('taobao.user.buyer.get', "fields={$fields}");
		
		if(!empty($data['user_buyer_get_response']['user'])){
			$user = $data['user_buyer_get_response']['user'];
			$userInfo['type'] = 'TAOBAO';
			$userInfo['name'] = $user['user_id'];
			$userInfo['nick'] = $user['nick'];
			$userInfo['head'] = $user['avatar'];
			return $userInfo;
		} else {
			throw_exception("获取淘宝网用户信息失败：{$data['error_response']['msg']}");
		}
	}
	
	//登录成功，获取百度用户信息
	public function baidu($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$baidu = ThinkOauth::getInstance('baidu', $token);
		$data  = $baidu->call('passport/users/getLoggedInUser');
		
		if(!empty($data['uid'])){
			$userInfo['type'] = 'BAIDU';
			$userInfo['name'] = $data['uid'];
			$userInfo['nick'] = $data['uname'];
			$userInfo['head'] = "http://tb.himg.baidu.com/sys/portrait/item/{$data['portrait']}";
			return $userInfo;
		} else {
			throw_exception("获取百度用户信息失败：{$data['error_msg']}");
		}
	}

	//登录成功，获取开心网用户信息
	public function kaixin($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$kaixin = ThinkOauth::getInstance('kaixin', $token);
		$data   = $kaixin->call('users/me');
		
		if(!empty($data['uid'])){
			$userInfo['type'] = 'KAIXIN';
			$userInfo['name'] = $data['uid'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['logo50'];
			return $userInfo;
		} else {
			throw_exception("获取开心网用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取搜狐用户信息
	public function sohu($token){
        //加载ThinkOauth类并实例化一个对象
        import('org.util.thinksdk.ThinkOauth');
		$sohu = ThinkOauth::getInstance('sohu', $token);
		$data = $sohu->call('i/prv/1/user/get-basic-info');
		
		if('success' == $data['message'] && !empty($data['data'])){
			$userInfo['type'] = 'SOHU';
			$userInfo['name'] = $data['data']['open_id'];
			$userInfo['nick'] = $data['data']['nick'];
			$userInfo['head'] = $data['data']['icon'];
			return $userInfo;
		} else {
			throw_exception("获取搜狐用户信息失败：{$data['message']}");
		}
	}

}
