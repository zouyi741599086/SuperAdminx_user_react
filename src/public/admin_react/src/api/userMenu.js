import { http } from '@/common/axios.js'

/**
 * 后台菜单 API
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
export const userMenuApi = {
    // 获取列表
    getList: (params = {}) => {
        return http.get('/admin/UserMenu/getList', params);
    },
    // 添加
    create: (params = {}) => {
        return http.post('/admin/UserMenu/create', params);
    },
    // 获取某条数据
    findData: (params = {}) => {
        return http.get('/admin/UserMenu/findData', params);
    },
    // 修改
    update: (params = {}) => {
        return http.post('/admin/UserMenu/update', params);
    },
    // 删除
    delete: (params = {}) => {
        return http.post('/admin/UserMenu/delete', params);
    },
}