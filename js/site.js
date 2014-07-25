ze;
var gridMiddle
var board;

/*
 *
 * Setters
 *
 */
function setGridSize(val) {
    gridSize = val;
}

function setGridMiddle(val) {
    gridMiddle = val;
}

/*
 *
 * Game Logic
 *
 */
function initializeBoard() {
    board = null;
    board = new Array(gridSize);
    // read the numbers from the generated card
    for (var row = 0; row < gridSize; row++) {
        board[row] = new Array(gridSize);
        for (var column = 0; column < gridSize; column++) {
            if(gridMiddle === row && gridMiddle === column) {
                board[row][column] = true;
                continue;
            }
            board[row][column] = false;
        }
    }
    enableBoard();
    hideWinner();
}

function markSpace(selection, callback) {
    updateBoard(selection);
    validateBoard();
    callback();
}

function updateBoard(selection) {
    var row;
    var column;
    var item = selection.split('_');

    column = parseInt(item[0].replace('row', ''));
    row = parseInt(item[1].replace('col', ''));

    board[row][column] = true;
}

function validateBoard() {
    var verticalLineCount = 0;
    var horizontalLineCount = 0;
    var diagnalLineCount = 0;
    var totalLines = 0;

    for (var outer = 0; outer < gridSize; outer++) {
        verticalLineCount += validateVerticalLine(outer);
        horizontalLineCount += validateHorizontalLine(outer);
    }

    diagnalLineCount = validateDiagnalLines();

    totalLines = verticalLineCount + horizontalLineCount + diagnalLineCount;
    if (totalLines >= 2) { // Game is 2 Lines
        disableBoard();
        showWinner();
    }
}

function validateHorizontalLine(index) {
    var hasLine = true; // false positive; will be cancelled out by unselected (false) square
    for (var inner = 0; inner < gridSize; inner++) {
        hasLine = (board[index][inner]) & hasLine;
    }
    return (hasLine) ? 1 : 0;
}

function validateVerticalLine(index) {
    var hasLine = true; // false positive; will be cancelled out by unselected (false) square
    for (var inner = 0; inner < gridSize; inner++) {
        hasLine = (board[inner][index]) & hasLine;
    }
    return (hasLine) ? 1 : 0;
}

function validateDiagnalLines() {
    var hasAsc = true; // false positive; will be cancelled out by unselected (false) square
    for (var inner = 0; inner < gridSize; inner++) {
        hasAsc = (board[inner][inner]) & hasAsc;
    }

    var hasDesc = true; // false positive; will be cancelled out by unselected (false) square
    for (var inner = 0; inner < gridSize; inner++) {
        hasDesc = (board[inner][(gridSize - inner - 1)]) & hasDesc;
    }

    return (hasAsc & hasDesc) ? 2 : (hasAsc | hasDesc) ? 1 : 0;
}

/* Board Functionality */

function enableBoard() {
    $('table.board td').click(function () {
        // Ajax Call to Service
        var item = $(this);
        if ( ! item.hasClass('space-selected')) {
            var space = item.attr('id');
            markSpace(space, function () {
                item.addClass('space-selected');
            });
        }
    });
}

function disableBoard() {
    $('table.board td').off('click');
}

function hideWinner() {
    $('#winner').removeClass('show');
}

function showWinner() {
    $('#winner').addClass('show');
}

function clearBoard() {
    this.window.location = this.window.location;
}
