

var area = [[[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]],
            [[],[],[],[],[],[],[],[]]];

var tura = 0;

var nextMove = [];


var createArea = function () {
    for (var rowNum = 0; rowNum <= 7; rowNum++) {
        for (var cellNum = 0; cellNum <= 7; cellNum++) {
            if (rowNum == 0 || rowNum == 1) {
                area[rowNum][cellNum] = {x: cellNum, y: rowNum, value: 1}
            } else if (rowNum == 7 || rowNum == 6) {
                area[rowNum][cellNum] = {x: cellNum, y: rowNum, value: 0}
            } else {
                area[rowNum][cellNum] = {x: cellNum, y: rowNum, value: ''}
            }
        }
    }
};

var drawGameArea = function(){
    for (var rowNum = 0; rowNum < area.length; rowNum++) {

        for (var cellNum = 0; cellNum < area[rowNum].length; cellNum++) {
            var $input = $('<input type="button" class="button" value="'+area[rowNum][cellNum].value+ '" />')
                .click(clickFunction({x:cellNum, y:rowNum, value:area[rowNum][cellNum].value}));
            $input.appendTo($("#board"));
        }
        var newLine = $('</br>');
        newLine.appendTo($("#board"));
    }
};

var refreshGameArea = function(){
    $("#board").empty();
    drawGameArea();
};

var clickFunction = function(position){
    return function(){
        if(typeof (nextMove[0]) == 'undefined' ){
            nextMove.push({x:position.x, y:position.y, value:position.value})
        }else if(typeof (nextMove[0]) != 'undefined' && typeof (nextMove[1]) == 'undefined'){
            nextMove.push({x:position.x, y:position.y, value:position.value});
            console.log(nextMove);
            $.ajax({
                type: "POST",
                url: 'sender.php',
                data: {nextMove: nextMove},
                success: function(data){
                    console.log(data);
                    area = data;
                    refreshGameArea();
                },
                dataType: 'json'
            }).fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });
            nextMove = [];
        }else{
            alert('pac');
        }
    };
};

var nextTura = function () {
    if (tura == 0) {
        return 1
    } else {
        return 0
    }
};





createArea();
drawGameArea()
