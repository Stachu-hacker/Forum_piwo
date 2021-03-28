//blocking buttons when no connection to database

const error = document.getElementById("error");
const button = document.getElementById("log_in");
const button2 = document.getElementById("register");
const button3 = document.getElementById("restart");
if (error && error.innerHTML === "Brak połącznia z bazą danych!") {
	button.disabled = true;
	button2.disabled = true;
	button3.disabled = true;
}
