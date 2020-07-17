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

const choosePeriod = () => {
  dropdownOptions.forEach((option) => {
    option.addEventListener("click", () => {
      let optionID = option.getAttribute("id");

      if (optionID == "current-month")
        period.textContent = "z bieżącego miesiąca";
      else if (optionID == "previous-month")
        period.textContent = "z poprzedniego miesiąca";
      else if (optionID == "current-year")
        period.textContent = "z bieżącego roku";
      else {
        period.textContent = "z wybranego okresu";
      }
    });
  });
};

getFeedback();
choosePeriod();

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
const salary = document.querySelector("#salary");
const interest = document.querySelector("#interest");
const allegro = document.querySelector("#allegro");
const anotherIncomes = document.querySelector("#another-incomes");

const drawChartOfIncomes = () => {
  let data = google.visualization.arrayToDataTable([
    ["Kategoria", "Kwota"],
    ["Wynagrodzenie", parseFloat(salary.textContent)], // Zamiana string na liczbę
    ["Odsetki bankowe", parseFloat(interest.textContent)],
    ["Sprzedaż na allegro", parseFloat(allegro.textContent)],
    ["Inne", parseFloat(anotherIncomes.textContent)],
  ]);

  let options = { title: "Przychody", width: chartWidth, height: 400 };

  let chart = new google.visualization.PieChart(
    document.getElementById("piechart-incomes")
  );
  chart.draw(data, options);
};

// Zmienne przypisane do poszczególnych kategorii
const food = document.querySelector("#food");
const apartments = document.querySelector("#apartments");
const transport = document.querySelector("#transport");
const telecommunication = document.querySelector("#telecommunication");
const health = document.querySelector("#health");
const clothes = document.querySelector("#clothes");
const hygiene = document.querySelector("#hygiene");
const kids = document.querySelector("#kids");
const recreation = document.querySelector("#recreation");
const trip = document.querySelector("#trip");
const courses = document.querySelector("#courses");
const books = document.querySelector("#books");
const savings = document.querySelector("#savings");
const retirement = document.querySelector("#retirement");
const debts = document.querySelector("#debt-repayment");
const gift = document.querySelector("#gift");
const anotherExpenses = document.querySelector("#another-expenses");

const drawChartOfExpenses = () => {
  let data = google.visualization.arrayToDataTable([
    ["Kategoria", "Kwota"],
    ["Jedzenie", parseFloat(food.textContent)],
    ["Mieszkanie", parseFloat(apartments.textContent)],
    ["Transport", parseFloat(transport.textContent)],
    ["Telekomunikacja", parseFloat(telecommunication.textContent)],
    ["Opieka zdrowotna", parseFloat(health.textContent)],
    ["Ubranie", parseFloat(clothes.textContent)],
    ["Higiena", parseFloat(hygiene.textContent)],
    ["Dzieci", parseFloat(kids.textContent)],
    ["Rozrywka", parseFloat(recreation.textContent)],
    ["Wycieczka", parseFloat(trip.textContent)],
    ["Szkolenia", parseFloat(courses.textContent)],
    ["Książki", parseFloat(books.textContent)],
    ["Oszczędności", parseFloat(savings.textContent)],
    ["Na złotą jesień, czyli emeryturę", parseFloat(retirement.textContent)],
    ["Spłata długów", parseFloat(debts.textContent)],
    ["Darowizna", parseFloat(gift.textContent)],
    ["Inne wydatki", parseFloat(anotherExpenses.textContent)],
  ]);

  let options = { title: "Wydatki", width: chartWidth, height: 400 };

  let chart = new google.visualization.PieChart(
    document.getElementById("piechart-expenses")
  );
  chart.draw(data, options);
};

google.charts.setOnLoadCallback(drawChartOfIncomes);
google.charts.setOnLoadCallback(drawChartOfExpenses);
