var numbers = document.getElementsByClassName('number');
document.querySelectorAll('.number');
console.log(numbers);
[...numbers].forEach(el=> {
    console.log(el,"element");
 });


[...numbers].forEach(el=> {
        el = el+1;
        console.log(numbers);
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