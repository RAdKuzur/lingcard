import axios from "axios";
import { apiRoutes } from "./apiRoutes.js";
import {innerRoutes} from "./routes.js";

// Создаем экземпляр axios с базовыми настройками
const api = axios.create({
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
    },
});

// Переменные для предотвращения множественных рефрешей
let isRefreshing = false;
let failedQueue = [];

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

// Добавляем токен в заголовки, если он есть
api.interceptors.request.use(config => {
    const token = localStorage.getItem('accessToken');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Перехватчик для обновления токена
api.interceptors.response.use(
    response => response,
    async error => {
        const originalRequest = error.config;

        // Если не 401 или запрос уже повторялся - отклоняем
        if (error.response?.status !== 401 || originalRequest._retry) {
            return Promise.reject(error);
        }

        // Если идет процесс обновления - добавляем в очередь
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
            // Обновляем токен
            const refreshResponse = await api.post(apiRoutes.refresh, null);

            // Сохраняем новый токен (если сервер возвращает его в теле)
            const newToken = refreshResponse.data?.accessToken || refreshResponse.data?.token;
            if (newToken) {
                localStorage.setItem('accessToken', newToken);
            }

            // Обрабатываем очередь
            processQueue(null, newToken);

            // Повторяем исходный запрос
            return api(originalRequest);
        } catch (refreshError) {
            // Если рефреш не удался - очищаем токен и редиректим
            localStorage.removeItem('access_token');
            localStorage.removeItem('refresh_token');
            localStorage.removeItem('role');
            localStorage.removeItem('username');
            processQueue(refreshError, null);

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
            params: params // Правильная передача параметров
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