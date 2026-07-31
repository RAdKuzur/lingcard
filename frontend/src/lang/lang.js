import {ru} from "./packages/ru.js";
import {kz} from "./packages/kz.js";
import {en} from "./packages/en.js";
import {fr} from "./packages/fr.js";

export function getText(label) {
    const lang = localStorage.getItem('lang');
    if (lang) {
        return label[lang]
    }
    return label.en
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
        default:
            return en;
    }
}

export const lang = init()
