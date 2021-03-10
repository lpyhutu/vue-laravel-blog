export function SwitchTimeSlot(data) {
    let d = Date.now() - parseInt(data);
    let minute = 1000 * 60;
    let hour = minute * 60;
    let day = hour * 24;
    let month = day * 30;
    let year = month * 12;
    let yearC = d / (year)
    let monthC = d / month;
    let weekC = d / (7 * day);
    let dayC = d / day;
    let hourC = d / hour;
    let minC = d / minute;
    if (minC < 60) {
        return parseInt(minC) + "分钟前";
    }
    if (hourC < 24) {
        return parseInt(hourC) + "小时前";
    }
    if (dayC < 7) {
        return parseInt(dayC) + "天前";
    }
    if (weekC < 4) {
        return parseInt(weekC) + "周前";
    }
    if (monthC < 12) {
        return parseInt(monthC) + "月前";
    }
    return parseInt(yearC) + "年前";

}

export function SwitchDate(time) {
    let d = (new Date(parseInt(time) * 1000));
    let Y = d.getFullYear();
    let M = d.getMonth() + 1;
    let D = d.getDate();
    let h = checkTime(d.getHours())
    let m = checkTime(d.getMinutes())
    let s = checkTime(d.getSeconds())
    return `${Y}-${M}-${D} ${h}:${m}:${s}`;
}

export function SwitchYMD(time) {
    let d = (new Date(parseInt(time) * 1000));
    let Y = d.getFullYear();
    let M = d.getMonth() + 1;
    let D = d.getDate();
    let h = checkTime(d.getHours())
    let m = checkTime(d.getMinutes())
    let s = checkTime(d.getSeconds())
    return `${Y}/${M}/${D}`;
}

export function runningTime(val) {
    let end = parseInt(val);
    let start = (new Date('2020-9-03')).getTime()
    let time = end - start
    let D = time / (1000 * 60 * 60 * 24);
    // let h = (D - Math.floor(D)) * 24;
    // let m = (h - Math.floor(h)) * 60
    // let s = (m - Math.floor(m)) * 60
    return ` ${Math.floor(D)}`;
    // return ` ${Math.floor(D)} 天 ${checkTime(Math.floor(h))} 小时 ${checkTime(Math.floor(m))} 分 ${checkTime(Math.floor(s))} 秒`;
}
export function checkTime(val) {
    if (val < 10) {
        return `0${val}`
    }
    return val;
}