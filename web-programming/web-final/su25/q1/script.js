// Create a JavaScript application where users can track their daily calorie intake and get real-time feedback
// on their eating habits.
// Index.html:
// Create a number input field to enter calories consumed per meal, a “Add Calories” button, and below
// that a label field to display total calories, daily goal progress, and feedback messages
// Script.js:
// 1. Set a daily calorie goal of 2000 calories.
// 2. Take the user’s calorie input from the HTML file.
// 3. Inside a function:
// a) Add the entered calories to a running total.
// b) Display the total calories consumed so far.
// c) Display feedback messages based on progress:
// • 0–800 → “You’re off to a healthy start!”
// • 801–1600 → “Good progress, keep it balanced!”
// • 1601–1999 → “Almost at your limit!”
// • 2000+ → “Goal reached! Stay mindful!”
// d) Keep track of the number of entries the user has made
// e) If the user logs calories more than 10 times without reaching the goal, display
// “Be cautious of frequent snacking!”

let btnPressed = 0
let runningTotal = 0

document.getElementById("inputBtn").addEventListener("click", function() {
    let inputCalorie = Number(document.getElementById("input").value )
    runningTotal += inputCalorie
    btnPressed++

    let feedback = ""
    if (runningTotal <= 800) {
        feedback = "You're off to a healthy start!"
    } else if (runningTotal <= 1600) {
        feedback = "Good progress, keep it balanced!"
    } else if (runningTotal <= 1999) {
        feedback = "Almost at your limit!"
    } else {
        feedback = "Expect a heart attack soon you fat fuck!"
    }

    if (btnPressed > 10 && runningTotal < 2000) {
        feedback = "Be cautious of frequent snacking!"
    }

    let out = "Calorie So far: " + runningTotal + " || Feedback: " + feedback
    document.getElementById("output").innerHTML = out
})

