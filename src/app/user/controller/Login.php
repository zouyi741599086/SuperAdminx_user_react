<?php
namespace app\user\controller;

use support\Request;
use support\Response;
use think\facade\Db;
use app\common\logic\UserLogic;
use app\common\logic\UserMenuLogic;
use app\common\model\UserModel;
use app\common\model\SmsCodeModel;
use app\utils\Sms;
use app\utils\Jwt;

/**
 * 后台登录
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class Login
{
    // 此控制器是否需要登录
    protected $onLogin = false;
    // 不需要登录的方法
    protected $noNeedLogin = [];

    /**
     * 登录
     * @method post
     * @param Request $request 
     * @return Response
     * */
    public function index(Request $request) : Response
    {
        $tel      = $request->post('tel');
        $password = $request->post('password');

        // 验证参数
        if (! $tel || ! $password) {
            return error('用户名或密码错误');
        }

        // 查询用户
        $user = UserModel::where('tel', $tel)->find();
        // 判断用户是否存在
        if (! $user || ! password_verify($password, $user['password'])) {
            return error('用户名或密码错误');
        }
        if ($user['status'] == 2) {
            return error('帐号已被锁定');
        }

        $user             = UserLogic::findData($user['id'])->toArray();
        $user['token']    = Jwt::generateToken('user_pc', $user);
        $user['UserMenu'] = UserMenuLogic::getList();
        return success($user, '登录成功');
    }

    /**
     * 忘记密码获取验证码
     * @method post
     * @param Request $request 
     * @return Response
     */
    public function getResetPasswordCode(Request $request) : Response
    {
        $params = $request->post();
        try {
            if (! isset($params['tel'])) {
                abort('参数错误');
            }

            //验证手机号格式
            Sms::checkTel($params['tel']);

            //判断此用户是否存在 是否正常
            $user = UserModel::where('tel', $params['tel'])->find();
            if (! $user || $user['status'] == 2) {
                throw new \Exception('手机号错误~');

            }

            $params['code'] = Sms::getCode(4);
            //开始发送短信
            //Sms::send($params['tel'], "您的验证码是：{$params['code']}，有效期5分钟。");

            //添加发送记录
            $params['type'] = 1;
            SmsCodeModel::create($params);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success([], "发送成功{$params['code']}");
    }

    /**
     * 重设密码
     * @method post
     * @param Request $request 
     * @return Response
     */
    public function resetPassword(Request $request) : Response
    {
        $params = $request->post();
        Db::startTrans();
        try {
            validate([
                'tel|手机号'          => 'require|mobile',
                'code|验证码'         => 'require',
                'new_password|新密码' => 'require',
            ])->check($params);

            //核销验证码
            Sms::checkCode($params['tel'], 1, $params['code']);

            //判断此用户是否存在 是否正常
            $user = UserModel::where('tel', $params['tel'])->find();
            if (! $user || $user['status'] == 2) {
                throw new \Exception('手机号错误~');
            }

            //开始修改
            UserModel::update([
                'id'       => $user['id'],
                'password' => $params['new_password'],
            ]);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return error($e->getMessage());
        }
        return success([], '修改成功~');
    }
}
