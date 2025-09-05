import { http } from '@/common/axios.js'

/**
 * 管理员 API
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
export const userApi = {
	// 获取用户的资料
    getUser: (params = {}) => {
        return http.get('/app/user/user/User/getUser', params);
    },
    // 修改用户的资料
    updateInfo: (params = {}) => {
        return http.post('/app/user/user/User/updateInfo', params);
    },
	// 登录的用户修改密码
    updatePassword: (params = {}) => {
        return http.post('/app/user/user/User/updatePassword', params);
    },
}