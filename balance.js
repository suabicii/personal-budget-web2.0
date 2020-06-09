let dropdownHeadingBtn = document.querySelector(".dropdown-heading");
let dropdownOptions = document.querySelectorAll(".dropdown-item");
let difference = document.getElementById("difference");
let positiveFeedback = document.querySelector(".onPlus");
let negativeFeedback = document.querySelector(".onMinus");
let period = document.querySelector(".period");
let sumOfIncomes = document.getElementById("incomes");
let sumOfExpenses = document.getElementById("expenses");
// let modal = document.getElementById("modal");
// let closeModalBtn = document.querySelector(".close");
// let customDateForm = document.querySelector("form");

difference.textContent = sumOfIncomes.textContent - sumOfExpenses.textContent;

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
        modal.style.display = "block";
      }
    });
  });
};

// Modal

// closeModalBtn.addEventListener("click", () => (modal.style.display = "none"));
/* customDateForm.addEventListener("submit", (evt) => {
  evt.preventDefault();
  modal.style.display = "none";
}); */

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

const drawChartOfIncomes = () => {
  let data = google.visualization.arrayToDataTable([
    ["Kategoria", "Kwota"],
    ["Wynagrodzenie", 5000],
    ["Odsetki bankowe", 300],
    ["Sprzedaż na allegro", 1000],
    ["Inne", 1000],
  ]);

  let options = { title: "Przychody", width: chartWidth, height: 400 };

  let chart = new google.visualization.PieChart(
    document.getElementById("piechart-incomes")
  );
  chart.draw(data, options);
};

const drawChartOfExpenses = () => {
  let data = google.visualization.arrayToDataTable([
    ["Kategoria", "Kwota"],
    ["Jedzenie", 600],
    ["Mieszkanie", 1000],
    ["Transport", 300],
    ["Telekomunikacja", 45],
    ["Opieka zdrowotna", 80],
    ["Ubranie", 225],
    ["Higiena", 44],
    ["Dzieci", 0],
    ["Rozrywka", 24],
    ["Wycieczka", 0],
    ["Szkolenia", 38],
    ["Książki", 24],
    ["Oszczędności", 100],
    ["Na złotą jesień, czyli emeryturę", 500],
    ["Spłata długów", 0],
    ["Darowizna", 100],
    ["Inne wydatki", 200],
  ]);

  let options = { title: "Wydatki", width: chartWidth, height: 400 };

  let chart = new google.visualization.PieChart(
    document.getElementById("piechart-expenses")
  );
  chart.draw(data, options);
};

google.charts.setOnLoadCallback(drawChartOfIncomes);
google.charts.setOnLoadCallback(drawChartOfExpenses);
