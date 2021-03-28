//const for showing change profile photo form//
const btn = document.querySelector("#b_uc");
const form = document.querySelector("#change");
// const content = document.querySelector("#content");

//const for showing change background photo form//
const btn_b = document.querySelector("#b_ucb");
const form_b = document.querySelector("#change_b");

//const for showing block/onblock form//
const btn2_form = document.querySelector("#b_ub");
const btn3_send = document.querySelector("#b_ubb");
const form_blck = document.querySelector("#blck_form");

//on click shows clicked button and hides others//

btn?.addEventListener("click", () => {
	form_b.style.display = "none";
	form.style.display = "block";
	form_blck.style.display = "none";
});

btn_b?.addEventListener("click", () => {
	form_b.style.display = "block";
	form.style.display = "none";
	form_blck.style.display = "none";
});

btn3_send?.addEventListener("click", () => {
	form_blck.style.display = "block";
	if (btn) {
		form_b.style.display = "none";
		form.style.display = "none";
	}
});
if (btn2_form.dataset.activated == 0) {
	btn3_send.innerHTML = "Odblokuj konto";
} else {
	btn3_send.innerHTML = "Zablokuj konto";
}
