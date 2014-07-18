var area = [];

var tura = 0;

var nextMove = [];


var createArea = function () {
    uploadAreaFromDb();
    refreshGameArea();
};


var drawGameArea = function () {
    for (var rowNum = 0; rowNum < area.length; rowNum++) {

        for (var cellNum = 0; cellNum < area[rowNum].length; cellNum++) {
            var $input = $('<input type="button" class="button" value="' + area[rowNum][cellNum].value + '" />')
                .click(clickFunction({x: cellNum, y: rowNum, value: area[rowNum][cellNum].value}));
            $input.appendTo($("#board"));
        }
        var newLine = $('</br>');
        newLine.appendTo($("#board"));
    }
};

var refreshGameArea = function () {
    $("#board").empty();
    drawGameArea();
};

var clickFunction = function (position) {
    return function () {
        if (typeof (nextMove[0]) == 'undefined') {

            nextMove.push({x: position.x, y: position.y, value: position.value});
            $('#button').removeClass('red');
            $(this).addClass('red');

        } else if (typeof (nextMove[0]) != 'undefined' && typeof (nextMove[1]) == 'undefined') {

            nextMove.push({x: position.x, y: position.y, value: position.value});
            console.log(nextMove);
            $.ajax({
                type: "POST",
                url: 'sender.php',
                data: {nextMove: nextMove},
                success: function (data) {
                    console.log(data);
                    area = data;
                    refreshGameArea();
                },
               dataType: 'json'
            }).fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            nextMove = [];
        } else {
            alert('pac');
        }
        checkWhoWinner();
    };
};

var addResetButton = function () {
    var $input = $('<input type="button" class="ResetButton" value="Reset Area" />')
        .click(function () {
            resetAll();
        });
    $input.appendTo($("#otoczenie"));
};

var resetAll = function () {
    $.ajax({
        type: "POST",
        url: "newAreaBuilder.php",
        success: function () {
            createArea();
            refreshGameArea();
        }});
};


var checkWhoWinner = function () {
    var zeroPlayers = 0;
    var onePlayers = 0;
    for (var i = 0; i < area.length; i++) {
        for (var j = 0; j < area[i].length; j++) {
            if (area[i][j]['value'] == 0) {
                zeroPlayers++
            } else if (area[i][j]['value'] == 1) {
                onePlayers++
            }
        }
    }
    if (zeroPlayers == 0) {
        alert('gracz "0" wygral');
        resetAll();
    }
    if (onePlayers == 0) {
        alert('gracz "1" wygral');
        resetAll();
    }
};

setInterval(function () {
    uploadAreaFromDb()
}, 5000);

var uploadAreaFromDb = function () {
    $.ajax({
        type: "GET",
        url: 'getDatabaseInfo.php',
        success: function (data) {
            area = data;
            refreshGameArea();
            console.log("synchronizacja z bazą danych")
        },
        dataType: 'json'
    })
};

createArea();
addResetButton();