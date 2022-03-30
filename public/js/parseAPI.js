function getJson(options, startDate, endDate) {
    var json;
    $.ajax({
        url: '/api/' + options,
        type: "GET",
        data: {
            "startDate": startDate,
            "endDate": endDate
        },
        async: false,
        success: function (data) {
            json = data;
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
    return json;
}

function getArrBeforeToday(today) {
    var arr = [];
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    for (var i = 30 - 1; i >= 0; i--) {
        var date = new Date(year, month - 1, day - i);
        var strWeekday = date.toLocaleString('en-us', { weekday: 'short' });
        var numDay = date.getDate();
        arr.push([numDay, strWeekday]);
    }
    return arr;
}

function dateToString(date) {
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    return year + '-' + month + '-' + day;
}

function getShortDay(date) {
    var date = new Date(date);
    var day = date.getDay();
    var dayArr = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    return dayArr[day];
}

// create function that return month name by given date in string format yyyy-mm-dd
function getMonthName(data) {
    var monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des'];
    return monthArr.slice(0, data.total.length);
}

function getOmzetYTD(year, month, day) {
    var start = new Date(year, 0, 1);
    var end = new Date(year, month - 1, day);
    ytd = getJson('ytd-omzet', dateToString(start), dateToString(end));
    return ytd;
}

function getOmzetMTD(year, month, day) {
    var start = new Date(year, month - 1, 1);
    var end = new Date(year, month - 1, day);
    mtd = getJson('mtd-omzet', dateToString(start), dateToString(end));
    return mtd;
}

function getOmzetToday(year, month, day, hours, minutes, seconds, ms) {
    var start = new Date(year, month - 1, day, 00, 00, 00, 00);
    var end = new Date(year, month - 1, day, hours, minutes, seconds, ms);
    tdy = getJson('today-omzet', dateToString(start), dateToString(end));
    return tdy;
}

function getOmzetYTDZT(year, month, day) {
    var start = new Date(year, 0, 1);
    var end = new Date(year, month - 1, day);
    ytdzt = getJson('ytd-omzet-zt', dateToString(start), dateToString(end));
    return ytdzt;
}

function getOmzetMTDZT(year, month, day) {
    var start = new Date(year, month - 1, 1);
    var end = new Date(year, month - 1, day);
    mtdzt = getJson('mtd-omzet-zt', dateToString(start), dateToString(end));
    return mtdzt;
}

function getOmzetTodayZT(year, month, day, hours, minutes, seconds, ms) {
    var start = new Date(year, month - 1, day, 00, 00, 00, 00);
    var end = new Date(year, month - 1, day, hours, minutes, seconds, ms);
    tdyzt = getJson('today-omzet-zt', dateToString(start), dateToString(end));
    return tdyzt;
}

function getOmzetMonthly(year, month, day) {
    var start = new Date(year, 0, 1);
    var end = new Date(year, month - 1, day);
    monthlyzt = getJson('omzet-monthly-zt', dateToString(start), dateToString(end));
    return monthlyzt;
}

function getOmzetMonthlyZT1(year, month, day) {
    var start = new Date(year, 0, 1);
    var end = new Date(year, month - 1, day);
    monthly = getJson('omzet-monthly-zt1', dateToString(start), dateToString(end));
    return monthly;
}

function getActiveMember(year, month, day) {
    var start = new Date(year, month - 3, day);
    var end = new Date(year, month - 1, day);
    act = getJson('active-member', dateToString(start), dateToString(end));
    return act;
}

function getActiveMember1(year, month, day) {
    var start = new Date(year, month - 2, day);
    var end = new Date(year, month - 1, day);
    act = getJson('active-member', dateToString(start), dateToString(end));
    return act;
}

function getActiveMemberTdy(year, month, day) {
    var start = new Date(year, month - 2, 1);
    var end = new Date(year, month - 1, day);
    act = getJson('active-member', dateToString(start), dateToString(end));
    return act;
}

function parseActive(data) {
    var active = {
        "nama": [],
        "jumlah": []
    };
    data.member.forEach(element => {
        active.nama.push(element.nama);
    });
    data.member.forEach(element => {
        active.jumlah.push(element.jumlah);
    });
    return active;
}

function parseOmzet(data) {
    var omzet = {
        "guest": [],
        "member": [],
        "total": [],

    };
    data.guest.forEach(element => {
        omzet.guest.push(element.jumlah);
    });
    data.member.forEach(element => {
        omzet.member.push(element.jumlah);
    });
    data.total.forEach(element => {
        omzet.total.push(element.jumlah);
    });
    return omzet;

}

function parseOmzetZT(data) {
    var omzetZT = {
        "zt1": [],
        "zt2": [],
        "zt3": [],
        "total": [],

    };
    data.zt1.forEach(element => {
        omzetZT.zt1.push(element.jumlah);
    });
    data.zt2.forEach(element => {
        omzetZT.zt2.push(element.jumlah);
    });
    data.zt3.forEach(element => {
        omzetZT.zt3.push(element.jumlah);
    });
    data.total.forEach(element => {
        omzetZT.total.push(element.jumlah);
    });
    return omzetZT;

}