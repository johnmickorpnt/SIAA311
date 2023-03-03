// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = { 37: 1, 38: 1, 39: 1, 40: 1 };

function preventDefault(e) {
    e.preventDefault();
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

// modern Chrome requires { passive: false } when adding event
var supportsPassive = false;
try {
    window.addEventListener(
        "test",
        null,
        Object.defineProperty({}, "passive", {
            get: function () {
                supportsPassive = true;
            },
        })
    );
} catch (e) { }

var wheelOpt = supportsPassive ? { passive: false } : false;
var wheelEvent =
    "onwheel" in document.createElement("div") ? "wheel" : "mousewheel";


/** 
 * call this to Disable Scroll
 */
function disableScroll() {
    window.addEventListener("DOMMouseScroll", preventDefault, false); // older FF
    window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
    window.addEventListener("touchmove", preventDefault, wheelOpt); // mobile
    window.addEventListener("keydown", preventDefaultForScrollKeys, false);
}

// call this to Enable
function enableScroll() {
    window.removeEventListener("DOMMouseScroll", preventDefault, false);
    window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
    window.removeEventListener("touchmove", preventDefault, wheelOpt);
    window.removeEventListener("keydown", preventDefaultForScrollKeys, false);
}
/**
 * @param  {int} ms the milisecond on how long should it sleep
 */
function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
/**
 * @param  {int} ms
 * @param  {callback} fn
 * @param  {arguments} ...args
 */
async function sleep(ms, fn, ...args) {
    await timeout(ms);
    return fn(...args);
}

const modalToggles = document.querySelectorAll(".toggle-modal");
let modals = [];

window.addEventListener("load", () => {
    if (modalToggles.length > 0) {
        modalToggles.forEach(item => {
            item.addEventListener("click", () => {
                let activeModal = document.getElementById(item.getAttribute("modal-target"));
                let closeModal = activeModal.querySelector(".close-modal");
                closeModal.addEventListener("click", () => activeModal.close());
                activeModal.showModal();
            });
        });
    }
    function invalidRemove() {
        const invalids = document.querySelectorAll(".invalid");
        invalids.forEach(item => {
            item.addEventListener("click", () => item.remove());
        });
    }
});