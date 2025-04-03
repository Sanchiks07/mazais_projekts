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
            <form method="POST">
                <input id="editId" value="${id}" hidden />
                <div class="input-group">
                    <label>
                        Vārds
                        <input id="editFirstName" value="${firstName}" required />
                    </label><br><br>

                    <label>
                        Uzvārds
                        <input id="editLastName" value="${lastName}" required />
                    </label><br><br>

                    <label>
                        Telefona Nr.
                        <input id="editPhone" value="${phone}" required />
                    </label><br><br>

                    <label>
                        E-pasts
                        <input type="email" id="editEmail" value="${email}" required />
                    </label><br><br>

                    <label>
                        Dzimšanas Diena
                        <input type="date" id="editBirthday" value="${birthday}" required />
                    </label><br><br>
                </div>
                <div class="popup-buttons">
                    <button type="button" id="saveChanges">Saglabāt</button>
                    <button type="button" id="cancelEdit">Atcelt</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(popup);

    document.getElementById("cancelEdit").addEventListener("click", function () {
        document.body.removeChild(popup);
    });

    document.getElementById("saveChanges").addEventListener("click", function () {
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
                alert("Lietotājs veiksmīgi atjaunots!");
            } else {
                alert("Kļūda atjaunojot lietotāju.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Kļūda atjaunojot lietotāju.");
        });
    });
}

// delete
function deleteUser(button) {
    let row = button.closest("tr");
    let userId = row.dataset.id;

    if (confirm("Vai tiešām vēlaties dzēst šo lietotāju?")) {
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
                alert("Lietotājs veiksmīgi dzēsts!");
            } else {
                alert("Kļūda dzēšot lietotāju.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Kļūda dzēšot lietotāju.");
        });
    }
}