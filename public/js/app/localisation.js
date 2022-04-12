/**
 * app/localisation.js
 */

function translate (key) {

    let translations = {},
        translation = key;

    $.extend(translations, translations, $("#js_translations").data());

    if (translations.hasOwnProperty(key)) {
        translation = translations[key];
    }

    return translation;
}

export { translate };