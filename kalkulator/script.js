var numbers = document.getElementsByClassName('number');
var screen = document.getElementById('screen');
var operators = document.getElementsByClassName('operator');
var equalButton = document.getElementsByClassName('equal')[0];
var clearButton = document.getElementsByClassName('clear')[0];

var currentNumber = "";
var currentOperator = "";
var result = 0;

[...numbers].forEach(el => {
    el.addEventListener('click', function() {
    currentNumber = el.textContent;
    screen.value = currentNumber;
    });
  });

  [...operators].forEach(op => {
    op.addEventListener('click', function() {
        currentOperator = op.textContent;
        result = parseInt(currentNumber);
        currentNumber = "";
    });
  });

  equalButton.addEventListener('click', function() {
    var secondNumber = parseInt(currentNumber);
    if (currentOperator === '+') {
        result += secondNumber;
    } else if (currentOperator === '*') {
        result *= secondNumber;
    } else if (currentOperator === '-') {
        result -= secondNumber;
    } else if (currentOperator === '/') {
        result /= secondNumber;
    }
    screen.value = result;
    currentNumber = "";
    currentOperator = "";
  });

  clearButton.addEventListener('click', function() {
    currentNumber = "";
    currentOperator = "";
    result = 0;
    screen.value = "";
  });



// num = [1,2,3];
// acc = "przyklad";

// num.forEach(el=> {
//     el=el*4+2;
// });

// console.log(num);


// var numMap = num.map(el=> el*2);

// console.log(numMap);

// var filter = num.filter(el=> el%2 == 0 );

// console.log(filter);

// var reduceEx = num.reduce((a,b)=>a+b,5);

// var reduceExS = [...acc].reduce((acc, curr) => (acc[curr] = (acc[curr] || 0) + 1, acc), {});
// console.log(reduceExS);