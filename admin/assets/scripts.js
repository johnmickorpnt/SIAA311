const navToggle = document.getElementById("nav-toggle");
var toggled = false;
let mode = "view";
window.addEventListener("load", () => {
    navToggle.addEventListener("click", () => {
        toggled = !toggled ? true : false;
        let items = document.querySelectorAll(".nav-item");
        items.forEach(item => {
            let home = document.querySelector(".home");
            if (toggled) {
                home.style.display = "none";
                navToggle.innerHTML = `<i class="fa-solid fa-chevron-right"></i>
                                <i class="fa-solid fa-chevron-right"></i>`;
                item.querySelector("span").style.display = "none";
                home.style.display = "none";
            }
            else {
                home.style.display = "block";
                navToggle.innerHTML = `<i class="fa-solid fa-chevron-left"></i>
                                <i class="fa-solid fa-chevron-left"></i>`;
                item.querySelector("span").style.display = "flex";
            }
        })
    });

    let modal = document.querySelector(".form-modal");
    let viewBtn = document.querySelectorAll(".btn-view");
    let editBtn = document.querySelectorAll(".btn-edit");
    let deleteBtn = document.querySelectorAll(".btn-delete");
    let submitBtn = document.getElementById("submit-btn");
    let cancelBtn = document.getElementById("btn-cancel");
    let mainForm = document.getElementById("main-form");
    let addBtn = document.getElementById("btn-add");
    let idInput = document.getElementById("id-input");
    viewBtn.forEach(btn => {
        btn.addEventListener("click", () => {
            let id = btn.getAttribute("data-id");
            let table = btn.getAttribute("data-tbl");
            try {
                document.getElementById("password-input").style.display = "none";
                document.getElementById("password").setAttribute("disabled", true);
            } catch (error) {
                console.warn(error)
            }
            submitBtn.style.display = "block";
            idInput.style.display = "block";
            mode = "view";
            read(id, table);
            modal.showModal();
        });
    });

    editBtn.forEach(btn => {
        btn.addEventListener("click", () => {
            let id = btn.getAttribute("data-id");
            let table = btn.getAttribute("data-tbl");
            submitBtn.style.display = "block";
            idInput.style.display = "block";
            mode = "edit";
            read(id, table);
            try {
                document.getElementById("password-input").style.display = "none";
                document.getElementById("password").setAttribute("disabled", true);

            } catch (error) {
                console.warn(error);
            }
            modal.showModal();

        });
    });

    addBtn.addEventListener("click", function () {
        mode = "add";
        submitBtn.style.display = "block";
        idInput.style.display = "none";
        let inputs = mainForm.querySelectorAll("input");
        let selects = mainForm.querySelectorAll("select");
        
        inputs.forEach(input => {
            if(input.getAttribute("id") === "id") input.style.display = "none";
            else input.removeAttribute("disabled");
        });

        selects.forEach(select => {
            select.removeAttribute("disabled");
        });

        mainForm.reset();
        modal.showModal();
        try {
            document.getElementById("password-input").style.display = "block";
            document.getElementById("password").removeAttribute("disabled");
        } catch (error) {
            console.warn(error);
        }
    });

    deleteBtn.forEach(delBtn => {
        delBtn.addEventListener("click", function () {
            let id = delBtn.getAttribute("data-id");
            let table = delBtn.getAttribute("data-tbl");
            let conf = confirm(`Are you sure to delete this row (ID: ${id})?`);
            if (!conf) return;
            deleteRow(id, table);
        });
    });

    cancelBtn.addEventListener("click", function () {
        modal.close();
    });


    mainForm.addEventListener("submit", function (e) {
        e.preventDefault();
        let fd = new FormData(e.target);
        let obj = {};
        for (var pair of fd.entries()) {
            obj[pair[0]] = pair[1];
        }
        if (mode === "add")
            create(fd, obj["table-model"]);
        else if (mode === "edit")
            update(fd, obj["table-model"]);
        else alert("Mode undefined. Please reload the page.");
    });

    function fillForm(data) {
        console.log(data);
        let keys = Object.keys(data);
        let values = Object.values(data);
        for (let x = 0; x < keys.length; x++) {
            try {
                if (keys[x] === "image") {
                    document.getElementById("image-prev").setAttribute("src", `../../${values[x]}`);
                }
                if (document.getElementById(keys[x]).getAttribute("type") !== "file") {
                    if (keys[x] === "startTime" || keys[x] === "endTime") {
                        let date = new Date(values[x]);
                        document.getElementById(keys[x]).value = `${date.getHours()}:${date.getMinutes()}${date.getSeconds()}`;
                    }
                    else document.getElementById(keys[x]).value = values[x];

                }
                if (mode === "view" && keys[x] !== "id")
                    document.getElementById(keys[x]).setAttribute("disabled", true);
                else if (mode === "edit" && (keys[x] !== "id" && keys[x] !== "password")) {
                    document.getElementById(keys[x]).removeAttribute("disabled");
                }
                else if ((mode === "edit" || mode === "add") && (keys[x] === "startTime" || keys[x] === "endTime")) {

                }
            } catch (error) {
                console.warn(error);
            }
        }
    }

    // CRUD FUNCTIONS
    async function create(formData, model) {
        await fetch(`../functions/api/${model}/create.php`, {
            method: "POST",
            body: formData
        })
            .then((response) => response.json())
            .then((response) => {
                alert(response.status ? response.msg : response.errors);
                if (response.status)
                    window.location.reload();
            })
    }
    async function read(id, table) {

        await fetch("../functions/api/read.php", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "id": id,
                "table": table
            })
        })
            .then((response) => response.json())
            .then((response) => fillForm(response.data));
    }

    async function update(formData, model) {
        var formBody = [];
        for (var property in formData) {
            var encodedKey = encodeURIComponent(property);
            var encodedValue = encodeURIComponent(formData[property]);
            formBody.push(encodedKey + "=" + encodedValue);
        }
        formBody = formBody.join("&");
        formBody = formData

        await fetch(`../functions/api/${model}/update.php`, {
            method: "POST",
            body: formBody
        })
            .then((response) => response.json())
            .then((response) => {
                alert(response.status ? response.msg : response.errors);
                if (response.status)
                    window.location.reload();
            })
    }

    async function deleteRow(id, table) {
        await fetch("../functions/api/delete.php", {
            method: "DELETE",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "id": id,
                "table": table
            })
        })
            .then((response) => response.json())
            .then((response) => {
                alert(response.msg);
                window.location.reload();
            });
    }


    // Other functions
    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
    }

    
});