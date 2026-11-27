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
import {it} from "./packages/it.js";
import {no} from "./packages/no.js";
import {sv} from "./packages/sv.js";
import {da} from "./packages/da.js";
import {ga} from "./packages/ga.js";
import {fi} from "./packages/fi.js";
import {pl} from "./packages/pl.js";

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
        case 'it': return it;
        case 'fi': return fi;
        case 'no': return no;
        case 'sv': return sv;
        case 'da': return da;
        case 'ga': return ga;
        case 'pl': return pl;
        default: return en;
    }
}

export const lang = init();

export const languageOptions = [
    { name: 'Қазақша', flag: '/flags/kk.svg', value: 'kk' },
    { name: 'Русский', flag: '/flags/ru.svg', value: 'ru' },
    { name: 'English', flag: '/flags/en.svg', value: 'en' },
    { name: 'Français', flag: '/flags/fr.svg', value: 'fr' },
    { name: 'Español', flag: '/flags/es.svg', value: 'es' },
    { name: 'Deutsch', flag: '/flags/de.svg', value: 'de' },
    { name: 'العربية', flag: '/flags/ar.svg', value: 'ar' },
    { name: '中文', flag: '/flags/zh.svg', value: 'zh' },
    { name: '日本語', flag: '/flags/ja.svg', value: 'ja' },
    { name: 'Português', flag: '/flags/pt.svg', value: 'pt' },
    { name: '한국어', flag: '/flags/ko.svg', value: 'ko' },
    { name: 'ქართული', flag: '/flags/ka.svg', value: 'ka' },
    { name: 'Հայերեն', flag: '/flags/hy.svg', value: 'hy' },
    { name: 'Лезги чӏал', flag: '/flags/lez.svg', value: 'lez' },
    { name: 'Oʻzbekcha', flag: '/flags/uz.svg', value: 'uz' },
    { name: 'Монгол', flag: '/flags/mn.svg', value: 'mn' },
    { name: 'Eesti', flag: '/flags/et.svg', value: 'et' },
    { name: 'Latviešu', flag: '/flags/lv.svg', value: 'lv' },
    { name: 'Lietuvių', flag: '/flags/lt.svg', value: 'lt' },
    { name: 'हिन्दी', flag: '/flags/hi.svg', value: 'hi' },
    { name: 'اردو', flag: '/flags/ur.svg', value: 'ur' },
    { name: 'עברית', flag: '/flags/he.svg', value: 'he' },
    { name: 'Italiano', flag: '/flags/it.svg', value: 'it' },
    { name: 'Gaeilge', flag: '/flags/ga.svg', value: 'ga' },
    { name: 'Polski', flag: '/flags/pl.svg', value: 'pl' },
    { name: 'Svenska', flag: '/flags/sv.svg', value: 'sv' },
    { name: 'Norsk', flag: '/flags/no.svg', value: 'no' },
    { name: 'Dansk', flag: '/flags/da.svg', value: 'da' },
    { name: 'Suomi', flag: '/flags/fi.svg', value: 'fi' },
];

export function getLabel(label) {
    if (label) {
        const lang = localStorage.getItem('lang') ?? 'en';
        const translations = JSON.parse(label);
        return translations[lang] ?? translations.en;
    }

    return '';
}