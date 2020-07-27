let dropdownHeadingBtn = document.querySelector(".dropdown-heading");
let dropdownOptions = document.querySelectorAll(".dropdown-item");
let difference = document.getElementById("difference");
let positiveFeedback = document.querySelector(".onPlus");
let negativeFeedback = document.querySelector(".onMinus");
let period = document.querySelector(".period");
let sumOfIncomes = document.getElementById("incomes");
let sumOfExpenses = document.getElementById("expenses");

difference.textContent = (
  sumOfIncomes.textContent - sumOfExpenses.textContent
).toFixed(2);

const getFeedback = () => {
  if (difference.textContent > 0) {
    positiveFeedback.style.display = "inline";
    negativeFeedback.style.display = "none";
    difference.classList.add("bg-success");
    difference.classList.remove("bg-danger");
  } else {
    positiveFeedback.style.display = "none";
    negativeFeedback.style.display = "inline";
    difference.classList.add("bg-danger");
    difference.classList.remove("bg-success");
  }
};

getFeedback();

// Wykresy kołowe

// Load google charts
google.charts.load("current", { packages: ["corechart"] });

let chartWidth;

if (window.innerWidth > 1200) {
  chartWidth = 550;
} else if (window.innerWidth >= 768 && window.innerWidth <= 1200) {
  chartWidth = 400;
} else if (window.innerWidth < 768) {
  chartWidth = 350;
}

// Zmienne przypisane do poszczególnych kategorii
const salary = document.querySelector("#Salary");
const interest = document.querySelector("#Interest");
const allegro = document.querySelector("#Allegro");
const anotherIncomes = document.querySelector("#another-incomes");

const drawChartOfIncomes = () => {
  let data = google.visualization.arrayToDataTable([
    ["Kategoria", "Kwota"],
    ["Wynagrodzenie", salary != null ? parseFloat(salary.textContent) : 0], // Zamiana string na liczbę
    [
      "Odsetki bankowe",
      interest != null ? parseFloat(interest.textContent) : 0,
    ],
    [
      "Sprzedaż na allegro",
      allegro != null ? parseFloat(allegro.textContent) : 0,
    ],
    [
      "Inne",
      anotherIncomes != null ? parseFloat(anotherIncomes.textContent) : 0,
    ],
  ]);

  let options = { title: "Przychody", width: chartWidth, height: 400 };

  let chart = new google.visualization.PieChart(
    document.getElementById("piechart-incomes")
  );
  chart.draw(data, options);
};

// Zmienne przypisane do poszczególnych kategorii
const food = document.querySelector("#Food");
const apartments = document.querySelector("#Apartments");
const transport = document.querySelector("#Transport");
const telecommunication = document.querySelector("#Telecommunication");
const health = document.querySelector("#Health");
const clothes = document.querySelector("#Clothes");
const hygiene = document.querySelector("#Hygiene");
const kids = document.querySelector("#Kids");
const recreation = document.querySelector("#Recreation");
const trip = document.querySelector("#Trip");
const courses = document.querySelector("#Courses");
const books = document.querySelector("#Books");
const savings = document.querySelector("#Savings");
const retirement = document.querySelector("#retirement");
const debts = document.querySelector("#debt-repayment");
const gift = document.querySelector("#Gift");
const anotherExpenses = document.querySelector("#another-expenses");

const drawChartOfExpenses = () => {
  let data = google.visualization.arrayToDataTable([
    ["Kategoria", "Kwota"],
    ["Jedzenie", food != null ? parseFloat(food.textContent) : 0],
    ["Mieszkanie", apartments != null ? parseFloat(apartments.textContent) : 0],
    ["Transport", transport != null ? parseFloat(transport.textContent) : 0],
    [
      "Telekomunikacja",
      telecommunication != null ? parseFloat(telecommunication.textContent) : 0,
    ],
    ["Opieka zdrowotna", health != null ? parseFloat(health.textContent) : 0],
    ["Ubranie", clothes != null ? parseFloat(clothes.textContent) : 0],
    ["Higiena", hygiene != null ? parseFloat(hygiene.textContent) : 0],
    ["Dzieci", kids != null ? parseFloat(kids.textContent) : 0],
    ["Rozrywka", recreation != null ? parseFloat(recreation.textContent) : 0],
    ["Wycieczka", trip != null ? parseFloat(trip.textContent) : 0],
    ["Szkolenia", courses != null ? parseFloat(courses.textContent) : 0],
    ["Książki", books != null ? parseFloat(books.textContent) : 0],
    ["Oszczędności", savings != null ? parseFloat(savings.textContent) : 0],
    [
      "Na złotą jesień, czyli emeryturę",
      retirement != null ? parseFloat(retirement.textContent) : 0,
    ],
    ["Spłata długów", debts != null ? parseFloat(debts.textContent) : 0],
    ["Darowizna", gift != null ? parseFloat(gift.textContent) : 0],
    [
      "Inne wydatki",
      anotherExpenses != null ? parseFloat(anotherExpenses.textContent) : 0,
    ],
  ]);

  let options = { title: "Wydatki", width: chartWidth, height: 400 };

  let chart = new google.visualization.PieChart(
    document.getElementById("piechart-expenses")
  );
  chart.draw(data, options);
};

google.charts.setOnLoadCallback(drawChartOfIncomes);
google.charts.setOnLoadCallback(drawChartOfExpenses);
