import { useState } from 'react'
import loginLogin from '@/static/login-logo.png'
import loginMain from '@/static/login-main.png'
import { App, Card, Typography, Button, Form, Input, Checkbox, Flex } from 'antd';
import { LockOutlined, MobileOutlined } from '@ant-design/icons';
import { storage } from '@/common/function'
import { loginApi } from '@/api/login'
import { useNavigate } from "react-router-dom";
import { useRecoilState } from 'recoil';
import { userStore } from '@/store/user';
import { menuAuthStore } from '@/store/menuAuth';
import { loginAction } from '@/common/loginAction';
import { config } from '@/common/config'
import ResetPassword from './resetPassword';
import './index.css'

const { Title } = Typography;

/**
 * 后台登录页面
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 */
export default () => {
    const [user, setUser] = useRecoilState(userStore);
    const [menuAuth, setMenuAuth] = useRecoilState(menuAuthStore);
    const [loading, setLoading] = useState(false);
    const { message } = App.useApp();
    const navigate = useNavigate();
    const [stay_login, set_stay_login] = useState(false);

    // 设置网页标题
    document.title = `${config.projectName}-登录`;

    const onFinish = (values) => {
        setLoading(true);
        loginApi.login(values).then((res) => {
            setLoading(false);
            if (res.code !== 1) {
                message.error(res.message);
            }
            if (res.code === 1) {
                message.success(res.message);
                loginAction(res.data, setUser, setMenuAuth);
                // 设置登录标识
                if (stay_login === true) {
                    // 保存登录状态
                    storage.set(`userToken`, res.data.token);
                } else {
                    // 非保持登录状态
                    sessionStorage.setItem(`userToken`, res.data.token);
                }
                navigate('/index');
            }
        }).catch(err => {
            setLoading(false);
        });
    };

    return <>
        <div className="login-logo">
            <div className="m">
                <a href="/">
                    <img src={loginLogin} alt="" />
                </a>
            </div>
        </div>
        <div className="login">
            <div className="login-l">
                <img src={loginMain} alt="" />
            </div>
            <div className="login-r">
                <Card className="card-form" variant="outlined">
                    <Title
                        level={4}
                        style={{
                            textAlign: 'center',
                            marginBottom: '50px',
                            marginTop: '20px'
                        }}
                    >{config.projectName}</Title>
                    <Form
                        name="login_form"
                        onFinish={onFinish}
                    >
                        <Form.Item
                            name="tel"
                            rules={[
                                { required: true, message: '请输入手机号' },
                                { pattern: /^1[3456789]\d{9}$/, message: '请输入正确的手机号' },
                            ]}
                        >
                            <Input
                                prefix={<MobileOutlined />}
                                placeholder="请输入手机号"
                                size="large"
                            />
                        </Form.Item>
                        <Form.Item
                            name="password"
                            rules={[
                                { required: true, message: '请输入登录密码' }
                            ]}
                        >
                            <Input
                                prefix={<LockOutlined />}
                                type="password"
                                placeholder="请输入登录密码"
                                size="large"
                            />
                        </Form.Item>
                        <Form.Item>
                            <Flex justify="space-between" align="flex-start">
                                <Checkbox checked={stay_login} onChange={(e) => {
                                    set_stay_login(e.target.checked);
                                }}>保持登录状态</Checkbox>
                                <ResetPassword />
                            </Flex>
                        </Form.Item>

                        <Form.Item>
                            <Button
                                type="primary"
                                htmlType="submit"
                                size="large"
                                block
                                loading={loading}
                                style={{ borderRadius: '20px' }}
                            >立即登录</Button>
                        </Form.Item>
                    </Form>
                </Card>
            </div>
        </div>
        <div className="ft">Copyright © {(new Date()).getFullYear()} {config.company} 版权所有 <a href="https://beian.miit.gov.cn/" target="_blank">{config.icp}</a></div>
    </>
}
