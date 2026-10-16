// JAVASCRIPT: Create a JavaScript application where users can test their password strength and get
// real-time feedback.
// index.html:
// Create a password input field (input type password), a "Check Strength" button, and below that a
// label field to display strength feedback and scoring results.
// script.js:
// 1. Generate a target strength score of 100 points for a "Very Strong" password.
// 2. Take the user's password input from the HTML file.
// 3. Inside a function:
// ○ Calculate password strength based on these criteria:
// ■ Length: +10 points for every 2 characters (minimum 6 characters required)
// ■ Uppercase letters: +15 points if present
// ■ Lowercase letters: +15 points if present
// ■ Numbers: +20 points if present
// ■ Special characters (!@#$%^&*): +25 points if present
// ○ Display strength levels: "Very Weak" (0-30), "Weak" (31-50), "Medium" (51-70),
// "Strong" (71-90), "Very Strong" (91+)
// ○ If password reaches 100+ points, display "Perfect Password!" and show a success
// message
// ○ Keep track of how many attempts the user has made
// ○ If the user makes more than 8 attempts without reaching "Strong" level, display
// "Need practice!" and suggest password tips

let attempt = 0

document.getElementById("inputBtn").addEventListener("click", function() {
    let point = 0
    let userPass = document.getElementById("input").value 

    attempt++
    let halfLength = Math.floor(userPass.length / 2)
    point += halfLength*10
    
    if(/[A-Z]/.test(userPass)) point += 15
    if(/[a-z]/.test(userPass)) point += 15
    if(/[0-9]/.test(userPass)) point += 20
    if(/[!@#$%^&*]/.test(userPass)) point += 25
    
    let feedback = ""
    if (point <= 30)      feedback = "Very Weak"
    else if (point <= 50) feedback = "Weak"
    else if (point <= 70) feedback = "Medium" 
    else if (point <= 90) feedback = "Strong"
    else                  feedback = "Very Strong"

    let out = "Attemps: " + attempt + " | Point: " + point + " | Feedback: " + feedback
    document.getElementById("output").innerHTML = out
})