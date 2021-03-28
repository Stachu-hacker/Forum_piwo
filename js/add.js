//show adding post form //
const add_btn = document.querySelectorAll(".add_button_post");
const form_add_post = document.querySelectorAll("#form_add_post");
const post = document.querySelector("#posts");
function hide() {
	form_add_post.forEach(element => {
		element.style.display = "none";
	});
}
add_btn.forEach((element, index) => {
	element.addEventListener("click", function (event) {
		hide();
		form_add_post[index].style.display = "block";
	});
});

//show adding subject form//
const add = document.querySelectorAll(".addtext");
const add_form = document.querySelectorAll(".add_form");
function hide() {
	add_form.forEach(element => {
		element.style.display = "none";
	});
}
add.forEach((element, index) => {
	element.addEventListener("click", function (event) {
		hide();
		add_form[index].style.display = "block";
	});
});

//hide when clicked elsewhere//
post.addEventListener("click", function (event) {
	if (event.currentTarget === event.target) {
		hide();
	}
});
