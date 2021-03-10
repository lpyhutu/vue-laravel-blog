export function RegEmail(val) {
    let reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    if (reg.test(val)) {
        return true;
    }
    return false;
}