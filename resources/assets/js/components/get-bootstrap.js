export default function(context) {
    if (!context) {
        throw new Error('context needed');
    }
    var dataBs = window[context] || {};
    var element = document.getElementById(context + '-data-bootstrap');
    element.parentNode.removeChild(element);
    return dataBs;
}