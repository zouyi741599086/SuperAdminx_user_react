<?php
namespace app\user\controller;

use support\Request;
use support\Response;
use app\common\logic\UserLogic;
use app\common\logic\UserMenuLogic;
use app\common\model\UserModel;

/**
 * 用户
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class User
{
    // 此控制器是否需要登录
    protected $onLogin = true;
    //不需要登录的方法
    protected $noNeedLogin = [];

    /**
     * 获取自己的资料
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getUser(Request $request) : Response
    {
        $data             = UserLogic::findData($request->user->id);
        $user['UserMenu'] = UserMenuLogic::getList();
        return success($data);
    }

    /**
     * @log 修改自己的资料
     * @method post
     * @param Request $request 
     * @return Response
     */
    public function updateInfo(Request $request) : Response
    {
        $params = $request->post();
        try {
            validate([
                'name|姓名' => 'require',
                'tel|手机号' => 'require|mobile',
            ])->check($params);

            // 手机号是否重复
            if (UserModel::where('id', '<>', $request->user->id)->where('tel', $params['tel'])->value('id')) {
                throw new \Exception("此手机号已存在~");
            }

            UserModel::update($params, ['id' => $request->user->id], ['img', 'name', 'tel']);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success([], '修改成功');
    }

    /**
     * @log 修改自己的登录密码
     * @method post
     * @param Request $request 
     * @return Response
     */
    public function updatePassword(Request $request) : Response
    {
        $params = $request->post();
        $userId = $request->user->id;
        try {
            validate([
                'password|原密码'            => 'require',
                'new_password|新密码'        => 'require|min:6',
                'confirm_password|再次输入密码' => 'require|min:6|confirm:new_password',
            ])->check($params);

            // 判断原密码是否正确
            $oldPassword = UserModel::where('id', $userId)->value('password');
            if (! password_verify($params['password'], $oldPassword)) {
                throw new \Exception("原密码错误");
            }
            UserModel::update([
                'id'       => $userId,
                'password' => $params['new_password']
            ]);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success([], '修改成功，请重新登录');
    }
}
