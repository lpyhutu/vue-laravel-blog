export function checkEmail(val) {
    let reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    if (reg.test(val)) {
        return true;
    }
    return false;
}
export function checkWebsite(val) {
    let reg = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w.-]+)+[\w\-._~:/?#[\]@!$&'*+,;=.]+$/;
    if (reg.test(val)) {
        return true;
    }
    return false;
}
export function checkQQ(qq) {
    const reg = /^[1-9][0-9]{4,10}$/;
    if (reg.test(qq)) {
        return true;
    }
    return false;
}