function validateForm() {
    let fname = document.forms["signup"]["first_name"].value;
    let lname = document.forms["signup"]["last_name"].value;
    let phone = document.forms["signup"]["phone"].value;
    let email = document.forms["signup"]["email"].value;
    let password = document.forms["signup"]["password"].value;

    let namePattern = /^[A-Za-zĀ-ž\s]+$/;
    let phonePattern = /^\+?\d{7,15}$/;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*-_.]).{9,}$/;

    if (!namePattern.test(fname) || !namePattern.test(lname)) {
        alert("First name and Last name should contain only letters!");
        return false;
    }

    if (!phonePattern.test(phone)) {
        alert("Invalid phone number! It should contain only digits and may start with '+'.");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Invalid email address!");
        return false;
    }

    if (!passwordPattern.test(password)) {
        alert("Password must be at least 9 characters long, contain an uppercase and a lowercase letter, a number, and a special symbol!");
        return false;
    }

    return true;
}