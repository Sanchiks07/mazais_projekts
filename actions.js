// edit
function editUser(button) {
    let row = button.closest("tr");
    let id = row.cells[0].textContent;
    let firstName = row.cells[1].textContent;
    let lastName = row.cells[2].textContent;
    let phone = row.cells[3].textContent;
    let email = row.cells[4].textContent;
    let birthday = row.cells[5].textContent;

    let popup = document.createElement("div");
    popup.classList.add("popup");
    popup.innerHTML = `
        <div class="popup-content">
            <h2>Rediģēt Lietotāju</h2>
            <form method="POST" id="editForm">
                <input id="editId" value="${id}" hidden />
                <div class="input-group">
                    <label>
                        Vārds
                        <input id="editFirstName" value="${firstName}" required />
                    </label><br>

                    <label>
                        Uzvārds
                        <input id="editLastName" value="${lastName}" required />
                    </label><br>

                    <label>
                        Telefona Nr.
                        <input id="editPhone" value="${phone}" required />
                    </label><br>

                    <label>
                        E-pasts
                        <input type="email" id="editEmail" value="${email}" required />
                    </label><br>

                    <label>
                        Dzimšanas Diena
                        <input type="date" id="editBirthday" value="${birthday}" required />
                    </label><br><br>
                </div>
                <div class="popup-buttons">
                    <button type="button" id="saveChanges" class="save">Saglabāt</button>
                    <button type="button" id="cancelEdit" class="cancel">Atcelt</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(popup);

    document.getElementById("cancelEdit").addEventListener("click", function () {
        document.body.removeChild(popup);
    });

    document.getElementById("saveChanges").addEventListener("click", function () {
        if (!validateForm()) {
            return;
        }

        let updatedData = {
            id: document.getElementById("editId").value,
            first_name: document.getElementById("editFirstName").value,
            last_name: document.getElementById("editLastName").value,
            phone: document.getElementById("editPhone").value,
            email: document.getElementById("editEmail").value,
            birthday: document.getElementById("editBirthday").value
        };

        fetch('update_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.cells[0].textContent = updatedData.id;
                row.cells[1].textContent = updatedData.first_name;
                row.cells[2].textContent = updatedData.last_name;
                row.cells[3].textContent = updatedData.phone;
                row.cells[4].textContent = updatedData.email;
                row.cells[5].textContent = updatedData.birthday;
                document.body.removeChild(popup);
                alert("User updated successfully!");
            } else {
                alert("Error updating user.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error updating user.");
        });
    });
}

// validator for edit
function validateForm() {
    let fname = document.getElementById("editFirstName").value;
    let lname = document.getElementById("editLastName").value;
    let phone = document.getElementById("editPhone").value;
    let email = document.getElementById("editEmail").value;

    let namePattern = /^[A-Za-zĀ-ž\s]+$/;
    let phonePattern = /^\+?\d{4,20}$/;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!namePattern.test(fname) || !namePattern.test(lname)) {
        alert("First name and Last name should contain only letters!");
        return false;
    }

    if (!phonePattern.test(phone)) {
        alert("Phone number should contain only digits and may start with '+'.\nPhone number should be from 4 to 20 digits long.");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Invalid email address!");
        return false;
    }

    return true;
}

// delete
function deleteUser(button) {
    let row = button.closest("tr");
    let userId = row.dataset.id;

    if (confirm("Are you sure you want to delete this user?")) {
        fetch('delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.remove();
                alert("User deleted successfully!");
            } else {
                alert("Error deleting user.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error deleting user.");
        });
    }
}