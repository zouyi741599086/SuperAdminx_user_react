<?php
namespace plugin\user\app\common\logic;

use plugin\user\app\common\model\UserMenuModel;
use plugin\user\app\common\validate\UserMenuValidate;
use support\think\Db;

/**
 * 用户链接权限模型
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class UserMenuLogic
{

    /**
     * 获取所有权限节点
     */
    public static function getList()
    {
        return UserMenuModel::order('sort asc,id desc')->select();
    }

    /**
     * 添加权限节点
     * @param array $params 
     */
    public static function create(array $params)
    {
        Db::startTrans();
        try {
            validate(UserMenuValidate::class)->check($params);

            $result = UserMenuModel::create($params);
            // 找出我的路劲
            if (isset($params['pid_name']) && $params['pid_name']) {
                $pid_name_path = UserMenuModel::where('name', $params['pid_name'])->value('pid_name_path');
                $pid_name_path = "{$pid_name_path}{$result->name},";
            } else {
                $pid_name_path = ",{$result->name},";
            }
            // 更新路劲
            UserMenuModel::update([
                'id'            => $result->id,
                'pid_name_path' => $pid_name_path
            ]);

            // 自动生成菜单下面的权限节点
            if (isset($params['auto_auth']) && $params['auto_auth']) {
                // 只浏览数据
                if (in_array('GetList', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '只浏览数据',
                        'name'     => "{$params['name']}GetList",
                        'sort'     => 0,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    self::create($tmp);
                }
                // 新增
                if (in_array('Create', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '添加',
                        'name'     => "{$params['name']}Create",
                        'sort'     => 1,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    // 如果是新页面打开
                    if (isset($params['auto_auth_create_update_type']) && $params['auto_auth_create_update_type'] == 2) {
                        $tmp['type']           = 2;
                        $tmp['path']           = "{$params['path']}/create";
                        $tmp['component_path'] = "{$params['path']}/create";
                        $tmp['is_params']      = 1;
                    }
                    self::create($tmp);
                }
                // 修改
                if (in_array('Update', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '修改',
                        'name'     => "{$params['name']}Update",
                        'sort'     => 2,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    // 如果是新页面打开
                    if (isset($params['auto_auth_create_update_type']) && $params['auto_auth_create_update_type'] == 2) {
                        $tmp['type']           = 2;
                        $tmp['path']           = "{$params['path']}/update";
                        $tmp['component_path'] = "{$params['path']}/update";
                        $tmp['is_params']      = 2;
                    }
                    self::create($tmp);
                }
                // 查看详情
                if (in_array('Info', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '查看详情',
                        'name'     => "{$params['name']}Info",
                        'sort'     => 3,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    // 如果是新页面打开
                    if (isset($params['auto_auth_info_type']) && $params['auto_auth_info_type'] == 2) {
                        $tmp['type']           = 2;
                        $tmp['path']           = "{$params['path']}/info";
                        $tmp['component_path'] = "{$params['path']}/info";
                        $tmp['is_params']      = 2;
                    }
                    self::create($tmp);
                }
                // 删除
                if (in_array('Delete', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '删除',
                        'name'     => "{$params['name']}Delete",
                        'sort'     => 4,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    self::create($tmp);
                }
                // 修改排序
                if (in_array('UpdateSort', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '修改排序',
                        'name'     => "{$params['name']}UpdateSort",
                        'sort'     => 5,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    self::create($tmp);
                }
                // 修改状态
                if (in_array('UpdateStatus', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '修改状态',
                        'name'     => "{$params['name']}UpdateStatus",
                        'sort'     => 6,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    self::create($tmp);
                }
                // 导出数据
                if (in_array('ExportData', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '导出数据',
                        'name'     => "{$params['name']}ExportData",
                        'sort'     => 7,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    self::create($tmp);
                }
                // 导入数据
                if (in_array('ImportData', $params['auto_auth'])) {
                    $tmp = [
                        'title'    => '导出数据',
                        'name'     => "{$params['name']}ImportData",
                        'sort'     => 8,
                        'type'     => 6,
                        'pid_name' => $params['name'],
                    ];
                    self::create($tmp);
                }
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            abort($e->getMessage());
        }
    }

    /**
     * 修改权限节点
     * @param array $params
     */
    public static function update(array $params)
    {
        // 由于前段form会把字段等于null的干掉，所以这要特别加上
        if (! isset($params['pid_name']) || ! $params['pid_name']) {
            $params['pid_name'] = null;
        }
        try {
            validate(UserMenuValidate::class)->check($params);

            // 原来旧的name
            $oldName = UserMenuModel::where('id', $params['id'])->value('name');

            UserMenuModel::update($params);
            UserMenuModel::where('pid_name', $oldName)->update([
                'pid_name' => $params['name'],
            ]);

            // 重新更新我下面所有数据的pid_path相关字段
            UserMenuModel::where('pid_name_path', 'like', "%,{$oldName},%")
                ->orderRaw("CHAR_LENGTH(pid_name_path) asc")
                ->field('id,name,pid_name,pid_name_path')
                ->select()
                ->each(function ($item)
                {
                    if ($item['pid_name']) {
                        $pid_data              = UserMenuModel::where('name', $item['pid_name'])->field('id,pid_name_path')->find();
                        $item['pid_name_path'] = "{$pid_data['pid_name_path']}{$item['name']},";
                    } else {
                        $item['pid_name_path'] = ",{$item['name']},";
                    }
                    $item->save();
                });
        } catch (\Exception $e) {
            abort($e->getMessage());
        }
    }

    /**
     * 获取一条数据
     * @param int $id
     */
    public static function findData(int $id)
    {
        return UserMenuModel::find($id);
    }

    /**
     * 删除权限节点
     * @param array $ids
     */
    public static function delete(array $ids)
    {
        foreach ($ids as $id) {
            UserMenuModel::destroy($id);
        }
    }
}