import {ru} from "./packages/ru.js";
import {kz} from "./packages/kz.js";
import {en} from "./packages/en.js";
import {fr} from "./packages/fr.js";
import {es} from "./packages/es.js";
import {de} from "./packages/de.js";
import {sa} from "./packages/sa.js";
import {cn} from "./packages/cn.js";
import {jp} from "./packages/jp.js";
import {pt} from "./packages/pt.js";
import {kr} from "./packages/kr.js";
import {am} from "./packages/am.js";
import {ge} from "./packages/ge.js";
import {lez} from "./packages/lez.js";
import {ee} from "./packages/ee.js";
import {lv} from "./packages/lv.js";
import {lt} from "./packages/lt.js";
import {uz} from "./packages/uz.js";
import {mn} from "./packages/mn.js";
import {hi} from "./packages/in.js";
import {pk} from "./packages/pk.js";

export function getText(label) {
    return label ?? ""
}

export function init() {
    const language = localStorage.getItem('lang');
    switch (language) {
        case 'ru':
            return ru;
        case 'kz':
            return kz;
        case 'en':
            return en;
        case 'fr':
            return fr;
        case 'es':
            return es;
        case 'de':
            return de;
        case 'sa':
            return sa;
        case 'cn':
            return cn;
        case 'jp':
            return jp;
        case 'pt':
            return pt;
        case 'kr':
            return kr;
        case 'am':
            return am;
        case 'ge':
            return ge;
        case 'lez':
            return lez;
        case 'ee':
            return ee;
        case 'lv':
            return lv;
        case 'lt':
            return lt;
        case 'uz':
            return uz;
        case 'mn':
            return mn;
        case 'in':
            return hi;
        case 'pk':
            return pk;
        default:
            return en;
    }
}

export const lang = init()

export const languageOptions = [
    { name: 'Қазақша', flag: '/flags/kz.svg', value: 'kz' },
    { name: 'Русский', flag: '/flags/ru.svg', value: 'ru' },
    { name: 'English', flag: '/flags/en.svg', value: 'en' },
    { name: 'Français', flag: '/flags/fr.svg', value: 'fr' },
    { name: 'Español', flag: '/flags/es.svg', value: 'es' },
    { name: 'Deutsch', flag: '/flags/de.svg', value: 'de' },
    { name: 'العربية', flag: '/flags/sa.svg', value: 'sa' },
    { name: '中文', flag: '/flags/cn.svg', value: 'cn' },
    { name: '日本語', flag: '/flags/jp.svg', value: 'jp' },
    { name: 'Português', flag: '/flags/pt.svg', value: 'pt' },
    { name: '한국어', flag: '/flags/kr.svg', value: 'kr' },
    { name: 'ქართული', flag: '/flags/ge.svg', value: 'ge' },
    { name: 'Հայերեն', flag: '/flags/am.svg', value: 'am' },
    { name: 'Лезги чӏал', flag: '/flags/lez.svg', value: 'lez' },
    { name: 'Oʻzbekcha', flag: '/flags/uz.svg', value: 'uz' },
    { name: 'Монгол', flag: '/flags/mn.svg', value: 'mn' },
    { name: 'Eesti', flag: '/flags/ee.svg', value: 'ee' },
    { name: 'Latviešu', flag: '/flags/lv.svg', value: 'lv' },
    { name: 'Lietuvių', flag: '/flags/lt.svg', value: 'lt' },
    { name: 'हिन्दी', flag: '/flags/in.svg', value: 'in' },
    { name: 'اردو', flag: '/flags/pk.svg', value: 'pk' },
];

export function getLabel(label) {
    if(label) {
        const lang = localStorage.getItem('lang') ?? 'en'
        return JSON.parse(label)[lang] ?? JSON.parse(label).en
    }
    return ''
}