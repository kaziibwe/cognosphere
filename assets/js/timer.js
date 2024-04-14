let dateExample = new Date();
console.log(dateExample);
let countDownTime = new Date("Jan 1 2032 10:00").getTime();
let countDownTimeOther = new Date("Feb 18 2024 13:00");
console.log(countDownTime);
console.log(countDownTimeOther);

setInterval(function(){ //The setInterval updates the timer every 1 second
    //Right nows time
    let timeNow = new Date().getTime();

    //find the distance between countDownTime and timeNow in milliseconds
    let distance = countDownTime - timeNow;

    //Time Calculations for Days, Hours, Minutes, Seconds
    let years = Math.floor(distance / (1000 * 60 * 60 * 24 * 365));
    let days = Math.floor(distance % (1000 * 60 * 60 * 24 *365) / (1000 * 60 * 60 * 24));
    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 *60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / (1000));

    //displaying the timer in the element with id of timer
    // document.getElementById('timer').innerHTML = years + ' years ' + days + ' days ' + hours + ' hours ' + minutes + ' minutes ' + seconds + " seconds";
    document.getElementById('years').innerHTML = years + ' Years ';
    document.getElementById('days').innerHTML = days + ' Days ';
    document.getElementById('hours').innerHTML = hours + ' Hours ';
    document.getElementById('minutes').innerHTML = minutes + ' Minutes ';
    document.getElementById('seconds').innerHTML = seconds + " Seconds";

    //what to show when the countdown is done 
    if(distance < 0 ) {
        clearInterval(timeNow);
        document.getElementById.innerHTML = "2032 Cognosphere Dynamics Assessment";
    }
}, 1000);
