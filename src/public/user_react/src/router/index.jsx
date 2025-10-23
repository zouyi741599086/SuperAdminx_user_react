import { lazy } from 'react';
import { Navigate } from "react-router-dom";
import { storage } from '@/common/function';
import { useSnapshot } from 'valtio';
import { userStore, setUserStore } from '@/store/user';

const Login = lazy(() => import('@/pages/login/index'));
const Layout = lazy(() => import('@/pages/layout/index'));
const Error = lazy(() => import('@/pages/error/index'));
const Refresh = lazy(() => import('@/pages/refresh/index'));

// 鉴权
const RequireAuth = (props) => {
    const user = useSnapshot(userStore);
    let userToken = storage.get(`userToken`) || sessionStorage.getItem(`userToken`) || null;
	return <>
        {!user?.id || !userToken ? <Navigate to="/login" replace={true} /> : <Layout /> }
    </>
}

/**
 * 默认的路由
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 */
export const router = [
    {
        path: '/login',
        element: <Login />,
        title: '登录',
    },
    {
        path: '/',
        element: <RequireAuth />,
        title: '首页',
        children: [
            {
                path: '/',
                element: <Navigate to="/index" />,
                title: '首页',
            },
            {
                path: '/refresh',
                element: <Refresh />,
                title: '刷新',
            },
            {
                path: '*',
                element: <Error />,
                title: '404',
            },
        ]
    },
];
