import { http } from '@/common/axios.js'
import { config } from '@/common/config';

/**
 * 文件上传 API
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
export const fileApi = {
    // 上传图片等
    upload: (params = {}) => {
        return http.upload('/user/File/upload', params);
    },
    // 返回上传文件的url
    uploadUrl: `${config.url}/user/File/upload`,
    // 返回下载文件的url
    download: `${config.url}/user/File/download`,

    // 获取阿里云oss 前端直传的签名
    getSignature: (params = {}) => {
        return http.get('/user/File/getSignature', params);
    },
}