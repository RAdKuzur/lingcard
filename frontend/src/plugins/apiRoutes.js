export const apiUrl =  import.meta.env.VITE_BACKEND_URL;
export const apiRoutes = {
    csrf: apiUrl + '/csrf-cookie',
    login: apiUrl + '/login',
    logout: apiUrl + '/logout',
    register: apiUrl + '/register',
    refresh: apiUrl + '/refresh',
    languages: apiUrl + '/languages',
    profile: apiUrl + '/profile',
    progress: apiUrl + '/progress',
    training: apiUrl + '/training',
    teachable: apiUrl + '/teachable',
    user: apiUrl + '/user'
}

export function apiDictionary(baseLangId, targetLangId, page, limit) {
    return apiUrl + '/dictionary/' + baseLangId + '/language/' + targetLangId
        + '?page=' + page
        + '&limit=' + limit;
}