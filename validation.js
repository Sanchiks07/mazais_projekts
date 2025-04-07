function validateForm() {
    let fname = document.forms["signup"]["first_name"].value;
    let lname = document.forms["signup"]["last_name"].value;
    let phone = document.forms["signup"]["phone"].value;
    let email = document.forms["signup"]["email"].value;
    let birthday = document.forms["signup"]["birthday"].value;
    let password = document.forms["signup"]["password"].value;

    let namePattern = /^[A-Za-zĀ-ž\s]+$/;
    let phonePattern = /^\d{8}$/;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*-_.]).{15,}$/;

    if (!namePattern.test(fname) || !namePattern.test(lname)) {
        alert("First name and Last name should contain only letters!");
        return false;
    }

    if (!phonePattern.test(phone)) {
        alert("Phone number should contain only digits and needs to be 8 digits long.");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Invalid email address!");
        return false;
    }

    let today = new Date();
    let inputBirthday = new Date(birthday);
    if (inputBirthday > today) {
        alert("Birthday cannot be in the future!");
        return false;
    }

    if (!passwordPattern.test(password)) {
        alert("Password must be at least 15 characters long, contain an uppercase and a lowercase letter, a number, and a special symbol!");
        return false;
    }

    return true;
}