<?php
namespace plugin\user\app\common\model;

use app\common\model\BaseModel;

/**
 * 用户链接权限模型
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class UserMenuModel extends BaseModel
{
    /**
     * 模型参数
     * @return array
     */
    protected function getOptions() : array
    {
        return [
            'name'               => 'user_menu',
            'autoWriteTimestamp' => true,
            'type'               => [],
            'fileField'          => [ // 包含附件的字段，''代表直接等于附件路劲，'array'代表数组中包含附件路劲，'editor'代表富文本中包含附件路劲
            ],
        ];
    }
}