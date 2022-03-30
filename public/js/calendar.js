function getArrBeforeToday() {
    var arr = [];
    var today = new Date();
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

function getFirstMonthUntilNow(){
    var mo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des']
    var arr = [];
    var today = new Date();
    var month = today.getMonth();
    for (var i = 0; i <= month; i++) {
        arr.push([mo[i]]);
    }
    return arr;
}

var today = new Date();
document.getElementById('day').innerHTML = today.toLocaleString('en-us', { weekday: 'long' });
document.getElementById('date').innerHTML = today.getDate();
document.getElementById('month').innerHTML = today.toLocaleString('en-us', { month: 'long' });
document.getElementById('year').innerHTML = today.getFullYear();



