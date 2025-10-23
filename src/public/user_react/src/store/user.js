import { proxy } from 'valtio';
import { storage } from '@/common/function';

const storeKey = 'user';
// 默认值
const defaultValue = {};

/**
 * 保存登录者的信息
 * 
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 */
export const userStore = proxy(
    storage.get(storeKey) || defaultValue
)

/**
 * 更新状态
 * 
 * @param {object|function} updater 
 */
export const setUserStore = (updater) => {
    if (typeof updater === 'function') {
        // 函数式更新
        const newState = updater(userStore);
        Object.assign(userStore, newState);
    } else {
        // 直接对象赋值
        Object.assign(userStore, updater);
    }
    // 持久化到存储
    storage.set(storeKey, userStore);
}