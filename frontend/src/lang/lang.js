import {ru} from "./packages/ru.js";
import {kk} from "./packages/kk.js";
import {en} from "./packages/en.js";
import {fr} from "./packages/fr.js";
import {es} from "./packages/es.js";
import {de} from "./packages/de.js";
import {ar} from "./packages/ar.js";
import {zh} from "./packages/zh.js";
import {ja} from "./packages/ja.js";
import {pt} from "./packages/pt.js";
import {ko} from "./packages/ko.js";
import {hy} from "./packages/hy.js";
import {ka} from "./packages/ka.js";
import {lez} from "./packages/lez.js";
import {et} from "./packages/et.js";
import {lv} from "./packages/lv.js";
import {lt} from "./packages/lt.js";
import {uz} from "./packages/uz.js";
import {mn} from "./packages/mn.js";
import {hi} from "./packages/hi.js";
import {ur} from "./packages/ur.js";
import {he} from "./packages/he.js";

export function getText(label) {
    return label ?? "";
}

export function init() {
    const language = localStorage.getItem('lang');

    switch (language) {
        case 'ru': return ru;
        case 'kk': return kk;
        case 'en': return en;
        case 'fr': return fr;
        case 'es': return es;
        case 'de': return de;
        case 'ar': return ar;
        case 'zh': return zh;
        case 'ja': return ja;
        case 'pt': return pt;
        case 'ko': return ko;
        case 'hy': return hy;
        case 'ka': return ka;
        case 'lez': return lez;
        case 'et': return et;
        case 'lv': return lv;
        case 'lt': return lt;
        case 'uz': return uz;
        case 'mn': return mn;
        case 'hi': return hi;
        case 'ur': return ur;
        case 'he': return he;
        default: return en;
    }
}

export const lang = init();

export const languageOptions = [
    { name: 'Қазақша', flag: '/flags/kz.svg', value: 'kk' },
    { name: 'Русский', flag: '/flags/ru.svg', value: 'ru' },
    { name: 'English', flag: '/flags/en.svg', value: 'en' },
    { name: 'Français', flag: '/flags/fr.svg', value: 'fr' },
    { name: 'Español', flag: '/flags/es.svg', value: 'es' },
    { name: 'Deutsch', flag: '/flags/de.svg', value: 'de' },
    { name: 'العربية', flag: '/flags/sa.svg', value: 'ar' },
    { name: '中文', flag: '/flags/cn.svg', value: 'zh' },
    { name: '日本語', flag: '/flags/jp.svg', value: 'ja' },
    { name: 'Português', flag: '/flags/pt.svg', value: 'pt' },
    { name: '한국어', flag: '/flags/kr.svg', value: 'ko' },
    { name: 'ქართული', flag: '/flags/ge.svg', value: 'ka' },
    { name: 'Հայերեն', flag: '/flags/am.svg', value: 'hy' },
    { name: 'Лезги чӏал', flag: '/flags/lez.svg', value: 'lez' },
    { name: 'Oʻzbekcha', flag: '/flags/uz.svg', value: 'uz' },
    { name: 'Монгол', flag: '/flags/mn.svg', value: 'mn' },
    { name: 'Eesti', flag: '/flags/ee.svg', value: 'et' },
    { name: 'Latviešu', flag: '/flags/lv.svg', value: 'lv' },
    { name: 'Lietuvių', flag: '/flags/lt.svg', value: 'lt' },
    { name: 'हिन्दी', flag: '/flags/in.svg', value: 'hi' },
    { name: 'اردو', flag: '/flags/pk.svg', value: 'ur' },
    { name: 'עברית', flag: '/flags/il.svg', value: 'he' },
];

export function getLabel(label) {
    if (label) {
        const lang = localStorage.getItem('lang') ?? 'en';
        const translations = JSON.parse(label);
        return translations[lang] ?? translations.en;
    }

    return '';
}