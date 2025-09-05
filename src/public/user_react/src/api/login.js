import { http } from '@/common/axios.js'

/**
 * 管理员 API
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
export const loginApi = {
    // 登录
    login: (params = {}) => {
        return http.post('/app/user/user/Login/index', params);
    },
    // 忘记密码获取验证码
    getResetPasswordCode: (params = {}) => {
        return http.post('/app/user/user/Login/getResetPasswordCode', params);
    },
    // 忘记密码提交
    resetPassword: (params = {}) => {
        return http.post('/app/user/user/Login/resetPassword', params);
    },
}