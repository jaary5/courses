// global vars
const goals = 20
let totalStudyHours = 0
let subjects = []
let sessions = 0

document.getElementById("submitBtn").addEventListener("click", function() {
    sessions++

    let subjectName = document.getElementById("subjectName").value 
    subjects.push(subjectName)

    let studyHour = Number(document.getElementById("studyHour").value)
    totalStudyHours += studyHour

    let avgStudy = totalStudyHours / sessions

    let arrStr = "[ "
    for (let i = 0; i < subjects.length; i++) {
        arrStr += subjects[i] + " ,"
    }
    arrStr += " ]"

    let feedback = ""
    if (totalStudyHours >= 20) feedback = "Weekly goal reached!"
    else if (totalStudyHours >= 13) feedback = "Almost ready!"
    else if (totalStudyHours >= 6) feedback = "Good Progress!"
    else feedback = "Start studying regularly"

    if (sessions > 7 && totalStudyHours < 20) feedback = "Increase your study time!"

    let out = "Total: " + totalStudyHours + " hours," + "<br>" + 
               "Average: " + avgStudy + " hours, " + "<br>" +
               "Subjects: " + arrStr + "<br>" +
               "Feedback: " + feedback
    
    document.getElementById("output").innerHTML = out
})