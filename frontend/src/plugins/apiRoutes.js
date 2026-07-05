export const apiUrl = 'http://localhost:8000/api';
export const apiRoutes = {
    csrf: apiUrl + '/csrf-cookie',
    login: apiUrl + '/login',
    logout: apiUrl + '/logout',
    refresh: apiUrl + '/refresh',
    languages: apiUrl + '/languages',
    profile: apiUrl + '/profile',
    progress: apiUrl + '/progress',
    training: apiUrl + '/training'
}

export function apiDictionary(baseLangId, targetLangId) {
    return apiUrl + '/dictionary/' + baseLangId + '/language/' + targetLangId;
}