export default  {
    data: {},
    get(context) {
        if (!context) {
            throw new Error('context needed');
        }
        if (this.data[context] !== undefined) {
            return this.data[context];
        } else {
            const dataBs = window[context] || {};
            const element = document.getElementById(context + '-data-bootstrap');
            element.parentNode.removeChild(element);
            return this.data[context] = dataBs;
        }
    }
}