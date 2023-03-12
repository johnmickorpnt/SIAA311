<?php
session_start();
if (!isset($_SESSION["user"])) header("refresh:0;url=auth/customerlogin.php");
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
            <form action="" enctype="multipart/form-data" id="reserveForm">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:0.5rem; margin:0.5rem; align-items:center; padding:1rem">
                    <div class="custom-select" style="width:100%">
                        <select id="bank" name="bank">
                            <option value="0">Select Bank:</option>
                            <option value="1">Mlhuillier Financial Services Inc.</option>
                            <option value="2">Palawan Express</option>
                            <option value="3">Banco De Oro (BDO)/option>
                            <option value="4">United Coconut Planters Bank (UCPB)</option>
                            <option value="5">Bank of the Philippines Island (BPI)</option>
                            <option value="6">Metro Bank</option>
                            <option value="7">Security Bank (SB)</option>
                            <option value="8">RD Pawnshop Inc.</option>
                            <option value="9">Gcash</option>
                            <option value="10">Jazzpay.</option>
                            <option value="11">Philippine National Bank</option>
                            <option value="12">Union Bank</option>
                        </select>
                    </div>
                    <div class="txt_field">
                        <input type="text" placeholder="Account Number" id="account_number" name="account_number" min="10" max="10">
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="number" placeholder="Amount" id="amount" name="amount">
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="date" id="date" name="date" class="form-input" id="date" name="date" min="<?= date('Y-m-d', strtotime("+1 day")); ?>">
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="text" placeholder="Deposited Branch" id="deposited_branch" name="deposited_branch">
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="file" name="screenshot" id="screenshot">
                        <span></span>
                    </div>
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
</script>

</html>