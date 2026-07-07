import axios from "axios";
import { apiRoutes } from "./apiRoutes.js";
import {innerRoutes} from "./routes.js";

// Создаем экземпляр axios с базовыми настройками
const api = axios.create({
    withCredentials: true, // ✅ Автоматически отправляет cookies
    headers: {
        'Content-Type': 'application/json',
    },
});

// Переменные для предотвращения множественных рефрешей
let isRefreshing = false;
let failedQueue = [];
let isRefreshingFailed = false;

const processQueue = (error, token = null) => {
    failedQueue.forEach(prom => {
        if (error) {
            prom.reject(error);
        } else {
            prom.resolve(token);
        }
    });
    failedQueue = [];
};

// ✅ Просто проверяем, что это не запрос на refresh
api.interceptors.request.use(config => {
    // Если это запрос на refresh - пропускаем без изменений
    if (config.url === apiRoutes.refresh) {
        return config;
    }
    // Токены уже в cookies, ничего не добавляем
    return config;
}, error => Promise.reject(error));

// Перехватчик для обновления токена
api.interceptors.response.use(
    response => response,
    async error => {
        const originalRequest = error.config;
        if (!error.response) {
            console.error('Network error or no response');
            return Promise.reject(error);
        }

        // Если это запрос на refresh
        if (originalRequest.url === apiRoutes.refresh) {
            if (error.response?.status === 401) {
                console.log('Refresh token invalid, redirecting to login');
                // Очищаем только то, что хранится в localStorage
                localStorage.removeItem('role');
                localStorage.removeItem('username');
                window.location.href = innerRoutes.login;
            }
            return Promise.reject(error);
        }

        // Если не 401 или уже был повтор
        if (error.response?.status !== 401 || originalRequest._retry) {
            return Promise.reject(error);
        }

        // Защита от бесконечного редиректа
        if (isRefreshingFailed) {
            localStorage.removeItem('role');
            localStorage.removeItem('username');
            window.location.href = innerRoutes.login;
            return Promise.reject(error);
        }

        // Если идет процесс рефреша - добавляем в очередь
        if (isRefreshing) {
            return new Promise((resolve, reject) => {
                failedQueue.push({ resolve, reject });
            })
                .then(() => api(originalRequest))
                .catch(err => Promise.reject(err));
        }

        originalRequest._retry = true;
        isRefreshing = true;

        try {
            // ✅ Отправляем refresh-запрос
            const refreshResponse = await axios.post(
                apiRoutes.refresh,
                {}, // Пустое тело, так как refresh токен в cookies
                {
                    withCredentials: true, // ✅ Важно!
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }
            );

            // ✅ Проверяем успешность ответа
            if (refreshResponse.status === 200) {
                console.log('Token refreshed successfully');
            } else {
                throw new Error('Refresh failed with status: ' + refreshResponse.status);
            }

            // Сбрасываем флаг ошибки
            isRefreshingFailed = false;

            // Обрабатываем очередь
            processQueue(null);

            // Повторяем исходный запрос (cookies обновились автоматически)
            return api(originalRequest);
        } catch (refreshError) {
            console.error('Refresh failed:', refreshError);

            // Помечаем, что refresh упал
            isRefreshingFailed = true;

            // Очищаем localStorage
            localStorage.removeItem('role');
            localStorage.removeItem('username');

            // Отклоняем все запросы в очереди
            processQueue(refreshError);

            // Редирект на логин
            window.location.href = innerRoutes.login;

            return Promise.reject(refreshError);
        } finally {
            isRefreshing = false;
        }
    }
);

// --- Экспортируемые функции ---
export async function get(url, params = {}, config = {}) {
    try {
        const response = await api.get(url, {
            ...config,
            params: params
        });
        return response.data;
    } catch (error) {
        console.error('GET request failed:', error.message);
        throw error;
    }
}

export async function post(url, data = {}, config = {}) {
    try {
        const response = await api.post(url, data, config);
        return response.data;
    } catch (error) {
        console.error('POST request failed:', error.message);
        throw error;
    }
}

export async function put(url, data = {}, config = {}) {
    try {
        const response = await api.put(url, data, config);
        return response.data;
    } catch (error) {
        console.error('PUT request failed:', error.message);
        throw error;
    }
}

export async function patch(url, data = {}, config = {}) {
    try {
        const response = await api.patch(url, data, config);
        return response.data;
    } catch (error) {
        console.error('PATCH request failed:', error.message);
        throw error;
    }
}

export async function del(url, config = {}) {
    try {
        const response = await api.delete(url, config);
        return response.data;
    } catch (error) {
        console.error('DELETE request failed:', error.message);
        throw error;
    }
}

export default api;