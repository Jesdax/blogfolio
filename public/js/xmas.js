myDate=new Date();
xmas=Date.parse("Dec 25, "+myDate.getFullYear())
today=Date.parse(myDate)

daysToChristmas=Math.round((xmas-today)/(1000*60*60*24))


if (daysToChristmas==0)
    $('#days').text("C'est Noël !! Joyeux Noël!");

if (daysToChristmas<0)
    $('#days').text("Noël était il y a "+-1*(daysToChristmas)+" jours.");

if (daysToChristmas>0)
    $('#days').text(daysToChristmas+" jours avant Noël !");

//make snow
snowDrop(150, randomInt(1035, 1280));
snow(150, 150);

function snow(num, speed) {
    if (num > 0) {
        setTimeout(function () {
            $('#drop_' + randomInt(1, 250)).addClass('animate');
            num--;
            snow(num, speed);
        }, speed);
    }
}

function snowDrop(num, position) {
    if (num > 0) {
        var drop = '<div class="drop snow" id="drop_' + num + '"></div>';

        $('body').append(drop);
        $('#drop_' + num).css('right', position);
        num--;
        snowDrop(num, randomInt(60, 1280));
    }
}

function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}
