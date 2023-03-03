const xhttp = new XMLHttpRequest();
const mainContainer = document.getElementById("main-container");
const inputs = document.querySelectorAll(".form-input");
var mainForm = document.getElementById("form-reservation-finder");
const loadingModal = document.getElementById('loading-modal');
const msgModal = document.getElementById('msg-modal');
const closeModal = document.querySelector(".close-modal");
const confModal = document.getElementById("confirm-modal");
const cancelBtn = document.getElementById("cancel-btn");
const confirmBtn = document.getElementById("confirm-btn");

let gDate, gTime, gId;
xhttp.addEventListener("loadend", closeLoad);

// !-- EVENT LISTENERS BLOCK --!
window.addEventListener("load", () => {
    // confModal.showModal();
    flatpickr("input[type=date]", {
        minDate: new Date().fp_incr(1),
        defaultDate: new Date().fp_incr(1),
    });

    flatpickr("input[type=time]", {
        enableTime: true,
        noCalendar: true,
        defaultDate: "09:00",
        dateFormat: "H:i",
        minTime: "09:00",
        maxTime: "21:00"
    });
    queryTables();
});

closeModal.addEventListener("click", closeMsg);

inputs.forEach(input => {
    input.addEventListener("input", loadData);
});

cancelBtn.addEventListener("click", () => {
    if (confModal.open)
        confModal.close();
});

// !-- END OF EVENT LISTENERS BLOCK --!



// !-- FUNCTIONS BLOCK --!
function queryTables(data) {
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            const date = response["date"];
            const time = response["time"];
            render(response["map"]);

            // Add event listeners for each tables that are available
            const tbls = Array.from(document.getElementsByClassName('tbl-wrapper available'));
            tbls.forEach(tbl => {
                tbl.addEventListener("click", () => {
                    const childId = tbl.querySelector("svg").getAttribute("id");
                    const tblId = childId.substring(childId.lastIndexOf("-") + 1, childId.length);
                    gDate = date;
                    gTime = time;
                    gId = tblId;
                    confirmation(tblId, date, time);
                });
            });
        }
    };
    xhttp.open("POST", "apis/findReservation.php");
    xhttp.send(data !== undefined ? (isFormEmpty(data) ? "" : data) : "");
}

/**
 * @param  {date} date
 * @param  {date} time
 * @param  {int} id
 */
function confirmation(id, date, time) {
    console.log(id);
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    confModal.querySelector("#id-span").innerHTML = id;
    confModal.querySelector("#date-span").innerHTML = new Date(date).toLocaleDateString("en-US", options);
    confModal.querySelector("#time-span").innerHTML = time;
    confModal.showModal();
    confirmBtn.addEventListener("click", reserve, false);
}

function reserve() {
    const formData = new FormData();
    formData.append("date", gDate);
    formData.append("time", gTime);
    formData.append("tblId", gId);

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            loadData();
            confModal.close();
            showMsg(response["msg"]);
        }
    };
    xhttp.open("POST", "apis/reserve.php");
    xhttp.send(formData);
}
/**
 * @param  {text} content
 */
function render(content) {
    mainContainer.innerHTML = content;
}

function loadData() {
    showLoad();
    let data = new FormData(mainForm);
    queryTables(data);
}

function showLoad() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    loadingModal.showModal();
    disableScroll();
}

function closeLoad() {
    sleep(450, () => {
        loadingModal.close();
        enableScroll();
    });
}
/**
 * @param  {string} msg
 */
function showMsg(msg) {
    msgModal.querySelector("#msg").innerHTML = msg;
    window.scrollTo({ top: 0, behavior: 'smooth' });
    msgModal.showModal();
}

function closeMsg() {
    msgModal.close();
}
/**
 * @param  {formData} data
 */
var isFormEmpty = (data) => {
    let b = false;
    for (var pair of data.entries()) {
        if (pair[1].trim() === "") {
            b = true;
            break;
        }
    }
    return b;
}

// !-- END OF FUNCTIONS BLOCK --!

