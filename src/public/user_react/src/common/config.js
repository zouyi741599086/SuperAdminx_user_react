export const config = {
    // 是否开启debug
    debug: import.meta.env.VITE_APP_DEBUG === 'true' ? true : false,
    // 项目的url
    url: import.meta.env.VITE_APP_BASE_URL,
    // 项目名称，显示登录页及登录后左上角
    projectName: 'SuperAdminx用户端',
    // 公司名称，显示在页脚
    company: 'SuperAdminx',
    icp: '渝ICP备xxxxxxxxxx号',
    // 存储本地数据前缀，存在本地的所有数据都有此前缀
    storageDbPrefix: 'userDb',
    // api请求数据加密，需要跟后端的开关对应
    api_encryptor: {
        // 开关
        enable: import.meta.env.VITE_APP_DEBUG === 'true' ? false : true,
        rsa_public: `-----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvk5vRf/L7THoMQ9woCWh
    dy21h61/kUZi9kfOvbw3KNV58I0061Z/8i4KmteNHs8H4nS6zc9AmrkNtfvAQ+dw
    CZ7MPM+NI4TsrrfFizvtoAbOxk/EcicIKwuP5ROeao3WeWrBPXibuvJkrs8YOOPX
    RQge2lbLPbvRaUXQNVgsrrRtPLlbEfMFgWl0ltbLOa69PiNKXdebjWOEZ6Wf+rR2
    rt9/gJucdeUln5wAxJvlFhWjt/LbQ1pg20B25JIaV/Bi7GCDztFIa13NFbBqOvgk
    eo0P8VOaDPy0LYs81QvofzmxcuiQnUsSNbrI6KH9QhZjTqlsT8mFLPQCeHP9S/S3
    LQIDAQAB
    -----END PUBLIC KEY-----`,
    },
    // 腾讯地图apiKey，form里面的的腾讯经纬度字段组件需要使用
    tencentApiKey: '',
    uploadImgMax: 10, // 图片最大上传xx兆
    uploadFileMax: 100, // 文件最大上传xx兆
    uploadMediaMax: 500, // 媒体最大上传xx兆
};