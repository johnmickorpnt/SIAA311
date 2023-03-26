<?php
include("apis/pre-orders.php");
session_start();
if (!isset($_SESSION["user"])) header("refresh:0;url=auth/customerlogin.php");
$orders = json_decode(get_orders(), true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/reservation.css">
    <?php
    include("components/links.php");
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Hub'z Bistro Reservation</title>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <dialog id="menu-items" class="modal">
        <span class="close-modal" id="close-menu-modal" style="top:2rem;right:2rem">
            <i class="fa-solid fa-xmark"></i>
        </span>
        <section style="display: grid;grid-template-columns: 2fr 1fr; background: transparent;gap:1rem; height:100%; position:relative">
            <section class="card-content" style="width:100%; background:white;overflow:scroll;">
                <b>Selected Items</b>
                <div class="mini-menu-content">
                    <div class="pre-order-wrapper" id="pre-order-wrapper">
                        <?php
                        $grandTotal = 0;
                        if (!$orders["status"]) {
                            echo "Please make sure you have selected a dish for your reservation.";
                            return false;
                        } else {
                            foreach ($orders["body"] as $index => $order) {
                                $newTotal = (int)$order["price"] * (int)$order["quantity"];
                                $checked = $order["isActive"] ? "checked" : "";
                                echo <<<ROW
                                    <div class="pre-ordered-row">
                                        <div style="height:100%; display:flex; align-items:center; padding:1rem">
                                            <input type="checkbox" {$checked} class="orderCheck" data-id="{$order["id"]}"/>
                                        </div>
                                        <div>
                                            <h4>{$order["name"]}</h4>
                                            <div>
                                                <img src="{$order["image"]}" alt="{$order["name"]}" width="100%" height="100%">
                                            </div>
                                        </div>
                                        <div>
                                            <b>x{$order["quantity"]}</b>
                                        </div>
                                        <div>
                                            <b class="price">{$newTotal}</b>
                                        </div>
                                    </div>
                                ROW;
                                $grandTotal += $order["isActive"] ? $newTotal : 0;
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
            <section id="summary-tab">
                <h3 style="margin-top:2rem">Summary</h3>
                <?php
                $summaryTotal = 0;
                if (!$orders["status"]) {
                    echo "Please make sure you have selected a dish for your reservation.";
                    return false;
                } else if ($grandTotal <= 0) {
                    echo "<small style='color:red; font-weight:bold'>Please make sure you have selected a dish for your reservation.</small>";
                } else {
                    foreach ($orders["body"] as $index => $order) {
                        if (!$order["isActive"]) continue;
                        echo <<<ROW
                                <div class="summary-row summary-item-row">
                                    <span class="name">{$order["name"]}</span>
                                    <span>x{$order["quantity"]}</span>
                                    <span class="price item-price">{$order["price"]}</span>
                                </div>
                            ROW;
                    }
                }
                ?>
                <hr style="margin-top: auto;">
                <small style="color:red; font-weight:bold">
                    Please note that you will need to pay 50% of the grand total.
                </small>
                <div class="summary-row">
                    <div>
                        <h5>Grand Total:</h5>
                    </div>
                    <div style="grid-column-start:2; grid-column-end:-1;">
                        <h4 class="price">
                            <?php echo $grandTotal; ?>
                        </h4>
                    </div>
                </div>
                <div class="summary-row">
                    <div>
                        <h5>To be Payed :</h5>
                    </div>
                    <div>
                        <small style="color:red; font-weight:bold; text-align:center">
                            (50%)
                        </small>
                    </div>
                    <div>
                        <h3 class="price">
                            <?php echo .5 * (int)$grandTotal; ?>
                        </h3>
                    </div>
                </div>
                <!-- <button type="button" class="btn" style="background-color: #146C94; right:1rem; margin:0 !important;">
                    Save Selection
                </button> -->
                <button class="btn" style="background-color:red; width:100%; margin-top:.5rem !important" id="gotoPaymentBtn">Go to Payment</button>
            </section>
        </section>
    </dialog>
    <main class="container" style="padding:1%">
        <div style="padding:3rem">
            <h1>PAYMENT</h1>
            <div style="padding:1rem">
                <ul style="font-size: small; list-style: none; font-weight:bold;padding: 1rem; border-radius: 15px;border: solid rgba(0,0,255,0.5) .1rem; margin-bottom:0.25rem;">
                    <li>
                        <h3>REMINDERS</h3>
                    </li>
                    <li style="display:flex; align-items:center; gap:1rem; margin:0.5rem">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: large;"></i>
                        Make sure to make your payments at least 12 hours before.
                    </li>
                    <li style="display:flex; align-items:center; gap:1rem; margin:0.5rem">
                        <i class="fa-solid fa-circle-check" style="font-size: large;"></i>
                        All payments should be made only in the form of cash/manager cheque/cheque/bank transfer through accredited banks only.
                    </li>
                    <li style="display:flex; align-items:center; gap:1rem; margin:0.5rem">
                        <i class="fa-solid fa-circle-xmark" style="font-size: large;"></i>
                        Please do not hand over cash to any individuals including our staffs.
                    </li>
                </ul>
            </div>
            <form action="apis/payment.php" enctype="multipart/form-data" id="reserveForm" method="POST">
                <button type="button" class="btn" style="background-color: #146C94; right:1rem; margin:0 !important" id="selectedBtn">
                    View Selected Dishes to be Payed
                </button>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:0.5rem; margin:0.5rem; align-items:center; padding:1rem">
                    <div class="custom-select" style="width:100%">
                        <select id="bank" name="bank" required>
                            <option>Select Bank:</option>
                            <option value="Mlhuillier Financial Services Inc.">Mlhuillier Financial Services Inc.</option>
                            <option value="Palawan Express">Palawan Express</option>
                            <option value="Banco De Oro (BDO)">Banco De Oro (BDO)</option>
                            <option value="United Coconut Planters Bank (UCPB)">United Coconut Planters Bank (UCPB)</option>
                            <option value="Bank of the Philippines Island (BPI)">Bank of the Philippines Island (BPI)</option>
                            <option value="Metro Bank">Metro Bank</option>
                            <option value="Security Bank (SB)">Security Bank (SB)</option>
                            <option value="RD Pawnshop Inc.">RD Pawnshop Inc.</option>
                            <option value="Gcash">Gcash</option>
                            <option value="Jazzpay.">Jazzpay.</option>
                            <option value="Philippine National Bank">Philippine National Bank</option>
                            <option value="Union Bank">Union Bank</option>
                        </select>
                    </div>
                    <div class="txt_field">
                        <input type="text" placeholder="Account Number" id="account_number" name="account_number" min="10" max="10" required>
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="number" placeholder="Amount" id="amount" name="amount" step='0.01' readonly value="<?php echo .5 * (int)$grandTotal ?>" required>
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="date" id="date" name="date" class="form-input" id="date" name="date" min="<?= date('Y-m-d', strtotime("+1 day")); ?>" required>
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="text" placeholder="Deposited Branch" id="deposited_branch" name="deposited_branch" required>
                        <span></span>
                    </div>
                    <!-- <div class="txt_field">
                        <input type="file" name="screenshot" id="screenshot">
                        <span></span>
                    </div> -->
                </div>
                <button type="button" onclick="document.getElementById('reserveForm').reset()" style="width:100%;color:black; border-radius: 15px; border:0;padding:1rem" id="clearBtn">Clear</button>
                <input type="submit" style="width:100%">
            </form>
        </div>

        <!-- Show the menu -->
        <!-- Time and date -->
        <!-- Price -->
    </main>
</body>
<script>
    var x, i, j, l, ll, selElmnt, a, b, c;
    let menuModal = document.getElementById("menu-items");
    let closeModal = document.getElementById("close-menu-modal");
    let selectedBtn = document.getElementById("selectedBtn");
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);

    function clear() {
        let btn = document.getElementById("clearBtn");
        btn.addEventListener("click", function() {

        });
    }

    let gotoPaymentBtn = document.getElementById("gotoPaymentBtn");
    gotoPaymentBtn.addEventListener("click", () => {
        menuModal.close();
        var newURL = location.href.split("&")[0];
        window.history.pushState('object', document.title, newURL);
        location.reload();
    });

    document.addEventListener("DOMContentLoaded", () => {

        let field = 'menu';
        let url = window.location.href;
        if (url.indexOf('&' + field + '=') != -1) {
            menuModal.showModal();
            return true;
        }

        closeModal.addEventListener("click", () => {
            menuModal.close();
        });
        selectedBtn.addEventListener("click", () => {
            menuModal.showModal();
        });
    })

    let orderCheckBoxes = document.querySelectorAll(".orderCheck");
    orderCheckBoxes.forEach((element) => {
        element.addEventListener("click", (e) => {
            let elem = document.elementFromPoint(e.clientX, e.clientY)
            let id = elem.getAttribute("data-id");
            let isActive = elem.checked;
            console.log(id, isActive);
            let fd = new FormData();
            fd.append("data-id", id);
            fd.append("isActive", isActive);
            fetch("apis/check.php", {
                    method: "POST",
                    body: fd
                })
                .then((response) => response.json())
                .then((response) => {
                    // updateSummary(JSON.parse(response.data));
                    var url = window.location.href;
                    window.location.href += '&menu=1';
                })
        })
    });

    function updateSummary(data) {
        let items = document.querySelectorAll(".summary-item-row");
        let preOrderRows = document.querySelectorAll(".pre-ordered-row");
        let summaryWrapper = document.getElementById("summary-tab");

        // REMOVE ROW ITEMS
        items.forEach((element) => {
            element.remove();
        });
        summaryWrapper.innerHTML = "";

        // GENERATE ROW ITEMS
        let newRows = "";
        let newSummaryBody = `<h3 style="margin-top:2rem">Summary</h3>`;
        let selectWrapper = document.getElementById("pre-order-wrapper");
        let grandTotal = 0;
        let toBePayed = 0;
        for (item of data) {
            let newItemTotal = parseInt(item.price) * parseInt(item.quantity);
            let isActive = item.isActive ? "checked" : "";
            console.log(isActive)
            newRows += `<div class="pre-ordered-row">
                                        <div style="height:100%; display:flex; align-items:center; padding:1rem">
                                            <input type="checkbox" ${isActive} class="orderCheck" data-id="${item.id}"/>
                                        </div>
                                        <div>
                                            <h4>${item.name}</h4>
                                            <div>
                                                <img src="${item.image}" alt="${item.name}" width="100%" height="100%">
                                            </div>
                                        </div>
                                        <div>
                                            <b>x${item.quantity}</b>
                                        </div>
                                        <div>
                                            <b class="price">${newItemTotal}</b>
                                        </div>
                                    </div>`;
            if (!isActive) return false;
            newSummaryBody +=
                `
            <div class="summary-row summary-item-row">
                <span class="name">${item.name}</span>
                <span>x${item.quantity}</span>
                <span class="price item-price">${item.price}</span>
            </div>
            `;
            grandTotal += newItemTotal;
        }
        newSummaryBody +=
            `
        <hr style="margin-top: auto;">
            <small style="color:red; font-weight:bold">
                Please note that you will need to pay 50% of the grand total.
            </small>
            <div class="summary-row">
                <div>
                    <h5>Grand Total:</h5>
                </div>
                <div style="grid-column-start:2; grid-column-end:-1;">
                <h4 class="price">
                    ${grandTotal}
                </h4>
            </div>
        </div>
        <div class="summary-row">
                <div>
                    <h5>To be Payed :</h5>
                </div>
                <div>
                    <small style="color:red; font-weight:bold; text-align:center">
                        (50%)
                    </small>
                </div>
                <div>
                <h3 class="price">
                    ${parseInt(grandTotal) * 0.5}
                </h3>
            </div>
        </div>
        <button class="btn" style="background-color:red; width:100%; margin-top:.5rem !important">Go to Payment</button>
        `;
        selectWrapper.innerHTML = newRows;
        summaryWrapper.innerHTML = newSummaryBody;
    }
</script>

</html>